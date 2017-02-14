<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIvmcFieldTypeRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('ivmc_field_type_roles');
        Schema::create('ivmc_field_type_roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('ivmc_field_type_id')->unsigned();
            $table->foreign('ivmc_field_type_id')->references('id')->on('ivmc_field_types');
            $table->string('name',255);
            $table->integer('order')->default(1);
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('ivmc_field_type_roles');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
