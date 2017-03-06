<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetadataRegistryProjectMetadataPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metadata_registry_project_metadata', function (Blueprint $table) {
            $table->integer('metadata_registry_id')->unsigned()->index();
            $table->foreign('metadata_registry_id')->references('id')->on('metadata_registry')->onDelete('cascade');
            $table->integer('project_metadata_id')->unsigned()->index();
            $table->foreign('project_metadata_id')->references('id')->on('project_metadata')->onDelete('cascade');
            $table->primary(['metadata_registry_id', 'project_metadata_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('metadata_registry_project_metadata');
    }
}
