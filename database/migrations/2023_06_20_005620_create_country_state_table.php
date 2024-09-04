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
        Schema::create('country_state', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->unsignedBigInteger('id')->primary();
            $table->char('code3', 3)->index('fk_country_country_state_idx');
            $table->char('code2', 2);
            $table->string('subdiv', 16)->unique('uq_country_state_subdiv');
            $table->string('subdiv_name')->nullable();
            $table->string('level_name', 64)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('country_state');
    }
};
