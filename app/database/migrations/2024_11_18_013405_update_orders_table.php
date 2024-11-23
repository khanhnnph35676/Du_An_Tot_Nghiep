<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->unsignedInteger('address_id');
            $table->dropColumn('product_id');
            $table->dropColumn('name');
            $table->decimal('sum_price', 8, 2);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('address_id');
            $table->unsignedInteger('product_id');
            $table->string('name');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }
};
