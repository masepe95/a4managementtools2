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
        Schema::table('personal_job', function (Blueprint $table) {
            $table->foreign(['employee_id', 'tool_id'], 'fk_employee_personal_tool_personal_job')
                  ->references(['employee_id', 'tool_id'])->on('employee_personal_tool')->onDelete('CASCADE')->onUpdate('RESTRICT');

            $table->foreign(['lang_code'], 'fk_language_personal_job')
                  ->references(['code'])->on('language')->onDelete('RESTRICT')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personal_job', function (Blueprint $table) {
            $table->dropForeign('fk_employee_personal_tool_personal_job');
            $table->dropForeign('fk_language_personal_job');
        });
    }
};
