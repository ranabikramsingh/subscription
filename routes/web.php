<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    SubscriptionController,
    StripeWebhookController,
    LoginController,
    SubscriptionPlanController,
    SubscripctionPlanController,
    
};

use Illuminate\Support\Facades\{Auth};
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes([
    'verify' => True,
]);
Route::get('/', function () {
    // return view('welcome');
    return view('loginpage');
});
// Route::post('stripe/webhook', 'StripeWebhookController@handleWebhook')->name('cashier.webhook')->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
Route::post('stripe/webhook', [StripeWebhookController::class, 'handleWebhook'])
->name('cashier.webhook')
->middleware(WithoutMiddleware::class);

// Route::post('subscription-plan', 'SubscriptionController@store')->name('subscriptionplan');
// Route::post('subscribeplan', 'SubscriptionController@buyPlan')->name('subscribe');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::middleware(['auth'])->group(function () {
    //Your routes here
    
    // Route::get('subscription-createpage', [SubscriptionPlanController::class, 'CreateplanPage'])->name('subscription.createpage');
    Route::get('subscription-createpage', [SubscriptionPlanController::class, 'subscriptionList'])->name('subscription.createpage');

    Route::match(['get', 'post'], 'subscription-create', [SubscriptionPlanController::class, 'store'])->name('subscription.create');
    Route::post('subscribeplan', [SubscriptionPlanController::class, 'buyPlan'])->name('subscribe');

    // Route for SubscriptionPlan
    Route::prefix('/subscription')->name("subscriptions.")->controller(SubscripctionPlanController::class)->group(function () {
        Route::get('list', 'subscriptionList')->name('list');
        Route::any('add/{id?}', 'store')->name('add');
        // Route::post('payment', 'paymentmethod')->name('payment');
        Route::post('/delete', 'delete')->name('delete');
        Route::match(['get', 'post'
        ], '/search', 'searchData')->name('search');
        Route::post('/statusupdate', 'updateStatus')->name('status');
    });

});

