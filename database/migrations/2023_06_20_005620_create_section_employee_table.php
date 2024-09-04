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
        Schema::create('section_employee', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('customer_id');

            $table->index(['employee_id', 'customer_id'], 'fk_employee_section_employee_idx');
            $table->index(['section_id', 'customer_id'], 'fk_section_section_employee_idx');
            $table->primary(['section_id', 'employee_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_employee');
    }
};
