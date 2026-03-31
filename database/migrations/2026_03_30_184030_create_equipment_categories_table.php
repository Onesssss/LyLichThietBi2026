<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('equipment_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->foreignId('list_id')->constrained('equipment_lists')->onDelete('cascade');
            $table->tinyInteger('status')->default(1)->comment('1: Hoạt động, 0: Vô hiệu');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipment_categories');
    }
}