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
        Schema::table('section_lang', function (Blueprint $table) {
            $table->foreign(['lang_code'], 'fk_language_section_lang')
                  ->references(['code'])->on('language')->onDelete('RESTRICT')->onUpdate('RESTRICT');

            $table->foreign(['section_id', 'customer_id'], 'fk_section_section_lang_section_id')
                  ->references(['id', 'customer_id'])->on('section')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('section_lang', function (Blueprint $table) {
            $table->dropForeign('fk_language_section_lang');
            $table->dropForeign('fk_section_section_lang_section_id');
        });
    }
};
