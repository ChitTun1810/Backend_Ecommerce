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
        Schema::table('product_inquiries', function (Blueprint $table) {
            $table->string('name')->nullable()->after('product_id');
            $table->string('phone')->nullable()->after('name');
            $table->string('email')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_inquiries', function (Blueprint $table) {
            $table->dropColumn(['name', 'phone', 'email']);
        });
    }
};
