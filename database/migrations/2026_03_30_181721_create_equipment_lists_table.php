<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentListsTable extends Migration
{
    public function up()
    {
        Schema::create('equipment_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1: Hoạt động, 0: Vô hiệu');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipment_lists');
    }
}