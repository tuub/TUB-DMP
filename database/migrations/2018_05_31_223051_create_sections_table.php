<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSectionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sections', function(Blueprint $table)
		{
			$table->uuid('id')->primary('sections_pkey');
			$table->string('name');
			$table->uuid('template_id');
			$table->string('keynumber')->nullable();
			$table->integer('order')->default(1);
			$table->text('guidance')->nullable();
			$table->boolean('is_mandatory')->default(0);
			$table->boolean('is_active')->default(1);
			$table->timestamps();
			$table->boolean('export_keynumber')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sections');
	}

}
