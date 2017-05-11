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
            $table->string('title',255);
            $table->integer('project_id')->unsigned();
            $table->string('version',255)->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_snapshot')->default(0);
            $table->dateTime('snapshot_at')->nullable();
            $table->timestamps();

            //$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('plans');
    }
}
