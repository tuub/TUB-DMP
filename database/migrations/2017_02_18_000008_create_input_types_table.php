<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInputTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('input_types');
        Schema::create('input_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier',125);
            $table->string('title', 255);
            $table->string('category',125);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('input_types');
    }
}
