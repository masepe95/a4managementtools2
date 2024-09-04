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
        Schema::create('cust_hierarchy', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_hierarchy_id')->index('fk_customer_hierarchy_cust_hierarchy_idx');
            $table->unsignedInteger('level');

            $table->unique(['customer_hierarchy_id', 'level'], 'uq_cust_hierarchy_level');
        });

        // Add the CHECK constraints.
        DB::statement('ALTER TABLE `cust_hierarchy` ADD CONSTRAINT `chk_cust_hierarchy_level` CHECK (`level` >= 1 AND `level` <= 4);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cust_hierarchy');
    }
};
