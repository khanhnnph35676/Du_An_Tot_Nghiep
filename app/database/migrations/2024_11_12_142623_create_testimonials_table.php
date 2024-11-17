<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();  // Khóa chính tự động tăng
            $table->string('title');  // Tiêu đề testimonial
            $table->unsignedInteger('user_id');  // ID người dùng (khóa ngoại)
            $table->integer('star');  // Đánh giá sao
            $table->boolean('status')->default(1);  // Trạng thái (mặc định 1)
            $table->text('description');  // Mô tả chi tiết testimonial
            $table->timestamps();  // Thêm created_at, updated_at
            $table->softDeletes();  // Thêm tính năng xóa mềm

            // Khóa ngoại cho user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Thêm cột product_id và tạo khóa ngoại
            $table->unsignedInteger('product_id')->nullable();  // Cột product_id có thể null
            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('set null')  // Khi sản phẩm bị xóa, đặt product_id thành null
                ->onUpdate('cascade');  // Cập nhật khi bảng products thay đổi
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('testimonials');
    }
};
