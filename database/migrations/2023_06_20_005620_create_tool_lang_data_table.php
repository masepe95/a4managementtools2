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
        Schema::create('tool_lang_data', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_general_ci');

            $table->unsignedBigInteger('id')->index('fk_tool_tool_lang_data_idx');
            $table->string('lang', 2)->index('fk_language_tool_lang_data_idx');
            $table->text('alphabetical_index');
            $table->text('sub_title');
            $table->text('introduction');
            $table->text('presentation');
            $table->text('potential');
            $table->text('solved_problem');
            $table->text('instructions');
            $table->text('advanced_techniques');
            $table->text('risks_and_remedies');
            $table->text('mistakes');
            $table->text('insight_1');
            $table->text('insight_2');
            $table->text('insight_3');
            $table->text('insight_4');
            $table->text('insight_5');
            $table->text('provocation_1');
            $table->text('provocation_2');
            $table->text('opportunities');
            $table->text('key_results');

            $table->primary(['id', 'lang']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tool_lang_data');
    }
};
