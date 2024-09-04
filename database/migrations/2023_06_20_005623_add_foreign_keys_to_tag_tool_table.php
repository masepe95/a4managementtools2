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
        Schema::table('tag_tool', function (Blueprint $table) {
            $table->foreign(['tag_id'], 'fk_tag_tag_tool')
                  ->references(['tag_id'])->on('tag')->onDelete('CASCADE')->onUpdate('RESTRICT');

            $table->foreign(['tool_id'], 'fk_tool_tag_tool')
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
        Schema::table('tag_tool', function (Blueprint $table) {
            $table->dropForeign('fk_tag_tag_tool');
            $table->dropForeign('fk_tool_tag_tool');
        });
    }
};
