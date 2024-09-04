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
        Schema::create('section_level_lang', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedInteger('level');
            $table->string('lang_code', 2)->index('fk_language_section_level_lang_idx');
            $table->string('name', 64);

            $table->index(['customer_id', 'level'], 'fk_section_level_section_level_lang_idx');
            $table->unique(['customer_id', 'lang_code', 'level'], 'uq_section_level_lang_level');
            $table->unique(['customer_id', 'lang_code', 'name'], 'uq_section_level_lang_name');
        });

        // Add the CHECK constraints.
        DB::statement('ALTER TABLE `section_level_lang` ADD CONSTRAINT `chk_section_level_lang_name` CHECK (CHAR_LENGTH(TRIM(`name`)) > 0);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_level_lang');
    }
};
