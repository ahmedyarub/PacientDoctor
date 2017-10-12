<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableDoctors1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctors', function(Blueprint $table) {
            $table->dropColumn('state');
            $table->dropColumn('city');
            $table->dropColumn('crm');

            $table->string('specialization');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctors', function(Blueprint $table) {
            $table->string('city');
            $table->string('state');
            $table->string('crm');

            $table->dropColumn('specialization');
        });
    }
}
