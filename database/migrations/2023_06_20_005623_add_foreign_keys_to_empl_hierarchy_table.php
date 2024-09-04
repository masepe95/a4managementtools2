<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empl_hierarchy', function (Blueprint $table) {
            $table->foreign(['employee_hierarchy_id'], 'fk_employee_hierarchy_empl_hierarchy')
                  ->references(['id'])->on('employee_hierarchy')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empl_hierarchy', function (Blueprint $table) {
            $table->dropForeign('fk_employee_hierarchy_empl_hierarchy');
        });
    }
};
