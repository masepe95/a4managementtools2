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
        Schema::table('job_attachment', function (Blueprint $table) {
            $table->foreign(['job_id'], 'fk_job_job_attachment')
                  ->references(['id'])->on('job')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_attachment', function (Blueprint $table) {
            $table->dropForeign('fk_job_job_attachment');
        });
    }
};
