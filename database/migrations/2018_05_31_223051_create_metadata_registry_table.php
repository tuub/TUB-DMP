<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateMetadataRegistryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('metadata_registry', function(Blueprint $table)
		{
			$table->uuid('id')->primary('metadata_registry_pkey');
			$table->string('namespace', 125);
			$table->string('identifier', 125);
			$table->string('title', 125);
			$table->text('description')->nullable();
			$table->uuid('content_type_id');
			$table->boolean('is_multiple')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('metadata_registry');
	}

}
