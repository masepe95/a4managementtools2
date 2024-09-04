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
        Schema::table('tag_lang', function (Blueprint $table) {
            $table->foreign(['lang_code'], 'fk_language_tag_lang')
                  ->references(['code'])->on('language')->onDelete('RESTRICT')->onUpdate('RESTRICT');

            $table->foreign(['tag_id'], 'fk_tag_tag_lang')
                  ->references(['tag_id'])->on('tag')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tag_lang', function (Blueprint $table) {
            $table->dropForeign('fk_language_tag_lang');
            $table->dropForeign('fk_tag_tag_lang');
        });
    }
};
