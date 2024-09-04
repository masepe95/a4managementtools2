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
        Schema::table('customer_tool', function (Blueprint $table) {
            $table->foreign(['customer_id'], 'fk_customer_customer_tool')
                  ->references(['id'])->on('customer')->onDelete('CASCADE')->onUpdate('RESTRICT');

            $table->foreign(['tool_id'], 'fk_tool_customer_tool')
                  ->references(['id'])->on('tool')->onDelete('RESTRICT')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_tool', function (Blueprint $table) {
            $table->dropForeign('fk_customer_customer_tool');
            $table->dropForeign('fk_tool_customer_tool');
        });
    }
};
