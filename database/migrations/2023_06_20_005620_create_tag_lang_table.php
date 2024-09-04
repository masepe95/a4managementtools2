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
        Schema::create('tag_lang', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->bigIncrements('id');
            $table->unsignedBigInteger('tag_id')->index('fk_tag_tag_lang_idx');
            $table->string('lang_code', 2)->default('it')->index('fk_language_tag_lang_idx');
            $table->string('tag_name');

            $table->unique(['tag_id', 'lang_code'], 'uq_tag_lang_lang_code');
            $table->unique(['tag_name'], 'uq_tag_lang_tag_name');
            $table->fullText(['tag_name'], 'fts_tag_lang_tag_name');
        });

        // Add the CHECK constraints.
        DB::statement('ALTER TABLE `tag_lang` ADD CONSTRAINT `chk_tool_tag_tag_name` CHECK (CHAR_LENGTH(TRIM(`tag_name`)) > 0);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag_lang');
    }
};
