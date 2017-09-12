<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIVMCDMPProjektpartnerinternTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('t_821311_IVMC_DMP_Projektpartner_intern');
        Schema::create('t_821311_IVMC_DMP_Projektpartner_intern', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('ID_MA')->nullable();
            $table->integer('ID_KTR')->nullable();
            $table->string('Projekt_Nr', 20)->nullable();
            $table->string('PP_Intern_PL_OM', 20)->nullable();
            $table->string('PP_Intern_PL_Kostenstelle', 20)->nullable();
            $table->string('PP_Intern_PL_Nachname', 50)->nullable();
            $table->string('PP_Intern_PL_Vorname', 50)->nullable();
            $table->string('PP_Intern_PL_Titel', 50)->nullable();
            $table->string('PP_Intern_PL_email', 50)->nullable();
            $table->string('AnsprPartner', 30)->nullable();
            $table->date('von')->nullable();
            $table->date('bis')->nullable();
            $table->integer('K_koop_nicht_fin')->nullable();
            $table->integer('F_federfuehrend')->nullable();
            $table->integer('V_Verbund')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('t_821311_IVMC_DMP_Projektpartner_intern');
    }
}
