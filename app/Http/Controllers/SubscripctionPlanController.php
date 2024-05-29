<?php

namespace App\Http\Controllers;
// namespace App\Http\Controllers\Common;
// use App\Http\Controllers\Controller;
use App\Models\{User, UserDetail, SubscriptionPlan, Subscription};
use Illuminate\Support\Facades\{Hash, Validator, Auth};
use App\Http\Traits\SubscriptionTrait;
use App\Http\Requests\SubscriptionRequest;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;

use Illuminate\Http\Request;

class SubscripctionPlanController extends Controller
{
    use SubscriptionTrait;
    //
    public function subscriptionList(Request $request)
    {   
        $user = auth()->user();
        $id = $user->id;
        $users = SubscriptionPlan::search($request)->orderByDesc('created_at')->paginate(config('constants.PAGINATION_NUMBER'));
        return view('admin.subscriptionplan.subscription', compact('users'));
    }

    // function for admin only gives subscription table data
    public function subscriptionRecord(Request $request)
    {
        $subscription_data = Subscription::search($request)
            ->orderByDesc('created_at')
            ->paginate(config('constants.PAGINATION_NUMBER'));
        return view('common.subscription_record.listing', compact('subscription_data'));
    }

    public function store(SubscriptionRequest $request, SubscriptionPlan $id = null)
    {
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
                dd($id);
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
}
