<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIVMCDMPProjektpartnerexternTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('t_821310_IVMC_DMP_Projektpartner_extern');
        Schema::create('t_821310_IVMC_DMP_Projektpartner_extern', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('ID_PP_Ex')->nullable();
            $table->integer('ID_KTR')->nullable();
            $table->string('Projekt_Nr', 20)->nullable();
            $table->string('Institution', 100)->nullable();

            $table->string('AnsprPartner', 30)->nullable();
            $table->date('von')->nullable();
            $table->date('bis')->nullable();

            $table->integer('K_koop_nicht_fin')->nullable();
            $table->integer('F_federfuehrend')->nullable();
            $table->integer('U_Unterauftrag')->nullable();
            $table->integer('K_KMU')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('t_821310_IVMC_DMP_Projektpartner_extern');
    }
}
