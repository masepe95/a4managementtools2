
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
        Schema::create('empl_hierarchy', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_hierarchy_id')->index('fk_employee_hierarchy_empl_hierarchy_idx');
            $table->unsignedInteger('level');

            $table->unique(['employee_hierarchy_id', 'level'], 'uq_empl_hierarchy_level');
        });

        // Add the CHECK constraints.
        DB::statement('ALTER TABLE `empl_hierarchy` ADD CONSTRAINT `chk_empl_hierarchy_level` CHECK (`level` >= 1 AND `level` <= 4);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empl_hierarchy');
    }
};
