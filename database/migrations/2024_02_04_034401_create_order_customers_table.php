<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('order_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->on('orders');
            $table->foreignId('customer_id')->constrained()->on('customers');
            $table->string('phone')->nullable();
            $table->string('city_name')->nullable();
            $table->string('township_name')->nullable();
            $table->string('address_detail')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('order_customers');
    }
};
