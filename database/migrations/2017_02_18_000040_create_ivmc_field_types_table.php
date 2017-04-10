<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIvmcFieldTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        Schema::dropIfExists('ivmc_field_types');
        Schema::create('ivmc_field_types', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name',255);
            $table->string('description',255);
            $table->timestamps();
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::drop('ivmc_field_types');
    }
}
