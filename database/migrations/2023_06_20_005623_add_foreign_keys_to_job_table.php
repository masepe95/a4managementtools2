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
        Schema::table('job', function (Blueprint $table) {
            $table->foreign(['customer_id', 'tool_id'], 'fk_customer_tool_job')
                  ->references(['customer_id', 'tool_id'])->on('customer_tool')->onDelete('CASCADE')->onUpdate('RESTRICT');

            $table->foreign(['editor_id', 'customer_id'], 'fk_employee_job')
                  ->references(['id', 'customer_id'])->on('employee')->onDelete('RESTRICT')->onUpdate('RESTRICT');

            $table->foreign(['lang_code'], 'fk_language_job')
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
        Schema::table('job', function (Blueprint $table) {
            $table->dropForeign('fk_customer_tool_job');
            $table->dropForeign('fk_employee_job');
            $table->dropForeign('fk_language_job');
        });
    }
};
