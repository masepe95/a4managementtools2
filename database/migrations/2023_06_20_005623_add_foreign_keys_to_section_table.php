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
        Schema::table('section', function (Blueprint $table) {
            $table->foreign(['parent_section_id'], 'fk_parent_section_section')
                  ->references(['id'])->on('section')->onDelete('SET NULL')->onUpdate('RESTRICT');

            $table->foreign(['customer_id', 'level'], 'fk_section_level_section')
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
        Schema::table('section', function (Blueprint $table) {
            $table->dropForeign('fk_parent_section_section');
            $table->dropForeign('fk_section_level_section');
        });
    }
};
