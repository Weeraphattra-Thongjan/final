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
    Schema::create('comments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('home_id')->constrained('homes')->onDelete('cascade'); // เชื่อมโยงกับ home table
        $table->text('content'); // เนื้อหาของคอมเมนต์
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ผู้ตอบคอมเมนต์
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('comments');
}
};
