<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDataSourceMappingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('data_source_mappings', function(Blueprint $table)
		{
			$table->foreign('data_source_namespace_id')->references('id')->on('data_source_namespaces')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('data_source_id')->references('id')->on('data_sources')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('target_metadata_registry_id', 'data_source_mappings_metadata_registry_id_foreign')->references('id')->on('metadata_registry')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('data_source_mappings', function(Blueprint $table)
		{
			$table->dropForeign('data_source_mappings_data_source_namespace_id_foreign');
			$table->dropForeign('data_source_mappings_data_source_id_foreign');
			$table->dropForeign('data_source_mappings_metadata_registry_id_foreign');
		});
	}

}
