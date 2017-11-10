<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableDoubtsAnswerIdNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doubts', function(Blueprint $table) {
            $table->unsignedInteger('answer_id')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doubts', function(Blueprint $table) {
            $table->unsignedInteger('answer_id')->nullable(false)->change();
        });
    }
}
