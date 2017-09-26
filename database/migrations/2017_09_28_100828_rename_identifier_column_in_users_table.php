<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameIdentifierColumnInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('users', 'identifier'))
        {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('identifier', 'tub_om');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'tub_om'))
        {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('tub_om', 'identifier');
            });
        }
    }
}
