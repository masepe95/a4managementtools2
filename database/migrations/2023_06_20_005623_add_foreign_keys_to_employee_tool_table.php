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
        Schema::table('employee_tool', function (Blueprint $table) {
            $table->foreign(['customer_id', 'tool_id'], 'fk_customer_tool_employee_tool')
                  ->references(['customer_id', 'tool_id'])->on('customer_tool')->onDelete('CASCADE')->onUpdate('RESTRICT');

            $table->foreign(['customer_id', 'employee_id'], 'fk_employee_employee_tool')
                  ->references(['customer_id', 'id'])->on('employee')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_tool', function (Blueprint $table) {
            $table->dropForeign('fk_customer_tool_employee_tool');
            $table->dropForeign('fk_employee_employee_tool');
        });
    }
};
