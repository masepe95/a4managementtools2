<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_hierarchy_lang', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_id')->index('fk_job_job_hierarchy_lang_idx');
            $table->unsignedInteger('level');
            $table->string('lang_code', 2)->index('fk_language_job_hierarchy_lang_idx');
            $table->string('name', 64);

            $table->unique(['job_id', 'level', 'lang_code'], 'uq_job_hierarchy_lang_lang');
            $table->unique(['job_id', 'lang_code', 'name'], 'uq_job_hierarchy_lang_name');
        });

        // Add the CHECK constraints.
        DB::statement('ALTER TABLE `job_hierarchy_lang` ADD CONSTRAINT `chk_job_hierarchy_lang_name` CHECK (CHAR_LENGTH(TRIM(`name`)) > 0);');
        DB::statement('ALTER TABLE `job_hierarchy_lang` ADD CONSTRAINT `chk_job_hierarchy_lang_level` CHECK (`level` >= 1 AND `level` <= 4);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_hierarchy_lang');
    }
};
