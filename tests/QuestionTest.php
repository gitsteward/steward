<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class QuestionTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testQuestionTable()
    {
        factory(App\Question::class)->create([
            'question' => 'exampleQuestion',
            'lang' => 'en'
        ]);
        $this->seeInDatabase('questions', ['question' => 'exampleQuestion']);
    }
}
