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
        Schema::table('personal_job_hierarchy_lang', function (Blueprint $table) {
            $table->foreign(['lang_code'], 'fk_language_pjob_hierarchy_lang')
                  ->references(['code'])->on('language')->onDelete('RESTRICT')->onUpdate('RESTRICT');

            $table->foreign(['personal_job_id'], 'fk_pjob_pjob_hierarchy_lang')
                  ->references(['id'])->on('personal_job')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personal_job_hierarchy_lang', function (Blueprint $table) {
            $table->dropForeign('fk_language_pjob_hierarchy_lang');
            $table->dropForeign('fk_pjob_pjob_hierarchy_lang');
        });
    }
};
