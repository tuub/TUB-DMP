<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions', function(Blueprint $table)
		{
			$table->uuid('id')->primary('questions_pkey');
			$table->uuid('parent_id')->nullable()->index();
			$table->integer('lft')->nullable()->index();
			$table->integer('rgt')->nullable()->index();
			$table->integer('depth')->nullable();
			$table->uuid('template_id');
			$table->uuid('section_id');
			$table->string('keynumber')->nullable();
			$table->integer('order')->default(1);
			$table->text('text');
			$table->text('output_text')->nullable();
			$table->uuid('content_type_id');
			$table->text('default')->nullable();
			$table->text('prepend')->nullable();
			$table->text('append')->nullable();
			$table->text('comment')->nullable();
			$table->text('reference')->nullable();
			$table->text('guidance')->nullable();
			$table->text('hint')->nullable();
			$table->boolean('is_mandatory')->default(1);
			$table->boolean('is_active')->default(1);
			$table->boolean('read_only')->default(0);
			$table->timestamps();
			$table->boolean('export_always')->default(0);
			$table->boolean('export_keynumber')->default(0);
			$table->boolean('export_never')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('questions');
	}

}
