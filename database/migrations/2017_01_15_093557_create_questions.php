<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            // Primary key is not incremented because we need to know the id
            // of questions to seed database beforehand from
            // QuestionsAndAnswers.yaml
            $table->integer('id')->unsigned();
            $table->primary('id');

            $table->text('question');
            $table->string('lang', 15); // For long lang like 'zh-hant-cn'
            $table->enum('show_partner', array('always', 'same_answer'));
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('questions');
    }
}
