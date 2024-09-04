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
        Schema::table('empl_hierarchy_lang', function (Blueprint $table) {
            $table->foreign(['employee_hierarchy_id', 'level'], 'fk_empl_hierarchy_empl_hierarchy_lang')
                  ->references(['employee_hierarchy_id', 'level'])->on('empl_hierarchy')->onDelete('CASCADE')->onUpdate('RESTRICT');

            $table->foreign(['lang_code'], 'fk_language_empl_hierarchy_lang')
                  ->references(['code'])->on('language')->onDelete('RESTRICT')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empl_hierarchy_lang', function (Blueprint $table) {
            $table->dropForeign('fk_empl_hierarchy_empl_hierarchy_lang');
            $table->dropForeign('fk_language_empl_hierarchy_lang');
        });
    }
};
