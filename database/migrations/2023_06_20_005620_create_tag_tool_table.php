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
        Schema::create('tag_tool', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->unsignedBigInteger('tag_id')->index('fk_tag_tag_tool_idx');
            $table->unsignedBigInteger('tool_id')->index('fk_tool_tag_tool_idx');
            $table->double('weight')->default(1.0);

            $table->primary(['tag_id', 'tool_id']);
        });

        // Add the CHECK constraints.
        DB::statement('ALTER TABLE `tag_tool` ADD CONSTRAINT `chk_tag_tool_weight` CHECK (`weight` > 0.0 AND `weight` <= 1.0);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag_tool');
    }
};
