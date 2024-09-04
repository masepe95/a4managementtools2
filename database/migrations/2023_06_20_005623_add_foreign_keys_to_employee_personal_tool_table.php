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
        Schema::table('employee_personal_tool', function (Blueprint $table) {
            $table->foreign(['employee_id'], 'fk_employee_employee_personal_tool')
                  ->references(['id'])->on('employee')->onDelete('CASCADE')->onUpdate('RESTRICT');

            $table->foreign(['tool_id'], 'fk_tool_employee_personal_tool')
                  ->references(['id'])->on('tool')->onDelete('RESTRICT')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_personal_tool', function (Blueprint $table) {
            $table->dropForeign('fk_employee_employee_personal_tool');
            $table->dropForeign('fk_tool_employee_personal_tool');
        });
    }
};
