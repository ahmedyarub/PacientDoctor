<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDoubts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doubts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('doubt_id');
            $table->unsignedInteger('pacient_id');
            $table->unsignedInteger('doctor_id')->nullable();
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('question_id');
            $table->unsignedInteger('answer_id');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('doubts');
    }
}
