<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePlansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('plans', function(Blueprint $table)
		{
			$table->uuid('id')->primary('plans_pkey');
			$table->string('title');
			$table->uuid('project_id');
			$table->string('version')->nullable();
			$table->boolean('is_active')->default(1);
			$table->boolean('is_snapshot')->default(0);
			$table->dateTime('snapshot_at')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('plans');
	}

}
