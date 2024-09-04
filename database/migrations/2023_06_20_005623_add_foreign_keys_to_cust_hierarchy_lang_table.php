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
        Schema::table('cust_hierarchy_lang', function (Blueprint $table) {
            $table->foreign(['customer_hierarchy_id', 'level'], 'fk_cust_hierarchy_cust_hierarchy_lang')
                  ->references(['customer_hierarchy_id', 'level'])->on('cust_hierarchy')->onDelete('CASCADE')->onUpdate('RESTRICT');

            $table->foreign(['lang_code'], 'fk_language_cust_hierarchy_lang')
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
        Schema::table('cust_hierarchy_lang', function (Blueprint $table) {
            $table->dropForeign('fk_cust_hierarchy_cust_hierarchy_lang');
            $table->dropForeign('fk_language_cust_hierarchy_lang');
        });
    }
};
