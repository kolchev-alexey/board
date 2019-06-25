<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('team_id')->unsigned()->nullable();
            $table->boolean('archived')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->delete('cascade')->update('NO ACTION');
            $table->foreign('team_id')->references('id')->on('teams')->delete('cascade')->update('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boards');
    }
}
