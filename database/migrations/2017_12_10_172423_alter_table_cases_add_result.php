<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCasesAddResult extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cases', function(Blueprint $table) {
            $table->string('case_result')->nullable();
            $table->string('other_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cases', function(Blueprint $table) {
            $table->dropColumn('case_result');
            $table->dropColumn('other_notes');
        });
    }
}
