<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('discounts_products', function (Blueprint $table) {
            // $table->unsignedInteger('discount_id');
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discounts_products', function (Blueprint $table) {
            $table->dropForeign(['discount_id']); // Loại bỏ ràng buộc khóa ngoại
        });
    }
};
