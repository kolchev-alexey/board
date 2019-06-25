<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('board_id')->unsigned();
            $table->bigInteger('card_list_id')->unsigned();            
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('position');
            $table->boolean('archived')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->delete('cascade')->update('NO ACTION');
            $table->foreign('board_id')->references('id')->on('boards')->delete('cascade')->update('NO ACTION');
            $table->foreign('card_list_id')->references('id')->on('card_lists')->delete('cascade')->update('NO ACTION');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
