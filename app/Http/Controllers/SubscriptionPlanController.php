<?php

namespace App\Http\Controllers;

use App\Models\{User, SubscriptionPlan, Subscription};
use App\Http\Traits\SubscriptionTrait;
use App\Http\Requests\SubscriptionRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionPlanController extends Controller
{
    //
    use SubscriptionTrait;

    /*public function CreateplanPage()
    {
        // dd(auth()->user()->id);
        // return view('auth.subscriptionplan');
        $user = auth()->user();
        $id = $user->id;
        $users = SubscriptionPlan::paginate(config('constants.PAGINATION_NUMBER'));
        return view('auth.subscriptionplan', compact('users'));
    }*/
  
    // listing
    public function subscriptionList(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        // $users = SubscriptionPlan::search($request)->orderByDesc('created_at')->paginate(config('constants.PAGINATION_NUMBER'));
        $users = SubscriptionPlan::paginate(config('constants.PAGINATION_NUMBER'));
        return view('admin.subscriptionplan.subscription', compact('users'));
    }
    // Add/Update 
    public function store($request, SubscriptionPlan $id = null)
    {
        // @dd($request->subs_ID);
        // @dd($request);
        // Assuming $request is an instance of Illuminate\Http\Request
        $validator = Validator::make($request, [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'interval' => 'required|string|max:25',
            'description' => 'required|string',
        ], [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a number',
            'interval.required' => 'Interval is required',
            'interval.string' => 'Interval must be a string',
            'interval.max' => 'Interval cannot exceed 25 characters',
            'description.required' => 'Description is required',
            'description.string' => 'Description must be a string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            
            // Return validation errors
            // return response()->json($validator->errors(), 422);
            // return redirect()->back()->withErrors($validator)->first();
            return redirect()->back()->withErrors($validator)->with('message', 'Validation failed.');

        }
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


            $id = request()->input('subs_id', null);
            // @dd($request->id);
            if ($id) {
                $this->updateSubscription($request, $id);
                return response()->json([
                    'status'    =>  true,
                    'message' => 'Subscription plan has been updated successfully',
                    'data'  =>  [
                        'redirect_to'   =>  route('subscriptions.list')
                    ]
                ]);
            } else {
                // @dd($request);
                $subscriptionPlan = $this->addSubscription($request);
                // @dd($subscriptionPlan);
                /*return response()->json([
                    'status'    =>  true,
                    'message' => 'Subscription plan added successfully',
                    'data'  =>  [
                        'redirect_to'   =>  route('subscriptions.list')
                    ]
                ]);*/
                if($subscriptionPlan){
                    // $successMessage = 'Create Successfull plan';
                    // Session::flash('success', $successMessage);
                    // return view('auth.subscriptionplan')->with('successMessage', 'Add Success Plan');
                    return redirect()->route('subscription.createpage')->with('successMessage', 'Add Success Plan');


                }
            }
        } catch (\Exception $e) {
            /*$data = [
                'status' => 'danger',
                'error' => $e->getMessage(),
                'redirect' => [
                    'redirect_to' => route('subscriptions.list')
                ]
            ];
            return response()->json($data, 500);
            */
            $errorMessage = $e->getMessage();
            return view('auth.subscriptionplan', compact('errorMessage'));
            
        }
    }
}
