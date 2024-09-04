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
        Schema::create('global_option', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->unsignedBigInteger('id')->default(1)->primary();
            $table->string('default_lang_code', 2)->default('en')->index('fk_language_global_option_idx');
            $table->unsignedSmallInteger('signup_pending_timeout')->default(60);
            $table->unsignedSmallInteger('minimum_password_length')->default(16);
            $table->unsignedSmallInteger('max_password_failures')->default(5);
            $table->unsignedSmallInteger('recovering_access_delay')->default(30);
            $table->string('support_admin_email')->default('');
            $table->enum('under_maintenance', ['redirect', 'maintenance', 'off'])->default('off');
            $table->string('redirect_url')->default('');
            $table->enum('maintenance_banner', ['Y', 'N'])->default('N');
            $table->string('maintenance_period', 64)->default('');
        });

        // Add the CHECK constraints.
        DB::statement('ALTER TABLE `global_option` ADD CONSTRAINT `chk_global_option_id` CHECK (`id` = 1);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('global_option');
    }
};
