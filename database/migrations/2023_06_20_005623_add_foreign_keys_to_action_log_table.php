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
        Schema::table('action_log', function (Blueprint $table) {
            $table->foreign(['employee_id'], 'fk_employee_action_log')
                  ->references(['id'])->on('employee')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('action_log', function (Blueprint $table) {
            $table->dropForeign('fk_employee_action_log');
        });
    }
};
