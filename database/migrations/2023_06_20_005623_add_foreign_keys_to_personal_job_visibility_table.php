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
        Schema::table('personal_job_visibility', function (Blueprint $table) {
            $table->foreign(['employee_id'], 'fk_employee_personal_job_visibility')
                  ->references(['id'])->on('employee')->onDelete('CASCADE')->onUpdate('RESTRICT');

            $table->foreign(['personal_job_id', 'employee_id'], 'fk_personal_job_personal_job_visibility')
                  ->references(['id', 'employee_id'])->on('personal_job')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personal_job_visibility', function (Blueprint $table) {
            $table->dropForeign('fk_employee_personal_job_visibility');
            $table->dropForeign('fk_personal_job_personal_job_visibility');
        });
    }
};
