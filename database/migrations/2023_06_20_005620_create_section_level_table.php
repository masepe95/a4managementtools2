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
        Schema::create('section_level', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id')->index('fk_customer_section_level_idx');
            $table->unsignedInteger('level');

            $table->unique(['customer_id', 'level'], 'uq_section_level_level');
        });

        // Add the CHECK constraints.
        DB::statement('ALTER TABLE `section_level` ADD CONSTRAINT `chk_section_level_level` CHECK (`level` > 0);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_level');
    }
};
