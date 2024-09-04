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
        Schema::create('tool', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->unsignedBigInteger('id')->primary();
            $table->string('name_id', 8)->unique('uq_tool_name_id');
            $table->string('title_id', 64)->unique('uq_tool_title_id');
            $table->set('cat_levels', ['executive', 'advanced', 'intermediate']);
            $table->set('cat_recipients', ['management', 'marketing', 'operations', 'r-d']);
            $table->set('cat_usages', ['strategy', 'assessment', 'correctives', 'simplification', 'delegation', 'motivation']);
            $table->set('cat_selections', ['a-plus', 'eco', 'quick', 'top']);
            $table->enum('cat_scopes', ['company-management', 'management', 'team-management', 'professional-development', 'individual-development']);
            $table->enum('active', ['Y', 'N'])->default('Y');
        });

        // Add the CHECK constraints.
        DB::statement("ALTER TABLE `tool` ADD CONSTRAINT `chk_tool_id` CHECK (CONCAT('A4', LPAD(`id`, 3, '0')) = `name_id`);");
        DB::statement("ALTER TABLE `tool` ADD CONSTRAINT `chk_tool_name_id` CHECK (REGEXP_LIKE(`name_id`, '^A4(?!000$|0000)\\\\d{3,4}$', 'c') > 0);");
        DB::statement('ALTER TABLE `tool` ADD CONSTRAINT `chk_tool_title_id` CHECK (CHAR_LENGTH(TRIM(`title_id`)) > 0);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tool');
    }
};
