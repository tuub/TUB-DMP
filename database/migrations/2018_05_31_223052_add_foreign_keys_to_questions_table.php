<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('questions', function(Blueprint $table)
		{
			$table->foreign('content_type_id')->references('id')->on('content_types')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('section_id')->references('id')->on('sections')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('template_id')->references('id')->on('templates')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('questions', function(Blueprint $table)
		{
			$table->dropForeign('questions_content_type_id_foreign');
			$table->dropForeign('questions_section_id_foreign');
			$table->dropForeign('questions_template_id_foreign');
		});
	}

}
