<?php

use App\Models\Products;
use App\Models\ProductSizes;
use App\Models\PromoCodes;
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
        Schema::create('product_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('booking_trx_id');
            $table->string('city');
            $table->string('post_code');
            $table->string('proof');
            $table->foreignIdFor(ProductSizes::class);
            $table->text('address');
            $table->unsignedBigInteger('quantity');
            $table->unsignedBigInteger('sub_total_amount');
            $table->unsignedBigInteger('grand_total_amount');
            $table->unsignedBigInteger('discount_amount');
            $table->boolean('is_paid');
            $table->foreignIdFor(model: Products::class);
            $table->foreignIdFor(PromoCodes::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_transactions');
    }
};
