<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateContentTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('content_types', function(Blueprint $table)
		{
			$table->uuid('id')->primary('content_types_pkey');
			$table->string('identifier', 125);
			$table->string('title');
			$table->text('structure');
			$table->uuid('input_type_id');
			$table->boolean('is_active')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('content_types');
	}

}
