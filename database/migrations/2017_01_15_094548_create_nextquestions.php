<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNextQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nextquestions', function (Blueprint $table) {
            $table->integer('source_question')->unsigned();
            $table->enum('gender', array('male', 'female', 'other'));
            $table->integer('next_question')->unsigned()->nullable(); // NULL = end report
            $table->timestamps();

            $table->primary(array('source_question', 'gender', 'next_question'));

            $table->foreign('source_question')->references('id')->on('questions');
            $table->foreign('next_question')->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nextquestions');
    }
}
