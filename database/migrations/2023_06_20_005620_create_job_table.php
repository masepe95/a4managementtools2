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
        Schema::create('job', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('tool_id');
            $table->unsignedBigInteger('editor_id');
            $table->string('lang_code', 2)->index('fk_language_job_idx');
            $table->unsignedTinyInteger('level_count');
            $table->string('level1_value', 128);
            $table->string('level2_value', 128)->default('');
            $table->string('level3_value', 128)->default('');
            $table->string('level4_value', 128)->default('');
            $table->json('job_data');
            $table->dateTime('job_inserted')->useCurrent();
            $table->dateTime('job_updated')->useCurrentOnUpdate()->nullable();
            $table->dateTime('job_deleted')->nullable();
            $table->enum('send_email', ['Y', 'N'])->default('N');
            $table->enum('status', ['inProgress', 'published', 'archived'])->default('inProgress');

            $table->index(['customer_id', 'tool_id'], 'fk_customer_tool_job_idx');
            $table->index(['editor_id', 'customer_id'], 'fk_employee_job_idx');
            $table->unique(['id', 'customer_id'], 'uq_job_customer_id');
            $table->unique(['customer_id', 'tool_id', 'level1_value', 'level2_value', 'level3_value', 'level4_value'], 'uq_job_levels');
        });

        // Add the CHECK constraints.
        DB::statement('ALTER TABLE `job` ADD CONSTRAINT `chk_job_level_count` CHECK (`level_count` >= 1 AND `level_count` <= 4);');
        DB::statement('ALTER TABLE `job` ADD CONSTRAINT `chk_job_level1_value` CHECK (CHAR_LENGTH(TRIM(`level1_value`)) > 0);');
        DB::statement('ALTER TABLE `job` ADD CONSTRAINT `chk_job_level2_value` CHECK (CHAR_LENGTH(IF(`level_count` < 2, `level2_value`, TRIM(`level2_value`))) > 0 XOR `level_count` < 2);');
        DB::statement('ALTER TABLE `job` ADD CONSTRAINT `chk_job_level3_value` CHECK (CHAR_LENGTH(IF(`level_count` < 3, `level3_value`, TRIM(`level3_value`))) > 0 XOR `level_count` < 3);');
        DB::statement('ALTER TABLE `job` ADD CONSTRAINT `chk_job_level4_value` CHECK (CHAR_LENGTH(IF(`level_count` < 4, `level4_value`, TRIM(`level4_value`))) > 0 XOR `level_count` < 4);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job');
    }
};
