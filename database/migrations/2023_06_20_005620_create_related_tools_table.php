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
        Schema::create('related_tools', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->unsignedBigInteger('source_tool')->index('fk_tool_related_source_idx');
            $table->unsignedBigInteger('related_tool')->index('fk_tool_related_related_idx');

            $table->primary(['source_tool', 'related_tool']);
        });

        // Add the CHECK constraints.
        DB::statement('ALTER TABLE `related_tools` ADD CONSTRAINT `chk_related_tools_source_related` CHECK (`source_tool` != `related_tool`);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('related_tools');
    }
};
