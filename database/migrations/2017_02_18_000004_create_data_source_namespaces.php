<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataSourceNamespaces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('data_source_namespaces');
        Schema::create('data_source_namespaces', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('data_source_id')->unsigned();
            $table->string('name', 255)->unique();

            //$table->foreign('data_source_id')->references('id')->on('data_sources')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('data_source_namespaces');
    }
}
