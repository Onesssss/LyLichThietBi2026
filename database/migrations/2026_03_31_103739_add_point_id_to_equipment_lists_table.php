<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPointIdToEquipmentListsTable extends Migration
{
    public function up()
    {
        Schema::table('equipment_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('point_id')->nullable()->after('id');
            // $table->foreign('point_id')->references('id')->on('points')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('equipment_lists', function (Blueprint $table) {
            $table->dropColumn('point_id');
        });
    }
}