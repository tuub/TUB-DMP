<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDataSourceNamespacesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('data_source_namespaces', function(Blueprint $table)
		{
			$table->uuid('id')->primary('data_source_namespaces_pkey');
			$table->uuid('data_source_id');
			$table->string('name')->unique();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('data_source_namespaces');
	}

}
