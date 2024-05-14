<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->string('name', 100)->nullable();
            $table->longtext('description')->nullable();
            $table->string('price', 20)->nullable();
            $table->boolean('is_free')->nullable()->default(0);
            $table->string('billing_cycle', 50)->nullable();
            $table->string('interval', 20)->nullable();
            $table->string('stripe_product_id', 100)->nullable();
            $table->string('stripe_price_id', 100)->nullable();
            $table->boolean('status')->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
