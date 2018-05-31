<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToContentTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('content_types', function(Blueprint $table)
		{
			$table->foreign('input_type_id')->references('id')->on('input_types')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('content_types', function(Blueprint $table)
		{
			$table->dropForeign('content_types_input_type_id_foreign');
		});
	}

}
