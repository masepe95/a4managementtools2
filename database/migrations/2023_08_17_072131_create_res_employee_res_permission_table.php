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
        Schema::create('res_employee_res_permission', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->unsignedBigInteger('employee_id');
            $table->string('resource_access_name', 64);
            $table->string('resource_permission_name', 64);

            $table->index(['employee_id', 'resource_access_name'], 'fk_employee_access_employee_permission_idx');
            $table->index(['resource_access_name', 'resource_permission_name'], 'fk_resource_permission_employee_permission_idx');
            $table->primary(['employee_id', 'resource_access_name', 'resource_permission_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('res_employee_res_permission');
    }
};
