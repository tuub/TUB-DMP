<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_source_namespaces', function($table)
        {
            $table->foreign('data_source_id')->references('id')->on('data_sources')->onDelete('cascade');
        });

        Schema::table('data_source_mappings', function($table) {
            $table->foreign('data_source_namespace_id')->references('id')->on('data_source_namespaces')->onDelete('cascade');
        });

        Schema::table('projects', function($table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //$table->foreign('data_source_id')->references('id')->on('data_sources');
        });

        Schema::table('content_types', function($table) {
            $table->foreign('input_type_id')->references('id')->on('input_types');
        });

        Schema::table('templates', function($table) {
            $table->foreign('institution_id')->references('id')->on('institutions');
        });

        Schema::table('sections', function($table) {
            $table->foreign('template_id')->references('id')->on('templates');
        });

        Schema::table('plans', function($table) {
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });

        Schema::table('questions', function($table) {
            $table->foreign('template_id')->references('id')->on('templates');
            $table->foreign('content_type_id')->references('id')->on('content_types');
            $table->foreign('section_id')->references('id')->on('sections');
        });

        Schema::table('question_options', function($table) {
            $table->foreign('question_id')->references('id')->on('questions');
        });

        Schema::table('metadata_registry', function($table) {
            $table->foreign('content_type_id')->references('id')->on('content_types');
        });

        Schema::table('project_metadata', function($table) {
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });

        Schema::table('surveys', function($table) {
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->foreign('template_id')->references('id')->on('templates');
        });

        Schema::table('answers', function($table) {
            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
