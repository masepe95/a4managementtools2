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
        Schema::table('job_hierarchy_lang', function (Blueprint $table) {
            $table->foreign(['job_id'], 'fk_job_job_hierarchy_lang')
                  ->references(['id'])->on('job')->onDelete('CASCADE')->onUpdate('RESTRICT');

            $table->foreign(['lang_code'], 'fk_language_job_hierarchy_lang')
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
        Schema::table('job_hierarchy_lang', function (Blueprint $table) {
            $table->dropForeign('fk_job_job_hierarchy_lang');
            $table->dropForeign('fk_language_job_hierarchy_lang');
        });
    }
};
