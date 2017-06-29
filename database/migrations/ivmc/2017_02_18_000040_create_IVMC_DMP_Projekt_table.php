<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIVMCDMPProjektTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('t_821300_IVMC_DMP_Projekt');
        Schema::create('t_821300_IVMC_DMP_Projekt', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('ID_KTR')->nullable();
            $table->integer('ID_MA')->nullable();
            $table->integer('ID_MG')->nullable();
            $table->integer('ID_PT')->nullable();
            $table->integer('ID_MG_Pr')->nullable();
            $table->integer('ID_HP_1')->nullable();
            $table->integer('ID_HP_2')->nullable();
            $table->string('Projekt_Nr', 20)->nullable();
            $table->string('Proj_Kurzbezeichnung', 100)->nullable();
            $table->date('Laufzeit_von')->nullable();
            $table->date('Laufzeit_bis')->nullable();
            $table->string('OM', 20)->nullable();
            $table->string('Kostenstelle', 20)->nullable();
            $table->integer('Rang')->nullable();
            $table->string('Projektleiter_Nachname', 50)->nullable();
            $table->string('Projektleiter_Vorname', 50)->nullable();
            $table->string('Projektleiter_Titel', 50)->nullable();
            $table->string('Projektleiter_email', 50)->nullable();
            $table->string('Mittelgeber', 100)->nullable();
            $table->string('Projekttraeger', 100)->nullable();
            $table->integer('Projekttraeger_KZ')->nullable();
            $table->string('Foerderprogramm', 250)->nullable();
            $table->string('Hauptprogramm_1', 100)->nullable();
            $table->string('Unterprogramm', 50)->nullable();
            $table->text('Langtitel_dt')->nullable();
            $table->text('Langtitel_en')->nullable();
            $table->string('Acronym', 250)->nullable();
            $table->text('Abstract_dt')->nullable();
            $table->text('Abstract_en')->nullable();
            $table->date('Export_Datum')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('t_821300_IVMC_DMP_Projekt');
    }
}
