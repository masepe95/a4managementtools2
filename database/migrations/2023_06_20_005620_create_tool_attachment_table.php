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
        Schema::create('tool_attachment', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->bigIncrements('id');
            $table->string('filename');
            $table->unsignedBigInteger('id_tool')->index('fk_tool_tool_attachment_idx');
            $table->mediumText('data_file')->charset('binary');  // MEDIUMBLOB.
            $table->string('mime_type', 32);
            $table->unsignedInteger('file_size');
            $table->enum('attachment_type', ['file', 'link'])->default('file');

            $table->unique(['id_tool', 'filename'], 'uq_tool_attachment_filename');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tool_attachment');
    }
};
