<?php

use App\Http\Controllers\BasicUserController;
use App\Http\Controllers\Common\SubscriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Common\UserController;

Route::middleware(['auth'])->group(function () {
    /* Route for managing users */
    Route::middleware(['is_subscribed'])->prefix('user')->controller(UserController::class)->name("users.")->group(function () {
        Route::get('/list', 'listing')->name('list');
        Route::get('/sub-user-list/{forUser?}', 'listing')->name('sub-user-list');
        Route::post('/add-update', 'addUpdate')->name('add-update');
        Route::post('/delete', 'delete')->name('delete');
        Route::post('/fetch-data',  'fetchdata')->name('fetch-data');
        Route::post('/statusupdate', 'updateStatus')->name('status');
        Route::match(['get', 'post'], '/search', 'searchData')->name('search');
    });

    //* managing noSubscription Users
    //* for buying subscription
    Route::prefix('subscription')->controller(SubscriptionController::class)->name("subscription.")->group(function () {
        Route::get('/subscription-plans', 'SubscriptionPlans')->name('subscription.plans');
        Route::get('/payment-method/{id?}', 'paymentMethod')->name('payment.method');
        Route::post('/subscribe/{subscription}', 'subscribe')->name('subscribe');
        Route::post('/cancel/{plan?}', 'unsubscibe')->name('cancel');
        Route::post('upgrade/{plan}', 'upgrade')->name('upgrade');
    });
});
