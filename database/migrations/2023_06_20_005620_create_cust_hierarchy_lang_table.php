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
        Schema::create('cust_hierarchy_lang', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_hierarchy_id');
            $table->unsignedInteger('level');
            $table->string('lang_code', 2)->index('fk_language_cust_hierarchy_lang_idx');
            $table->string('name', 64);

            $table->index(['customer_hierarchy_id', 'level'], 'fk_cust_hierarchy_cust_hierarchy_lang_idx');
            $table->unique(['customer_hierarchy_id', 'level', 'lang_code'], 'uq_cust_hierarchy_lang_lang');
            $table->unique(['customer_hierarchy_id', 'lang_code', 'name'], 'uq_cust_hierarchy_lang_name');
        });

        // Add the CHECK constraints.
        DB::statement('ALTER TABLE `cust_hierarchy_lang` ADD CONSTRAINT `chk_cust_hierarchy_lang_name` CHECK (CHAR_LENGTH(TRIM(`name`)) > 0);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cust_hierarchy_lang');
    }
};
