<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacients', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->string('genre');
            $table->string('phone');
            $table->string('address');
            $table->string('birth');
            $table->timestamps();
        });

        Schema::table('pacients', function(Blueprint $table) {
            $table->foreign('user_id', 'fk_pacients_users_id')->on('users')->references('id')->onDelete('restrict')->onUpdate('restrict');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pacients');
    }
}
