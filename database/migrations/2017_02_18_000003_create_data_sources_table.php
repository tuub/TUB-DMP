<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('data_sources');
        //TODO: login, password to env file or here?
        Schema::create('data_sources', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('type', 15)->default('api');
            $table->string('identifier', 25)->unique();
            $table->string('name', 50)->unique();
            $table->text('description')->nullable();
            $table->string('uri', 125);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('data_sources');
    }
}
