<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('plans');
        Schema::create('plans', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('project_number')->nullable();
            $table->integer('version')->default(1);
            $table->integer('template_id')->unsigned();
            $table->foreign('template_id')->references('id')->on('templates');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('datasource')->default(null)->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_final')->default(0);
            $table->boolean('is_prefilled')->default(0);
            $table->dateTime('prefilled_at')->nullable()->default(null);
            $table->timestamps();
        });
        DB::update("ALTER TABLE plans AUTO_INCREMENT = 1;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('plans');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
