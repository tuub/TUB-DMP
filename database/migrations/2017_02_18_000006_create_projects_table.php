<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //TODO: decide how to include the metadata: in this table or extra table with md schema
        Schema::dropIfExists('projects');
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier',50)->unique();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('data_source_id')->unsigned()->nullable();
            $table->boolean('is_prefilled')->default(0);
            $table->dateTime('prefilled_at')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('projects')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //$table->foreign('data_source_id')->references('id')->on('data_sources');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('projects');
    }
}
