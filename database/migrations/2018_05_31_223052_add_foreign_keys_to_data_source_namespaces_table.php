<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDataSourceNamespacesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('data_source_namespaces', function(Blueprint $table)
		{
			$table->foreign('data_source_id')->references('id')->on('data_sources')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('data_source_namespaces', function(Blueprint $table)
		{
			$table->dropForeign('data_source_namespaces_data_source_id_foreign');
		});
	}

}
