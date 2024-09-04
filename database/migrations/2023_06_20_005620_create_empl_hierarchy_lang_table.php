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
        Schema::create('empl_hierarchy_lang', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_hierarchy_id');
            $table->unsignedInteger('level');
            $table->string('lang_code', 2)->index('fk_language_empl_hierarchy_lang_idx');
            $table->string('name', 64);

            $table->index(['employee_hierarchy_id', 'level'], 'fk_empl_hierarchy_empl_hierarchy_lang_idx');
            $table->unique(['employee_hierarchy_id', 'level', 'lang_code'], 'uq_empl_hierarchy_lang_lang');
            $table->unique(['employee_hierarchy_id', 'lang_code', 'name'], 'uq_empl_hierarchy_lang_name');
        });

        // Add the CHECK constraints.
        DB::statement('ALTER TABLE `empl_hierarchy_lang` ADD CONSTRAINT `chk_empl_hierarchy_lang_name` CHECK (CHAR_LENGTH(TRIM(`name`)) > 0);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empl_hierarchy_lang');
    }
};
