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
        Schema::table('employee', function (Blueprint $table) {
            $table->foreign(['customer_id'], 'fk_customer_employee')
                  ->references(['id'])->on('customer')->onDelete('CASCADE')->onUpdate('RESTRICT');

            $table->foreign(['language_code'], 'fk_language_employee')
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
        Schema::table('employee', function (Blueprint $table) {
            $table->dropForeign('fk_customer_employee');
            $table->dropForeign('fk_language_employee');
        });
    }
};
