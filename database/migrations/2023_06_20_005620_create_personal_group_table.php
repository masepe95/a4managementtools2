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
        Schema::create('personal_group', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->index('idx_personal_group_employee');
            $table->unsignedBigInteger('customer_id');
            $table->string('group_name');

            $table->unique(['employee_id', 'group_name'], 'uq_personal_group_group_name');
            $table->index(['customer_id'], 'idx_personal_group_customer');
            $table->index(['id', 'employee_id', 'customer_id'], 'idx_personal_group_employee_customer');
            $table->index(['employee_id', 'customer_id'], 'fk_employee_personal_group_idx');
        });

        // Add the CHECK constraints.
        DB::statement('ALTER TABLE `personal_group` ADD CONSTRAINT `chk_personal_group_group_name` CHECK (CHAR_LENGTH(TRIM(`group_name`)) > 0);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_group');
    }
};
