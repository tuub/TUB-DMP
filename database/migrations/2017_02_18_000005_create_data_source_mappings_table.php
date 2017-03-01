<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataSourceMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('data_source_mappings');
        //TODO: how to store the external fields? How the internal mapping?
        //TODO: how to deal with order and combined fields?
        //TODO: include data_source_id OR apply via Through-Relation?
        Schema::create('data_source_mappings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('data_source_id')->unsigned();
            $table->integer('data_source_namespace_id')->unsigned();
            $table->json('data_source_entity');
            $table->string('target_namespace', 100);
            $table->json('target_entity');
            //$table->integer('field_type')->unsigned()->default(1);
            //$table->integer('display_order')->default(1);

            $table->foreign('data_source_namespace_id')->references('id')->on('data_source_namespaces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('data_source_mappings');
    }
}
