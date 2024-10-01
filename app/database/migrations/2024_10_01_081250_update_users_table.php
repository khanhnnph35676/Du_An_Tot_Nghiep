<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Thêm khoá ngoại cho cột rule_id
            $table->foreign('rule_id')->references('id')->on('rules')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Nếu muốn, có thể xóa cả cột rule_id
            $table->dropColumn('rule_id');
        });
    }
};
