<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('question_options');
        Schema::create('question_options', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions');
            $table->text('text');
            $table->text('value')->nullable();
            $table->boolean('default')->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->timestamps();
        });
        DB::update("ALTER TABLE question_options AUTO_INCREMENT = 1;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('question_options');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
