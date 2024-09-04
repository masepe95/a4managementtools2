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
        Schema::create('customer', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->bigIncrements('id');
            $table->string('name', 64);
            $table->string('company_uid', 32)->nullable();
            $table->string('address1', 128)->nullable();
            $table->string('address2', 128)->nullable();
            $table->string('city', 64)->nullable();
            $table->string('zip', 32)->nullable();
            $table->unsignedBigInteger('country_state_id')->nullable()->index('fk_country_state_customer_idx');
            $table->string('vat', 128)->nullable();
            $table->enum('number_of_users', ['usr1', 'usr10', 'usr50', 'usr100', 'usr500', 'usr1000', 'usr2000', 'usr3000', 'usr5000', 'usr10000', 'usr15000', 'usr20000', 'usrUnlimited'])->nullable();
            $table->enum('customer_type', ['freeCustomer', 'regularCustomer', 'siteOwner'])->default('freeCustomer');
            $table->enum('customer_status', ['enabled', 'disabled'])->default('enabled');
            $table->enum('use_saml', ['Y', 'N'])->default('N');
            $table->mediumText('logo_file')->charset('binary')->nullable();  // MEDIUMBLOB
        });

        // Add the CHECK constraints.
        DB::statement('ALTER TABLE `customer` ADD CONSTRAINT `chk_customer_name` CHECK (CHAR_LENGTH(TRIM(`name`)) > 0);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer');
    }
};
