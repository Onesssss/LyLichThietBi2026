<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');        // Người nhận thông báo
            $table->string('title', 255);                  // Tiêu đề thông báo
            $table->text('message');                       // Nội dung
            $table->string('type', 50);                    // Loại: approval_request, approved, rejected
            $table->unsignedBigInteger('related_id')->nullable(); // ID liên quan (pending_id)
            $table->string('related_table')->nullable();   // Tên bảng liên quan
            $table->boolean('is_read')->default(false);    // Đã đọc chưa
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}