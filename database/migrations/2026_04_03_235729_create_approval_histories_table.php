<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('approval_histories', function (Blueprint $table) {
            $table->id();
            $table->string('pending_table', 100);           // Tên bảng pending (equipment_lists, categories, items)
            $table->unsignedBigInteger('pending_id');       // ID trong bảng pending
            $table->string('action_type', 20);              // create, update, delete
            $table->string('action_result', 20);            // approved, rejected
            $table->unsignedBigInteger('approved_by');      // ID người duyệt
            $table->timestamp('approved_at')->useCurrent();
            $table->text('rejection_reason')->nullable();   // Lý do từ chối (nếu có)
            
            // Index để tìm kiếm nhanh
            $table->index(['pending_table', 'pending_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('approval_histories');
    }
}