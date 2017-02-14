<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('institutions');
        Schema::create('institutions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->unique();
            $table->string('url', 255)->nullable();
            $table->string('logo', 255)->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_external')->default(0);
            $table->timestamps();
        });
        DB::update("ALTER TABLE institutions AUTO_INCREMENT = 1;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('institutions');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
