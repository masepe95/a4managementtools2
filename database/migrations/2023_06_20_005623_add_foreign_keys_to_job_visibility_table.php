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
        Schema::table('job_visibility', function (Blueprint $table) {
            $table->foreign(['employee_id', 'customer_id'], 'fk_employee_job_visibility')
                  ->references(['id', 'customer_id'])->on('employee')->onDelete('CASCADE')->onUpdate('RESTRICT');

            $table->foreign(['job_id', 'customer_id'], 'fk_job_job_visibility')
                  ->references(['id', 'customer_id'])->on('job')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_visibility', function (Blueprint $table) {
            $table->dropForeign('fk_employee_job_visibility');
            $table->dropForeign('fk_job_job_visibility');
        });
    }
};
