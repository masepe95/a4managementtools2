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
        Schema::table('related_tools', function (Blueprint $table) {
            $table->foreign(['related_tool'], 'fk_tool_related_related')
                  ->references(['id'])->on('tool')->onDelete('CASCADE')->onUpdate('RESTRICT');

            $table->foreign(['source_tool'], 'fk_tool_related_source')
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
        Schema::table('related_tools', function (Blueprint $table) {
            $table->dropForeign('fk_tool_related_related');
            $table->dropForeign('fk_tool_related_source');
        });
    }
};
