<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIVMCDMPSchlagworteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('t_821396_IVMC_DMP_Schlagworte');
        Schema::create('t_821396_IVMC_DMP_Schlagworte', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('ID_KTR')->nullable();
            $table->string('Projekt_Nr', 20)->nullable();
            $table->string('Schlagwort', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('t_821396_IVMC_DMP_Schlagworte');
    }
}
