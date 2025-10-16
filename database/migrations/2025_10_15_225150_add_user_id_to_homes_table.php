<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // เพิ่มคอลัมน์ user_id (ให้ nullable ไว้ เผื่อยังไม่ได้ล็อกอิน)
        if (!Schema::hasColumn('homes', 'user_id')) {
            Schema::table('homes', function (Blueprint $table) {
                $table->foreignId('user_id')
                      ->nullable()
                      ->constrained('users')
                      ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('homes', 'user_id')) {
            Schema::table('homes', function (Blueprint $table) {
                // บาง DB อาจต้อง dropForeign ก่อน
                // $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            });
        }
    }
};
