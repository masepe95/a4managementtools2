<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_hierarchy', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->index('fk_employee_employee_hierarchy_idx');
            $table->string('name', 64);

            $table->unique(['employee_id', 'name'], 'uq_employee_hierarchy_name');
        });

        // Add the CHECK constraints.
        DB::statement('ALTER TABLE `employee_hierarchy` ADD CONSTRAINT `chk_employee_hierarchy_name` CHECK (CHAR_LENGTH(TRIM(`name`)) > 0);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_hierarchy');
    }
};
