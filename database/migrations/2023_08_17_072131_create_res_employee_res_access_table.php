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
        Schema::create('res_employee_res_access', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->unsignedBigInteger('employee_id')->index('fk_employee_res_employee_res_access_idx');
            $table->string('resource_access_name', 64)->index('fk_resource_access_res_employee_res_access_idx');

            $table->primary(['employee_id', 'resource_access_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('res_employee_res_access');
    }
};
