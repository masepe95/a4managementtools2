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
        Schema::table('section_level', function (Blueprint $table) {
            $table->foreign(['customer_id'], 'fk_customer_section_level')
                  ->references(['id'])->on('customer')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('section_level', function (Blueprint $table) {
            $table->dropForeign('fk_customer_section_level');
        });
    }
};
