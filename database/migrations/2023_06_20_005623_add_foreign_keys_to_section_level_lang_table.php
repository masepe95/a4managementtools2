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
        Schema::table('section_level_lang', function (Blueprint $table) {
            $table->foreign(['lang_code'], 'fk_language_section_level_lang')
                  ->references(['code'])->on('language')->onDelete('RESTRICT')->onUpdate('RESTRICT');

            $table->foreign(['customer_id', 'level'], 'fk_section_level_section_level_lang')
                  ->references(['customer_id', 'level'])->on('section_level')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('section_level_lang', function (Blueprint $table) {
            $table->dropForeign('fk_language_section_level_lang');
            $table->dropForeign('fk_section_level_section_level_lang');
        });
    }
};
