<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('sections');
        Schema::create('sections', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->integer('template_id')->unsigned();
            $table->foreign('template_id')->references('id')->on('templates');
            $table->string('keynumber')->nullable();
            $table->integer('order')->default(1);
            $table->text('guidance')->nullable();
            $table->timestamps();
        });
        DB::update("ALTER TABLE sections AUTO_INCREMENT = 1;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('sections');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
