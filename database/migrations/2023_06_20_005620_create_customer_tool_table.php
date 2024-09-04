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
        Schema::create('customer_tool', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->unsignedBigInteger('customer_id')->index('fk_customer_customer_tool_idx');
            $table->unsignedBigInteger('tool_id')->index('fk_tool_customer_tool_idx');
            $table->enum('enabled', ['Y', 'N']);

            $table->primary(['customer_id', 'tool_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_tool');
    }
};
