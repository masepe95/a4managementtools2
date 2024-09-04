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
        Schema::table('res_employee_res_access', function (Blueprint $table) {
            $table->foreign(['employee_id'], 'fk_employee_res_employee_res_access')
                  ->references(['id'])->on('employee')->onDelete('CASCADE')->onUpdate('RESTRICT');

            $table->foreign(['resource_access_name'], 'fk_resource_access_res_employee_res_access')
                  ->references(['name'])->on('resource_access')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('res_employee_res_access', function (Blueprint $table) {
            $table->dropForeign('fk_employee_res_employee_res_access');
            $table->dropForeign('fk_resource_access_res_employee_res_access');
        });
    }
};
