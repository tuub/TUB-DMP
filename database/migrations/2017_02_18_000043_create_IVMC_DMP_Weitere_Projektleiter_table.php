<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIVMCDMPWeitereProjektleiterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('t_821320_IVMC_DMP_Weitere_Projektleiter');
        Schema::create('t_821320_IVMC_DMP_Weitere_Projektleiter', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('ID_MA')->nullable();
            $table->integer('ID_KTR')->nullable();
            $table->string('Projekt_Nr', 20)->nullable();
            $table->string('Weitere_PL_OM', 20)->nullable();
            $table->string('Weitere_PL_Kostenstelle', 20)->nullable();
            $table->integer('Weitere_PL_Rang')->nullable();
            $table->string('Weitere_PL_Nachname', 50)->nullable();
            $table->string('Weitere_PL_Vorname', 50)->nullable();
            $table->string('Weitere_PL_Titel', 50)->nullable();
            $table->string('Weitere_PL_email', 50)->nullable();
            $table->string('AnsprPartner', 30)->nullable();
            $table->date('von')->nullable();
            $table->date('bis')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('t_821320_IVMC_DMP_Weitere_Projektleiter');
    }
}
