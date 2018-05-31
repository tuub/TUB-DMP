<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProjectMetadataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_metadata', function(Blueprint $table)
		{
			$table->uuid('id')->primary('project_metadata_pkey');
			$table->uuid('project_id');
			$table->uuid('metadata_registry_id');
			$table->text('content')->nullable();
			$table->string('language')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('project_metadata');
	}

}
