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
        Schema::create('job_visibility', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('customer_id');
            $table->enum('access', ['read', 'write'])->default('write');
            $table->enum('enabled', ['Y', 'N'])->default('Y');

            $table->index(['employee_id', 'customer_id'], 'fk_employee_job_visibility_idx');
            $table->index(['job_id', 'customer_id'], 'fk_job_job_visibility_idx');
            $table->primary(['job_id', 'employee_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_visibility');
    }
};
