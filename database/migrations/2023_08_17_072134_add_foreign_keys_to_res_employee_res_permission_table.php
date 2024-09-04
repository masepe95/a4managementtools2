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
        Schema::table('res_employee_res_permission', function (Blueprint $table) {
            $table->foreign(['employee_id', 'resource_access_name'], 'fk_employee_access_employee_permission')
                  ->references(['employee_id', 'resource_access_name'])->on('res_employee_res_access')->onDelete('CASCADE')->onUpdate('RESTRICT');

            $table->foreign(['resource_access_name', 'resource_permission_name'], 'fk_resource_permission_employee_permission')
                  ->references(['resource_name', 'name'])->on('resource_permission')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('res_employee_res_permission', function (Blueprint $table) {
            $table->dropForeign('fk_employee_access_employee_permission');
            $table->dropForeign('fk_resource_permission_employee_permission');
        });
    }
};
