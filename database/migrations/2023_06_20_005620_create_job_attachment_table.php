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
        Schema::create('job_attachment', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->bigIncrements('id');
            $table->string('filename');
            $table->unsignedBigInteger('job_id')->index('fk_job_job_attachment_idx');
            $table->mediumText('data_file')->charset('binary');
            $table->string('mime_type', 32);
            $table->unsignedInteger('file_size');
            $table->enum('attachment_type', ['file', 'link'])->default('file');

            $table->unique(['filename', 'job_id'], 'uq_job_attachment_filename');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_attachment');
    }
};
