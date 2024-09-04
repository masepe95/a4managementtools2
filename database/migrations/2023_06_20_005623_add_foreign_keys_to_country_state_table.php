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
        Schema::table('country_state', function (Blueprint $table) {
            $table->foreign(['code3'], 'fk_country_country_state')
                  ->references(['code3'])->on('country')->onDelete('RESTRICT')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('country_state', function (Blueprint $table) {
            $table->dropForeign('fk_country_country_state');
        });
    }
};
