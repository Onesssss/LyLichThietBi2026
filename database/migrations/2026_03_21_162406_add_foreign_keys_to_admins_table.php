<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
      {
        Schema::table('admins', function (Blueprint $table) {
            // Thêm foreign key cho branch_id
            if (!Schema::hasColumn('admins', 'branch_id')) {
                $table->foreignId('branch_id')->nullable()->after('business');
            }
            
            if (!Schema::hasColumn('admins', 'dept_id')) {
                $table->foreignId('dept_id')->nullable()->after('branch_id');
            }
            
            // Thêm khóa ngoại
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->foreign('dept_id')->references('id')->on('departments')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropForeign(['dept_id']);
        });
    }
};
