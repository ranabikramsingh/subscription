<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Laravel\Cashier\Subscription as BaseSubscription;

class Subscription extends BaseSubscription
{
    public $timestamps = true;
    protected $fillable = ['user_id', 'stripe_status', 'quantity', 'name', 'stripe_id', 'stripe_price', 'ends_at', 'type', 'trail_ends_at', 'plan_id', 'raw_data'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function subscriptionPlan()
    {

        return SubscriptionPlan::where('name', $this->type)->where('stripe_price_id', $this->stripe_price)->first();
        // return $this->belongsTo(SubscriptionPlan::class,'plan_id', 'id');
    }

    // public function subscriptionPlan()
    // {
    //     return $this->belongsTo(SubscriptionPlan::class, 'plan_id', 'id');
    // }

    // * raw data for savind data of plan
    protected function rawData(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value),
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $request)
    {
        return $query->when($request->search, function ($query) use ($request) {
            $search = $request->search;
            $query->where(function ($query) use ($search) {
                $query->where('type', 'LIKE', "%$search%")
                    ->orWhere('stripe_status', 'LIKE', "%$search%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%$search%")
                            ->orWhere('email', 'LIKE', "%$search%");
                    });
            });
        });
    }
}
