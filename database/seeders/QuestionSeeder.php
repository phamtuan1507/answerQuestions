<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $question = \App\Models\Question::create([
        'question_text' => '1+1=?',
        'type' => 'multiple_choice',
        'correct_answer' => '1',
        'explanation' => '1+1=2',
    ]);
    \App\Models\Answer::create(['question_id' => $question->id, 'answer_text' => '2', 'is_correct' => true]);
    \App\Models\Answer::create(['question_id' => $question->id, 'answer_text' => '3', 'is_correct' => false]);
    }
}
