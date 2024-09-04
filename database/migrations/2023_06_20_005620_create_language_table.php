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
        Schema::create('language', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->string('code', 2)->primary();
            $table->unsignedInteger('order')->default(1);
            $table->string('name', 32)->unique('uq_language_name');
        });

        // Add the CHECK constraints.
        DB::statement('ALTER TABLE `language` ADD CONSTRAINT `chk_language_code` CHECK (CHAR_LENGTH(TRIM(`code`)) = 2);');
        DB::statement('ALTER TABLE `language` ADD CONSTRAINT `chk_language_order` CHECK (`order` >= 1);');
        DB::statement('ALTER TABLE `language` ADD CONSTRAINT `chk_language_name` CHECK (CHAR_LENGTH(TRIM(`name`)) > 0);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('language');
    }
};
