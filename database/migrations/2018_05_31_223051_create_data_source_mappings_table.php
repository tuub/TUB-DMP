<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateDataSourceMappingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('data_source_mappings', function(Blueprint $table)
		{
			$table->uuid('id')->primary('data_source_mappings_pkey');
			$table->uuid('data_source_id');
			$table->uuid('data_source_namespace_id');
			$table->text('data_source_entity');
			$table->string('target_namespace', 100);
			$table->uuid('target_metadata_registry_id');
			$table->text('target_content');
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
