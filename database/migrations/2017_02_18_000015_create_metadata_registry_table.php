<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetadataRegistryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metadata_registry', function (Blueprint $table) {
            $table->increments('id');
            $table->string('namespace', 125);
            $table->string('identifier', 125);
            $table->string('title', 125);
            $table->text('description')->nullable();
            $table->integer('content_type_id')->default(1);
            $table->boolean('is_multiple')->default(1);

            //$table->foreign('content_type_id')->references('id')->on('content_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metadata_registry');
    }
}
