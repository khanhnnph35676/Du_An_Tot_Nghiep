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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('payment_id');
            $table->enum('status', ['1', '2','3','4','5'])->nullable();
            /*
             1 là Xác nhận đơn hàng
             2 là Đang được giao
             3 là Đã được giao
             4 là đã được đánh giá -> hoàn tất
             5 là bị huỷ
            */
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
