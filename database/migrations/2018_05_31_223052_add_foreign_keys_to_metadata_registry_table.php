<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToMetadataRegistryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('metadata_registry', function(Blueprint $table)
		{
			$table->foreign('content_type_id')->references('id')->on('content_types')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('metadata_registry', function(Blueprint $table)
		{
			$table->dropForeign('metadata_registry_content_type_id_foreign');
		});
	}

}
