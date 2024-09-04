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
        Schema::table('section_employee', function (Blueprint $table) {
            $table->foreign(['employee_id', 'customer_id'], 'fk_employee_section_employee')
                  ->references(['id', 'customer_id'])->on('employee')->onDelete('CASCADE')->onUpdate('RESTRICT');

            $table->foreign(['section_id', 'customer_id'], 'fk_section_section_employee')
                  ->references(['id', 'customer_id'])->on('section')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('section_employee', function (Blueprint $table) {
            $table->dropForeign('fk_employee_section_employee');
            $table->dropForeign('fk_section_section_employee');
        });
    }
};
