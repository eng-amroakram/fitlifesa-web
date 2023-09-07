<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = config('data.Seeders.questions');

        foreach ($questions as $id => $question) {
            Question::create([
                'question' => $question[0],
                'choices' => $question['answers'],
            ]);
        }
    }
}
