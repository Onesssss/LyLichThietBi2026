<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentItemsTable extends Migration
{
    public function up()
    {
        Schema::create('equipment_items', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('code', 50)->unique();
            $table->foreignId('category_id')->constrained('equipment_categories')->onDelete('cascade');
            $table->string('material', 100)->nullable();
            $table->string('unit', 50)->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('manufacture_year')->nullable();
            $table->date('expiry_date')->nullable();
            $table->tinyInteger('condition')->default(1)->comment('1: Tốt, 2: Trung bình, 3: Hỏng');
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1: Hoạt động, 0: Vô hiệu');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipment_items');
    }
}