<?php

namespace App\Http\Traits;

use App\Models\{CometServer, CometUserClient, Company, Order, Payment, Plan, ServerPlan, ServerPlanUser, SubscriptionPlan, User, UserCard, Tax};
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;
use App\Notifications\SubscriptionPlanPurchased;
use Laravel\Cashier\Exceptions\IncompletePayment;

trait SubscriptionTrait
{
    use StripeTrait;

    private function addSubscription(Request $request)
    {
        try {
            $price = $this->createPrice($request);
            // @dd($price);
            return SubscriptionPlan::create([
                'user_id' => auth()->user()->id,
                'name' => $request->name,
                'description' => $request->description,
                'price' => (float)($request->is_free ? 0 : $request->price),
                'billing_cycle' => request('billing_cycle', 'Month'),
                'interval' => $request->interval,
                // 'trial_days' => $request->trial,
                'status' => $request->status ?? 1,
                'is_free'   =>  $request->input('is_free', 0),
                'stripe_product_id' => $price->product,
                'stripe_price_id' => $price->id
            ]);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
    
    // call from subbscripctionPlanController for update plan
    private function updateSubscription(Request $request,  $id)
    {
        try {
            $SubscriptionPlan = SubscriptionPlan::findSecureOrFail($id);
            $product = $this->updateProduct($request, $SubscriptionPlan);
            return $this->subscriptionUpdate($request, $SubscriptionPlan, $product);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    private function addDetail(Request $request, User $user)
    {
        try {
            $user->detail()->updateOrCreate([
                'user_id' => $user->id
            ], [
                'company_name' => $request->company_name,
                'country_id' => $request->country,
                'state_id' => $request->state,
                'city' => $request->city,
                'address1' => $request->address1,
                'address2' => $request->address2,
                'postal_code' => $request->postal_code,
            ]);

            $user = $user->fresh();

            return $user;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    private function createSubscription($request, $user, $plan)
    {
        DB::beginTransaction();
        try {
            $user->createOrGetStripeCustomer();
            $user->syncStripeCustomerDetails();
            $paymentMethod = $user->addPaymentMethod($request->payment_method);
            $subscribe = $user->newSubscription($plan->name)
                ->meteredPrice($plan->stripe_price_id);

            if (!is_null($plan->trial_days) && $plan->trial_days > 0) {
                $subscribe = $subscribe->trialDays($plan->trial_days);
            }
            if ($request->has('free_coupon_code')) {
                $subscribe = $subscribe->withCoupon($request->free_coupon_code);
            }
            $customerOptions = $this->getCustomerOptions($user);
            $subscriptionOptions = $this->getSubscriptionOptions($user, $plan);
            /* Auth::user()->charge(
                ($plan->price)*100,
                $request->payment_method,
                ['off_session' => true] // Pass the off_session option
            ); */
            $response = $subscribe->create($request->payment_method, $customerOptions, $subscriptionOptions);
            $response->update([
                'plan_id' => $plan->id,
                'raw_data' => [
                    'name' => $plan->name,
                    'price' => $plan->price,
                    'interval' => $plan->interval,
                    'cycle' => $plan->billing_cycle,
                ]
            ]);
            $defaultCard = 0;
            if (!is_null($user->cards) && !$user->cards->count())
                $defaultCard = 1;
            $card = $this->addUpdateCard($user, $paymentMethod, $defaultCard);
            /* Add usage */
            Cashier::stripe()->subscriptionItems->createUsageRecord(
                $response->items->first()->stripe_id,
                [
                    'quantity' => 1,
                    'action' => 'increment'
                ]
            );
            // $order = $this->addOrderPayment($user, $plan, $card, $response);
            // $response->user->notify( new SubscriptionPlanPurchased( $response ) );
            DB::commit();

            return $response;
        } catch (\Throwable $th) {
            DB::rollback();
            throw new Exception($th->getMessage());
        }
    }

    private function subscriptionUpdate($request, $plan, $product)
    {
        try {
            $plan->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => (float)($request->is_free ? 0 : $request->price),
                'billing_cycle' =>  request('billing_cycle', 'Month'),
                'interval' => $request->interval,
                // 'trial_days' => $request->trial,
                // 'status' => $request->status,
                'is_free'   =>  $request->input('is_free', 0),
                'stripe_product_id' => $product->id,
                'stripe_price_id' => $product->default_price,
            ]);

            return $plan;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }


    private function upgradeSubscription(Request $request, User $user, SubscriptionPlan $plan)
    {
        try {
            $paymentMethod = $user->addPaymentMethod($request->payment_method);
            $user->updateDefaultPaymentMethod($request->payment_method);
            $subscription = $user->getSubscription()->active()->first();
            $subscription->skipTrial()->swapAndInvoice($plan->stripe_price_id, [
                'default_payment_method' => $paymentMethod->card_token
            ]);
            $subscription->update([
                'plan_id' => $plan->id,
                'type' => $plan->name,
            ]);
        } catch (IncompletePayment $exception) {
            // Handle incomplete payment
            // Redirect the user to complete the payment process
            return redirect($exception->payment->invoice->hosted_invoice_url);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    private function attachPaymentMethod(Request $request, User $user)
    {
        if ($request->has('payment_method')) {
            $paymentMethod = $user->addPaymentMethod($request->payment_method);

            return $this->addUpdateCard($user, $paymentMethod);
        } elseif ($request->has('card')) {

            return $this->getCard($user, $request->card);
        }

        throw new Exception('Card not found');
    }

    public function addOrderPayment(User $user, SubscriptionPlan $plan, UserCard $card, $response, $currentPlan = null)
    {
        try {
            $subscription = $user->stripeSubscription($response->stripe_id);
            $lastInvoice = $user->getInvoice($subscription->latest_invoice);
            $expiryDate = Carbon::createFromTimestamp($subscription->current_period_end);
            $trialDate = $subscription->trial_end ? Carbon::createFromTimestamp($subscription->trial_end) : null;
            $paidAmount = $lastInvoice->amount_paid / 100;
            $orderData = [
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'subscription_id' => $response->id,
                'product_amount' => $plan->price,
                'paid_amount' => $paidAmount,
                'purchase_type' => !is_null($currentPlan) ? 'UPGRADE' : 'NEW',
                'old_plan_id' => !is_null($currentPlan) ? $currentPlan->id : null,
                'status' => ('active' == $response->stripe_status) ? 'COMPLETED' : 'PENDING',
                'expiry_date' => $expiryDate,
                'trial_ends_at' => $trialDate,
            ];
            $order = Order::create($orderData);
            $payment = Payment::create([
                'gateway_id' => config('constants.gateway.stripe'),
                'user_id' => $user->id,
                'order_id' => $order->id,
                'user_card_id' => $card->id,
                'invoice_id' => $subscription->latest_invoice,
                'amount' => $paidAmount,
                'received_on' => 'STRIPE',
                'status' => $response->stripe_status,
                'stripe_response' => $response,
            ]);

            Order::whereId($order->id)->update([
                'payment_id' => $payment->id,
            ]);

            Company::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'subscription_plan_id' => $plan->id,
                'subscription_id' => $response->id,
                'payment_id' => $payment->id,
                'status' => $response->stripe_status,
                'expiry_date' => $expiryDate,
                'trial_ends_at' => $trialDate,
            ]);

            return $payment;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    private function getCard($user, $cardId)
    {
        try {
            $userCard = $user->cards->find($cardId);
            $today = Carbon::now();
            if ($userCard->exp_year > $today->format('Y')) {
                return $userCard;
            } elseif ($userCard->exp_year == $today->format('Y') && $userCard->exp_month >= $today->format('m')) {
                return $userCard;
            } else {
                return $user->cards->where('is_default', 1)->firstOrFail();
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    private function addUpdateCard(User $user, $paymentMethod, $defaultCard = 0)
    {
        if (0 == $user->cards->count()) {
            $defaultCard = 1;
        }

        return $user->cards()->updateOrCreate([
            'user_id' => $user->id,
            'fingerprint' => $paymentMethod->card->fingerprint,
        ], [
            'brand' => $paymentMethod->card->brand,
            'card_token' => $paymentMethod->id,
            'exp_month' => $paymentMethod->card->exp_month,
            'exp_year' => $paymentMethod->card->exp_year,
            'last_digits' => $paymentMethod->card->last4,
            'is_default' => $defaultCard,
        ]);
    }

    private function getSubscriptionOptions(User $user, $plan)
    {
        return [
            'automatic_tax' => ['enabled' => false],
            'metadata' => [
                'plan_id' => $plan->id,
                'price' => $plan->price,
            ],
        ];
    }

    private function getCustomerOptions(User $user)
    {
        return [];
    }
}
