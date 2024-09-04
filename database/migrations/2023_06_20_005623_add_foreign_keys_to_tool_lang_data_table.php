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
        Schema::table('tool_lang_data', function (Blueprint $table) {
            $table->foreign(['lang'], 'fk_language_tool_lang_data')
                  ->references(['code'])->on('language')->onDelete('RESTRICT')->onUpdate('RESTRICT');

            $table->foreign(['id'], 'fk_tool_tool_lang_data')
                  ->references(['id'])->on('tool')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tool_lang_data', function (Blueprint $table) {
            $table->dropForeign('fk_language_tool_lang_data');
            $table->dropForeign('fk_tool_tool_lang_data');
        });
    }
};
