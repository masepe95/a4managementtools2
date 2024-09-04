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
        Schema::create('personal_job_visibility', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->unsignedBigInteger('personal_job_id');
            $table->unsignedBigInteger('employee_id')->index('fk_employee_personal_job_visibility_idx');
            $table->enum('enabled', ['Y', 'N'])->default('Y');

            $table->index(['personal_job_id', 'employee_id'], 'fk_personal_job_personal_job_visibility_idx');
            $table->primary(['personal_job_id', 'employee_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_job_visibility');
    }
};
