<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDataSourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('data_sources', function(Blueprint $table)
		{
			$table->uuid('id')->primary('data_sources_pkey');
			$table->string('type', 15)->default('api');
			$table->string('identifier', 25)->unique();
			$table->string('name', 50)->unique();
			$table->text('description')->nullable();
			$table->string('uri', 125);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('data_sources');
	}

}
