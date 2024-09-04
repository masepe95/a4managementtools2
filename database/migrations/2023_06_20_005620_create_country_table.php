<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->char('code3', 3)->primary();
            $table->char('code2', 2)->unique('uq_country_code2');
            $table->integer('iso_cc')->unique('uq_country_iso_cc');
            $table->string('country_name', 128);
            $table->string('ar', 128);
            $table->string('bg', 128);
            $table->string('cs', 128);
            $table->string('da', 128);
            $table->string('de', 128);
            $table->string('el', 128);
            $table->string('en', 128);
            $table->string('es', 128);
            $table->string('et', 128);
            $table->string('eu', 128);
            $table->string('fi', 128);
            $table->string('fr', 128);
            $table->string('hu', 128);
            $table->string('it', 128);
            $table->string('ja', 128);
            $table->string('ko', 128);
            $table->string('lt', 128);
            $table->string('nl', 128);
            $table->string('no', 128);
            $table->string('pl', 128);
            $table->string('pt', 128);
            $table->string('ro', 128);
            $table->string('ru', 128);
            $table->string('sk', 128);
            $table->string('sv', 128);
            $table->string('th', 128);
            $table->string('uk', 128);
            $table->string('zh', 128);
            $table->string('zh-tw', 128);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('country');
    }
};
