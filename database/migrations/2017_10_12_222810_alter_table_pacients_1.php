<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePacients1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pacients', function(Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('birth');

            $table->string('city');
            $table->string('state');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pacients', function(Blueprint $table) {
            $table->string('address');
            $table->string('birth');

            $table->dropColumn('city');
            $table->dropColumn('state');
        });
    }
}
