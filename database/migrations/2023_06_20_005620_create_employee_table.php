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
        Schema::create('employee', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id')->index('fk_customer_employee_idx');
            $table->string('acronym', 32)->nullable();
            $table->string('employee_id', 32)->nullable();
            $table->string('firstname', 64);
            $table->string('lastname', 64);
            $table->enum('role', ['employee', 'customerAdmin', 'siteAdmin'])->default('employee');
            $table->string('job_title', 64)->nullable();
            $table->string('phone', 32)->nullable();
            $table->string('mobile_phone', 32)->nullable();
            $table->string('email', 128);
            $table->datetime('email_verified_at')->nullable();
            $table->string('password', 128);
            $table->string('remember_token', 128)->nullable();
            $table->string('language_code', 2)->default('en')->index('fk_language_employee_idx');
            $table->mediumText('photo_file')->charset('binary')->nullable();
            $table->unsignedSmallInteger('failed_passwords')->default(0);
            $table->dateTime('password_failure_time')->nullable();
            $table->enum('employee_status', ['enabled', 'disabled'])->default('enabled');

            $table->unique(['customer_id', 'acronym'], 'uq_employee_acronym');
            $table->unique(['id', 'customer_id'], 'uq_employee_customer_id');
            $table->unique(['customer_id', 'email'], 'uq_employee_email');
            $table->unique(['email', 'password'], 'uq_employee_email_password');
            $table->unique(['customer_id', 'employee_id'], 'uq_employee_employee_id');
        });

        // Add the CHECK constraints.
        DB::statement('ALTER TABLE `employee` ADD CONSTRAINT `chk_employee_firstname` CHECK (CHAR_LENGTH(TRIM(`firstname`)) > 0);');
        DB::statement('ALTER TABLE `employee` ADD CONSTRAINT `chk_employee_lastname` CHECK (CHAR_LENGTH(TRIM(`lastname`)) > 0);');
        DB::statement('ALTER TABLE `employee` ADD CONSTRAINT `chk_employee_email` CHECK (CHAR_LENGTH(TRIM(`email`)) > 0);');
        DB::statement('ALTER TABLE `employee` ADD CONSTRAINT `chk_employee_password` CHECK (CHAR_LENGTH(TRIM(`password`)) > 0);');

        // Add the triggers.
        DB::statement('CREATE DEFINER = CURRENT_USER TRIGGER `employee_BEFORE_INSERT` BEFORE INSERT ON `employee` ' .
            'FOR EACH ROW ' .
            'BEGIN ' .
            "DECLARE userDefinedException CONDITION FOR SQLSTATE '45000'; " .
            'DECLARE customerType VARCHAR(32); ' .
            "IF NEW.`role` = 'siteAdmin' THEN " .
            'SELECT cs.`customer_type` INTO customerType FROM `customer` cs WHERE cs.`id` = NEW.`customer_id`; ' .
            "IF customerType != 'siteOwner' THEN " .
            "SIGNAL userDefinedException SET MESSAGE_TEXT = 'Error: the role of this employee cannot be set to \\'siteAdmin\\'!'; " .
            'END IF; ' .
            'END IF; ' .
            'END');

        DB::statement('CREATE DEFINER = CURRENT_USER TRIGGER `employee_BEFORE_UPDATE` BEFORE UPDATE ON `employee` ' .
            'FOR EACH ROW ' .
            'BEGIN ' .
            "DECLARE userDefinedException CONDITION FOR SQLSTATE '45000'; " .
            'DECLARE customerType VARCHAR(32); ' .
            "IF NEW.`role` = 'siteAdmin' THEN " .
            'SELECT cs.`customer_type` INTO customerType FROM `customer` cs WHERE cs.`id` = NEW.`customer_id`; ' .
            "IF customerType != 'siteOwner' THEN " .
            "SIGNAL userDefinedException SET MESSAGE_TEXT = 'Error: the role of this employee cannot be set to \\'siteAdmin\\'!'; " .
            'END IF; ' .
            'END IF; ' .
            'END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP TRIGGER IF EXISTS `employee_BEFORE_INSERT`;');
        DB::statement('DROP TRIGGER IF EXISTS `employee_BEFORE_UPDATE`;');

        Schema::dropIfExists('employee');
    }
};
