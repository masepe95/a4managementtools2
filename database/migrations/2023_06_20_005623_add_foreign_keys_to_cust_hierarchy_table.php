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
        Schema::table('cust_hierarchy', function (Blueprint $table) {
            $table->foreign(['customer_hierarchy_id'], 'fk_customer_hierarchy_cust_hierarchy')
                  ->references(['id'])->on('customer_hierarchy')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cust_hierarchy', function (Blueprint $table) {
            $table->dropForeign('fk_customer_hierarchy_cust_hierarchy');
        });
    }
};
