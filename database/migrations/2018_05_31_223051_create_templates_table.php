<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTemplatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('templates', function(Blueprint $table)
		{
			$table->uuid('id')->primary('templates_pkey');
			$table->string('name')->unique();
			$table->boolean('is_active')->default(1);
			$table->timestamps();
			$table->string('logo_file')->nullable();
			$table->text('description')->nullable();
			$table->text('copyright')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('templates');
	}

}
