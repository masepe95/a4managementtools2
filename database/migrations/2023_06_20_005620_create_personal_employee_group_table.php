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
        Schema::create('personal_employee_group', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('employee_owner_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('group_employee_id');

            $table->primary(['group_id', 'group_employee_id']);

            $table->index(['group_employee_id', 'customer_id'], 'fk_employee_personal_employee_group_idx');
            $table->index(['group_employee_id'], 'idx_personal_employee_group_employee');
            $table->index(['group_id', 'employee_owner_id', 'customer_id'], 'fk_personal_group_personal_employee_group_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_employee_group');
    }
};
