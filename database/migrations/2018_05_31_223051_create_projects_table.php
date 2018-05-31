<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projects', function(Blueprint $table)
		{
			$table->uuid('id')->primary('projects_pkey');
			$table->uuid('parent_id')->nullable()->index();
			$table->integer('lft')->nullable()->index();
			$table->integer('rgt')->nullable()->index();
			$table->integer('depth')->nullable();
			$table->string('identifier', 50)->unique();
			$table->uuid('user_id');
			$table->uuid('data_source_id')->nullable();
			$table->boolean('imported')->default(0);
			$table->dateTime('imported_at')->nullable();
			$table->timestamps();
			$table->string('contact_email')->nullable();
			$table->uuid('uuid')->nullable();
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
		Schema::drop('projects');
	}

}
