<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSurveysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('surveys', function(Blueprint $table)
		{
			$table->foreign('plan_id')->references('id')->on('plans')->onUpdate('CASCADE')->onDelete('CASCADE');
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
		Schema::table('surveys', function(Blueprint $table)
		{
			$table->dropForeign('surveys_plan_id_foreign');
			$table->dropForeign('surveys_template_id_foreign');
		});
	}

}
