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
        Schema::create('action_log', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->bigIncrements('id');
            $table->dateTime('action_time')->useCurrent();
            $table->enum('action', ['login', 'fail', 'failUnknown', 'toolOpen', 'toolCreate', 'toolSearch'])->default('login');
            $table->unsignedBigInteger('employee_id')->index('fk_employee_action_log_idx');
            $table->text('action_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('action_log');
    }
};
