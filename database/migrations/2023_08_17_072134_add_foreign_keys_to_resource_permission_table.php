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
        Schema::table('resource_permission', function (Blueprint $table) {
            $table->foreign(['resource_name'], 'fk_resource_access_resource_permission')
                  ->references(['name'])->on('resource_access')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resource_permission', function (Blueprint $table) {
            $table->dropForeign('fk_resource_access_resource_permission');
        });
    }
};
