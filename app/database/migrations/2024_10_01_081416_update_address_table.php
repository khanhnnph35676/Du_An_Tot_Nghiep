<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('address', function (Blueprint $table) {
            // Thêm khoá ngoại cho cột rule_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::table('address', function (Blueprint $table) {
            // Xoá khoá ngoại của cột rule_id trước khi rollback
            $table->dropForeign(['user_id']);
        });
    }
};
