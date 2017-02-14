<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIvmcMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('ivmc_mappings');
        Schema::create('ivmc_mappings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions');
            $table->string('source', 255);
            $table->string('field', 255);
            $table->integer('field_type')->unsigned()->default(1);
            $table->integer('display_order')->default(1);
            $table->timestamps();
        });
        DB::update("ALTER TABLE ivmc_mappings AUTO_INCREMENT = 1;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('ivmc_mappings');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
