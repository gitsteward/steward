<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participant_answers', function (Blueprint $table) {
            $table->integer('question')->unsigned();
            $table->integer('answer')->unsigned();
            $table->integer('participant')->unsigned();
            $table->timestamps();

            $table->primary(array('question', 'answer', 'participant'));

            $table->foreign('question')->references('id')->on('questions');
            $table->foreign('answer')->references('id')->on('answers');
            $table->foreign('participant')->references('id')->on('participants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participant_answers');
    }
}
