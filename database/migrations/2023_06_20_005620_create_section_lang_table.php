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
        Schema::create('section_lang', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->bigIncrements('id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('lang_code', 2)->index('fk_language_section_lang_idx');
            $table->string('name', 64);

            $table->unique(['customer_id', 'lang_code', 'name'], 'uq_section_lang_name');
            $table->index(['section_id', 'customer_id'], 'fk_section_section_lang_section_id_idx');
        });

        // Add the CHECK constraints.
        DB::statement('ALTER TABLE `section_lang` ADD CONSTRAINT `chk_section_lang_name` CHECK (CHAR_LENGTH(TRIM(`name`)) > 0);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_lang');
    }
};
