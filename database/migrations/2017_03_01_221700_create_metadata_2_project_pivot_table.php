<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetadata2ProjectPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metadata_2_project', function (Blueprint $table) {
            $table->integer('metadata_field_id')->unsigned()->index();
            $table->integer('project_id')->unsigned()->index();

            $table->primary(['metadata_field_id', 'project_id']);
            $table->foreign('metadata_field_id')->references('id')->on('metadata_fields')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('metadata_2_project');
    }
}
