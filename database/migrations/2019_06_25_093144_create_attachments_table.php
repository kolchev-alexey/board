<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('card_id')->unsigned()->nullable();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type');
            $table->boolean('archived')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->delete('cascade')->update('NO ACTION');
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
        Schema::dropIfExists('attachments');
    }
}
