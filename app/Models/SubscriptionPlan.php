<?php

namespace App\Models;

use App\Http\Traits\Encryptable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory, Encryptable;
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'is_free',
        'billing_cycle',
        'interval',
        'stripe_product_id',
        'stripe_price_id',
        'status',
    ];

    protected $appends = ['secure_id', 'valid_for'];

    //*Accessor for valid_for
    protected function validFor(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if ($attributes['interval'] > 1)
                    return $attributes['interval'] . ' ' . ucfirst($attributes['billing_cycle'] . 's');
                else
                    return $attributes['interval'] . ' ' . ucfirst($attributes['billing_cycle']);
            }
        );
    }
    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
