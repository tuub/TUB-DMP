<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->uuid('id')->primary('users_pkey');
			$table->string('email')->unique();
			$table->boolean('is_admin')->default(0);
			$table->boolean('is_active')->default(1);
			$table->dateTime('last_login')->nullable();
			$table->string('type')->default('shibboleth');
			$table->string('tub_om')->nullable()->unique('users_identifier_unique');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
