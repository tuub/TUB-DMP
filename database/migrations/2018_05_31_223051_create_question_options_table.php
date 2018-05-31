<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateQuestionOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('question_options', function(Blueprint $table)
		{
			$table->uuid('id')->primary('question_options_pkey');
			$table->uuid('question_id');
			$table->text('text');
			$table->text('value')->nullable();
			$table->boolean('default')->nullable();
			$table->uuid('parent_id')->nullable();
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
		Schema::drop('question_options');
	}

}
