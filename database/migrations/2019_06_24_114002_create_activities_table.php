<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('board_id')->unsigned()->nullable();
            $table->bigInteger('card_id')->unsigned()->nullable();
            $table->integer('type');
            $table->string('detail');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->delete('cascade')->update('NO ACTION');
            $table->foreign('board_id')->references('id')->on('boards')->delete('cascade')->update('NO ACTION');
            $table->foreign('card_id')->references('id')->on('cards')->delete('cascade')->update('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
