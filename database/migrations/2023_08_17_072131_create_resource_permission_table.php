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
        Schema::create('resource_permission', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->string('name', 64);
            $table->string('permission_data', 64)->nullable();
            $table->enum('permission_type', ['record', 'column']);
            $table->enum('role', ['inherit', 'employee', 'customerAdmin', 'siteAdmin'])->default('inherit');
            $table->string('resource_name', 64)->index('fk_resource_access_resource_permission_idx');

            $table->primary(['name', 'resource_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resource_permission');
    }
};
