<?php

namespace App\Http\Traits;

use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Exception;

trait StripeTrait
{
    //
    private function setupStripe()
    {
        return new \Stripe\StripeClient(config('cashier.secret')); // create config file
    }
    // Create Price and Product id
    public function createPrice(Request $request)
    {
        // @dd($request);
        try {
            $productData = [
                'name' => $request->name,
                // 'description' => $request->description,
                'statement_descriptor' => config('constants.statement_descriptor.subscription'),
                'tax_code' => config('constants.tax_code')
            ];
            // dd( $productData );
            $defaultPriceData = [
                'currency' => config('cashier.currency'),  // create config file
                'unit_amount' => (float)($request->is_free ? 0 : $request->price) * 100,
                'recurring' => [
                    // 'interval'          => 'month', //month,yearly,day
                    // 'interval_count'    =>  $request->interval,
                    'interval'          => 'day', //month,yearly,day
                    'interval_count'    =>  1,
                    'usage_type'        => 'metered'  // we can use metered or licence
                ],
                'product_data'  =>  $productData
            ];
            // dd($defaultPriceData);
            return $this->setupStripe()->prices->create($defaultPriceData);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function updateProduct(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $price = null;
        try {
            $updateProduct = [
                'name' => $request->name,
                'description' => $request->description,
                // 'active' => ($request->status == 'ACTIVE') ? true : false
            ];
            $updatedPrice = (float)($request->is_free ? 0 : $request->price);
            $updatedIntervalCount = $request->interval;
            // <> is an inequality operator in many programming languages, including PHP. It is used to check if two values are not equal !=.

            // if ($subscriptionPlan->price != $updatedPrice || $subscriptionPlan->interval_count != $updatedIntervalCount) {}

            if ($subscriptionPlan->price <> $updatedPrice || $subscriptionPlan->interval_count <> $updatedIntervalCount) {
                $price =  $this->setupStripe()->prices->create([
                    'currency' => config('cashier.currency'),
                    'product' => $subscriptionPlan->stripe_product_id,
                    'unit_amount_decimal' => $updatedPrice * 100,
                    'recurring' => [
                        'interval' => 'month', //month,yearly,day
                        'interval_count'  =>  intval($request->interval),
                        'usage_type'        => 'metered'
                    ],
                ]);
                $updateProduct['default_price'] = $price->id;
                // $stripe->prices->update($subscriptionPlan->stripe_price, ['active' => true]);
            }
            return $this->updateStripeProduct($subscriptionPlan, $updateProduct);
        } catch (\Throwable $th) {
            if (!is_null($price)) {
                $this->setupStripe()->prices->update($price->id, [
                    'active' => false
                ]);
            }

            throw new Exception($th->getMessage());
        }
    }

    public function updateStripeProduct(SubscriptionPlan $subscriptionPlan, $params)
    {
        try {
            return $this->setupStripe()->products->update($subscriptionPlan->stripe_product_id, $params);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
}
