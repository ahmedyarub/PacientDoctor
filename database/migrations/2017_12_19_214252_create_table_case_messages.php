<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCaseMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('case_id');
            $table->string('message', 1000);
            $table->timestamps();
        });

        Schema::table('case_messages', function(Blueprint $table) {
            $table->foreign('case_id', 'fk_case_messages_cases_id')->on('cases')->references('id')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('case_messages');
    }
}
