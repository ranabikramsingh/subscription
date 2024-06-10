<?php

namespace App\Http\Controllers;
// namespace App\Http\Controllers\Common;
use App\Http\Controllers\Controller;
use App\Models\{User, UserDetail, SubscriptionPlan, Subscription};
use Illuminate\Support\Facades\{Hash, Validator, Auth};
use App\Http\Traits\SubscriptionTrait;
use App\Http\Requests\{SubscriptionRequest, PaymentRequest};
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;

use Illuminate\Http\Request;

class SubscripctionPlanController extends Controller
{
    use SubscriptionTrait;
    // Create Plan
    public function store(SubscriptionRequest $request, SubscriptionPlan $id = null)
    {
        // @dd('hii');
        try {
            if ($request->method() == 'GET' && $request->subs_ID) {

                $planDetails = SubscriptionPlan::find($request->subs_ID);
                return response()->json([
                    'status'    =>  true,
                    'message'   => 'Data fetched successfully.',
                    'data'      => [
                        'subs_id' => encryptID($planDetails->id),
                        'name'  =>  $planDetails->name,
                        'price' =>  $planDetails->price,
                        'interval'  =>  $planDetails->interval,
                        'description' =>  $planDetails->description,
                    ]
                ]);
            }

            // Validation rules

            $id = request()->input('subs_id', null);
            if ($id) {
                // Log::info($request->toArray());
                // dd($id);
                $this->updateSubscription($request, $id);
                return response()->json([
                    'status'    =>  true,
                    'message' => 'Subscription plan has been updated successfully',
                    'data'  =>  [
                        // 'redirect_to'   =>  route('subscriptions.list')
                        'redirect_to'   =>  route('subscription.createpage')
                    ]
                ]);
            } else {
                // @dd($request);
                $subscriptionPlan = $this->addSubscription($request);
                return response()->json([
                    'status'    =>  true,
                    'message' => 'Subscription plan added successfully',
                    'data'  =>  [
                        'redirect_to'   =>  route('subscription.createpage')
                    ]
                ]);
            }
        } catch (\Exception $e) {
            $data = [
                'status' => 'danger',
                'error' => $e->getMessage(),
                'redirect' => [
                    'redirect_to'   =>  route('subscription.createpage')
                ]
            ];

            return response()->json($data, 500);
        }
    }
    // Listing Plan
    public function subscriptionList(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        // $users = SubscriptionPlan::search($request)->orderByDesc('created_at')->paginate(config('constants.PAGINATION_NUMBER'));
        $users = SubscriptionPlan::paginate(config('constants.PAGINATION_NUMBER'));
        return view('admin.subscriptionplan.subscription', compact('users'));
    }
    // Buy plan page
    public function SubscriptionPlans(){
        $plans = SubscriptionPlan::active()->get();
        // dd($plans);
        return view("common.subscription_plan", compact('plans'));
    }


    // function for admin only gives subscription table data
    /* public function subscriptionRecord( Request $request)
    {
        $authuser = auth()->user();
        if($authuser->hasRole('admin'))
        {
        $subscription_data = Subscription::search($request)
        ->orderByDesc('created_at')
        ->paginate(config('constants.PAGINATION_NUMBER'));
        return view('common.subscription_record.listing', compact('subscription_data'));
    }
    else
        {
            return redirect()->back();
        }
    }*/

    // Subscribe plan payment Card page
    public function paymentMethod(Request $request, $id)
    {
        try{
        $plan = SubscriptionPlan::findSecureOrFail($id);

        $stripeCustomer = null;
        $setupIntent = null;
        $user = Auth::user();
        $stripeCustomer = $user->createOrGetStripeCustomer();  // Stripe function default
        
        // $stripeCustomer =  $user->createAsStripeCustomer();
        $intent = $user->createSetupIntent();
        $type = $request->_token;

        return view("common.payment-method",compact('plan','stripeCustomer','intent', 'type'));

        }catch(Exception $e){

            return  $e->getMessage();
        }
    }

    // Subscribe plan not free
    public function upgrade(Request $request, SubscriptionPlan $plan)
    {
        dd($request->all(), $plan->toArray());

        try {
            $user = Auth::user();

            $this->upgradeSubscription($request,$user,$plan);

            return redirect()->route('user.membership.plans');

        }
        catch (IncompletePayment $exception) {

            return redirect()->route('user.membership.plans');
        }
        catch (\Throwable $th) {
            // dd($th->getMessage());
            return redirect()->back()->with(['status' => false, 'message' => $th->getMessage()]);
        }


    }
    // Plan free
    public function subscribe(PaymentRequest $request, SubscriptionPlan $subscription)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $this->createSubscription($request, $user, $subscription);
            DB::commit();
            return redirect()->route('dashboard');
            // return redirect()->route('admin.subscriptions.payment.success', ['subscription' => $subscription->id]);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withInput($request->all())->with(['status' => 'danger', 'message' => $th->getMessage()]);
        }
    }
}
