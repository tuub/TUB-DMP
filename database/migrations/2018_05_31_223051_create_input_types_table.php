<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateInputTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('input_types', function(Blueprint $table)
		{
			$table->uuid('id')->primary('input_types_pkey');
			$table->string('identifier', 125);
			$table->string('title');
			$table->string('category', 125);
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
		Schema::drop('input_types');
	}

}
