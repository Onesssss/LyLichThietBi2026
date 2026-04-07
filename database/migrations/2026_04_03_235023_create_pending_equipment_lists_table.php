<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingEquipmentListsTable extends Migration
{
    public function up()
    {
        Schema::create('pending_equipment_lists', function (Blueprint $table) {
            $table->id();
            
            // ID bản ghi gốc (nếu là update/delete)
            $table->unsignedBigInteger('original_id')->nullable();
            
            // Dữ liệu (giống bảng equipment_lists)
            $table->string('name', 200);
            $table->string('code', 50);
            $table->unsignedBigInteger('point_id');
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1);
            
            // Thông tin yêu cầu
            $table->enum('action_type', ['create', 'update', 'delete'])->default('create');
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            
            // Người yêu cầu
            $table->unsignedBigInteger('requested_by');
            $table->timestamp('requested_at')->useCurrent();
            
            // Người duyệt
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pending_equipment_lists');
    }
}