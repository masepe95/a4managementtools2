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
        Schema::create('contact', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id')->index('fk_customer_contact_idx');
            $table->string('firstname', 64);
            $table->string('lastname', 64);
            $table->string('additional_name', 64)->nullable();
            $table->string('job_title', 64)->nullable();
            $table->string('phone', 32)->nullable();
            $table->string('mobile_phone', 32)->nullable();
            $table->string('email', 128);
            $table->text('notes')->nullable();

            $table->unique(['customer_id', 'firstname', 'lastname', 'email'], 'uq_contact');
        });

        // Add the CHECK constraints.
        DB::statement('ALTER TABLE `contact` ADD CONSTRAINT `chk_contact_firstname` CHECK (CHAR_LENGTH(TRIM(`firstname`)) > 0);');
        DB::statement('ALTER TABLE `contact` ADD CONSTRAINT `chk_contact_lastname` CHECK (CHAR_LENGTH(TRIM(`lastname`)) > 0);');
        DB::statement('ALTER TABLE `contact` ADD CONSTRAINT `chk_contact_email` CHECK (CHAR_LENGTH(TRIM(`email`)) > 0);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact');
    }
};
