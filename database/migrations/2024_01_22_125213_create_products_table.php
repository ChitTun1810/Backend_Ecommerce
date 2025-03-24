<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->nullable();
            $table->integer('stocks')->nullable();
            $table->foreignId('brand_id')->nullable()->constrained();
            $table->foreignId('category_id')->nullable()->constrained();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('sub_child_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->integer('price')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_new_arrival')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('sub_category_id')->references('id')->on('categories');
            $table->foreign('sub_child_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
