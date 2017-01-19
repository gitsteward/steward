<?php

use Illuminate\Database\Seeder;
use App\Question;
use App\Answer;

class QuestionTableSeeder extends Seeder
{
    // Used to create all questions first, and then add the answers for them.
    var $tmpQuestions = array();

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
      $this->emptyTables();
      $this->insertQuestionsAndAnswers();
    }

    /**
     * Delete previously entered questions and
     * answers.
     *
     * @return void
     */
    private function emptyTables() {
      DB::table('answers')->delete();
      DB::table('questions')->delete();

      $this->command->info('Question and Answer tables emptied.');
    }

    /**
     * First insert all questions before adding all answers, because the
     * answers reference question-id's that should exist in the database.
     *
     * @return void
     */
    private function insertQuestionsAndAnswers() {
      $qCounter = $this->insertQuestions();
      $aCounter = $this->insertAnswers();

      $info = sprintf('Added %u questions and %u answers.', $qCounter, $aCounter);
      $this->command->info($info);
    }

    /**
     * Insert all questions given in /database/seeds/QuestionsAndAnswers.yaml
     *
     * @return Integer amout of questions added to database
     */
    private function insertQuestions() {

      // Stores amount of questions added
      $qCounter = 0;

      foreach ($this->getQuestions() as $q) {

        Question::create(array(
          'id' => $q['id'],
          'question' => $q['question'],
          'lang' => $q['lang'],
          'show_partner' => $q['show_partner']
        ));

        // Store temporarily so answers can be added once all questions are
        // present in database. Needed because while in this for loop, not
        // all questions have been added yet, so we get foreign key constraints.
        $this->tmpQuestions[] = array(
          'questionId' => $q['id'],
          'answers' => $q['answers']
        );

        $qCounter++;
      }

      return $qCounter;
    }

    /**
     * Insert answers for all questions in $this->tmpQuestions which is
     * populated first by the $this->insertQuestions() function.
     *
     * @return Integer amout of answers added to database
     */
    private function insertAnswers() {

      // Stores amount of answers added
      $aCounter = 0;

      // $tmpQuestions is populated by $this->insertQuestions()
      foreach ($this->tmpQuestions as $a) {

        foreach($a['answers'] as $answer) {

          // Remove newlines from answer before insert
          $cleanAnswer = trim(preg_replace('/\s+/', ' ', $answer['text']));

          Answer::create(array(
            'question' => $a['questionId'],
            'nextquestion' => $answer['nextquestion'],
            'answer' => $cleanAnswer
          ));

          $aCounter++;
        }

      }

      return $aCounter;
    }

    /**
     * Get array of questions and answers
     *
     * @return array
     */
    private function getQuestions() {
      return yaml_parse_file(database_path() . '/seeds/QuestionsAndAnswers.yaml');
    }
}
