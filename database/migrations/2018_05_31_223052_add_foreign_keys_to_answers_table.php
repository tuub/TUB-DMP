<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('answers', function(Blueprint $table)
		{
			$table->foreign('question_id')->references('id')->on('questions')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('survey_id')->references('id')->on('surveys')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('answers', function(Blueprint $table)
		{
			$table->dropForeign('answers_question_id_foreign');
			$table->dropForeign('answers_survey_id_foreign');
		});
	}

}
