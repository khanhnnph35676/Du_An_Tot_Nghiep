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
        Schema::table('variant_options', function (Blueprint $table) {
            // Kiểm tra nếu khóa ngoại tồn tại rồi mới xóa
            if (Schema::hasColumn('variant_options', 'product_variant_id')) {
                $table->dropForeign(['product_variant_id']);
                $table->dropColumn('product_variant_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('variant_options', function (Blueprint $table) {
            // Thêm lại cột và khóa ngoại
            $table->unsignedInteger('product_variant_id')->nullable(); // Sử dụng kiểu unsignedBigInteger
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade');
        });
    }
};
