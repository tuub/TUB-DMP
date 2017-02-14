<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('questions');
        Schema::create('questions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('template_id')->unsigned();
            $table->foreign('template_id')->references('id')->on('templates');
            $table->integer('section_id')->unsigned();
            $table->foreign('section_id')->references('id')->on('sections');
            $table->string('keynumber')->nullable();
            $table->integer('order')->default(1);
            $table->integer("parent_question_id")->unsigned()->nullable();
            $table->text('text');
            $table->text('output_text')->default(null)->nullable();
            $table->integer('input_type_id')->unsigned()->default(1);
            $table->foreign('input_type_id')->references('id')->on('input_types');
            $table->text('value')->nullable();
            $table->text('default')->nullable();
            $table->text('prepend')->nullable();
            $table->text('append')->nullable();
            $table->text('comment')->nullable();
            $table->text('reference')->nullable();
            $table->text('guidance')->nullable();
            $table->text('hint')->nullable();
            $table->boolean('is_mandatory')->default(1);
            $table->boolean('is_active')->default(1);
            $table->boolean('read_only')->default(0);
            $table->timestamps();
        });
        DB::update("ALTER TABLE questions AUTO_INCREMENT = 1;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('questions');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
