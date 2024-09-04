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
        Schema::create('section', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('parent_section_id')->nullable()->index('fk_parent_section_section_idx');
            $table->unsignedInteger('level');

            $table->index(['customer_id', 'level'], 'fk_section_level_section_idx');
            $table->unique(['id', 'customer_id'], 'uq_section_customer_id');
        });

        // Add the triggers.
        DB::statement('CREATE DEFINER = CURRENT_USER TRIGGER `section_BEFORE_INSERT` BEFORE INSERT ON `section` ' .
            'FOR EACH ROW ' .
            'BEGIN ' .
            "DECLARE userDefinedException CONDITION FOR SQLSTATE '45000'; " .
            'DECLARE parentLevel INTEGER; ' .
            'DECLARE errNo INTEGER; ' .
            'IF NEW.`parent_section_id` IS NOT NULL THEN ' .
            'SELECT sc.`level` INTO parentLevel FROM `section` sc WHERE sc.`id` = NEW.`parent_section_id` AND sc.`customer_id` = NEW.`customer_id`; ' .
            'GET DIAGNOSTICS CONDITION 1 errNo = MYSQL_ERRNO; ' .
            'IF errNo = 1329 THEN ' .
            "SIGNAL userDefinedException SET MESSAGE_TEXT = 'Error: no parent-section found!'; " .
            'ELSEIF (parentLevel + 1) != NEW.`level` THEN ' .
            "SIGNAL userDefinedException SET MESSAGE_TEXT = 'Error: the parent level must have a value 1 less than the level value of this subsection!'; " .
            'END IF; ' .
            'ELSEIF NEW.`level` != 1 THEN ' .
            "SIGNAL userDefinedException SET MESSAGE_TEXT = 'Error: `level` must be 1 when `parent_section_id` is NULL!'; " .
            'END IF; ' .
            'END');

        DB::statement('CREATE DEFINER = CURRENT_USER TRIGGER `section_BEFORE_UPDATE` BEFORE UPDATE ON `section` ' .
            'FOR EACH ROW ' .
            'BEGIN ' .
            "DECLARE userDefinedException CONDITION FOR SQLSTATE '45000'; " .
            'DECLARE parentLevel INTEGER; ' .
            'DECLARE errNo INTEGER; ' .
            'IF NEW.`parent_section_id` IS NOT NULL THEN ' .
            'SELECT sc.`level` INTO parentLevel FROM `section` sc WHERE sc.`id` = NEW.`parent_section_id` AND sc.`customer_id` = NEW.`customer_id`; ' .
            'GET DIAGNOSTICS CONDITION 1 errNo = MYSQL_ERRNO; ' .
            'IF errNo = 1329 THEN ' .
            "SIGNAL userDefinedException SET MESSAGE_TEXT = 'Error: no parent-section found!'; " .
            'ELSEIF (parentLevel + 1) != NEW.`level` THEN ' .
            "SIGNAL userDefinedException SET MESSAGE_TEXT = 'Error: the parent level must have a value 1 less than the level value of this subsection!'; " .
            'END IF; ' .
            'ELSEIF NEW.`level` != 1 THEN ' .
            "SIGNAL userDefinedException SET MESSAGE_TEXT = 'Error: `level` must be 1 when `parent_section_id` is NULL!'; " .
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
        DB::statement('DROP TRIGGER IF EXISTS `section_BEFORE_INSERT`;');
        DB::statement('DROP TRIGGER IF EXISTS `section_BEFORE_UPDATE`;');

        Schema::dropIfExists('section');
    }
};
