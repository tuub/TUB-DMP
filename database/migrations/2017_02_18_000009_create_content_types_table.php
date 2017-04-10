<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier',125);
            $table->string('title', 255);
            $table->integer('input_type_id')->unsigned()->default(1);

            //$table->foreign('input_type_id')->references('id')->on('input_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_types');
    }
}
