<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProjectMetadataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('project_metadata', function(Blueprint $table)
		{
			$table->foreign('project_id')->references('id')->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('metadata_registry_id')->references('id')->on('metadata_registry')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('project_metadata', function(Blueprint $table)
		{
			$table->dropForeign('project_metadata_project_id_foreign');
			$table->dropForeign('project_metadata_metadata_registry_id_foreign');
		});
	}

}
