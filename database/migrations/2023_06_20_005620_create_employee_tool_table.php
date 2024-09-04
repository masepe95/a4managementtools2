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
        Schema::create('employee_tool', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('tool_id');
            $table->enum('access', ['read', 'write'])->default('write');

            $table->index(['customer_id', 'tool_id'], 'fk_customer_tool_employee_tool_idx');
            $table->index(['customer_id', 'employee_id'], 'fk_employee_employee_tool_idx');
            $table->primary(['customer_id', 'employee_id', 'tool_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_tool');
    }
};
