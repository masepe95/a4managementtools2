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
        Schema::table('personal_employee_group', function (Blueprint $table) {
            $table->foreign(['group_employee_id', 'customer_id'], 'fk_employee_personal_employee_group')
                  ->references(['id', 'customer_id'])->on('employee')->onDelete('CASCADE')->onUpdate('RESTRICT');

            $table->foreign(['group_id', 'employee_owner_id', 'customer_id'], 'fk_personal_group_personal_employee_group')
                  ->references(['id', 'employee_id', 'customer_id'])->on('personal_group')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personal_employee_group', function (Blueprint $table) {
            $table->dropForeign('fk_employee_personal_employee_group');
            $table->dropForeign('fk_personal_group_personal_employee_group');
        });
    }
};
