<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Body;
use App\Models\Question;
use App\Models\User;
use App\Traits\APIHelper;
use Illuminate\Http\Request;

class Questionnaire extends Controller
{
    use APIHelper;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getQuestions()
    {
        $questions = Question::select(['id', 'question', 'choices'])->get();

        return $this->response($questions, "Questions fetched successfully", 200);
    }

    public function submitQuestions()
    {
        $user = auth()->user();
        $data = $this->request->validated;

        $calculator = new CalorieCalculator(
            $age = $data['age'],
            $gender = $data['gender'],
            $height = $data['height'],
            $weight = $data['weight'],
            $goal = $data['goal'],
            $level = $data['level'],
            $activity = $data['activity'],
            $kg_per_week = $data['kg_per_week'],
        );

        $calculator = $calculator->calculateCalories()->goal()->weightPerWeek();
        $macronutrients = $calculator->proteins()->fats()->carbs()->bodyFatsPercentage();
        $food_types = $macronutrients->servings();

        Body::updateOrCreate([
            'user_id' => $user->id,
        ], [
            'goal' => $data['goal'],
            'level' => $data['level'],
            'activity' => $data['activity'],
            'kg_per_week' => $data['kg_per_week'],
            'weight' => $data['weight'],
            'height' => $data['height'],
            'BMI' => $calculator->BMI,
            'BMI_status' => $calculator->BMI_status,
            'IBM' => $calculator->IBM,
            'gender' => $data['gender'],
            'age' => $data['age'],

            // Calories
            'calories' => $calculator->calories,
            'min_calories' => $calculator->min_calories,
            'max_calories' => $calculator->max_calories,

            // Macronutrients
            'protein_gram' => $macronutrients->protein_gram,
            'protein_calories' => $macronutrients->protein_calories,
            'protein_percent' => $macronutrients->protein_percent,

            'carbs_gram' => $macronutrients->carbs_gram,
            'carbs_calories' => $macronutrients->carbs_calories,
            'carbs_percent' => $macronutrients->carbs_percent,

            'fats_gram' => $macronutrients->fats_gram,
            'fats_calories' => $macronutrients->fats_calories,
            'fats_percent' => $macronutrients->fats_percent,

            // Body Fats
            'body_fats_percentage' => $macronutrients->body_fats_percentage,
            'body_fat_percentage_details' => $macronutrients->body_fat_percentage_details,
        ]);

        $user = User::with("body")->find($user->id);
        $body = $user->body;
        $user->is_body_info_completed = $body->check_user_body;
        return $this->response(["user" => $user], "Questions submitted successfully", 200);
    }

    public function createMacronutrientsPlan()
    {
        $data = $this->request->validated;

        $user = auth()->user();
        $body = $user->body;

        $calculator = new CalorieCalculator(
            $age = $body->age,
            $gender = $body->gender,
            $height = $body->height,
            $weight = $body->weight,
            $goal = $body->goal,
            $level = $body->level,
            $activity = $body->activity,
            $kg_per_week = $body->kg_per_week,

            $carbs_intake = $data['carbs_intake'] ?? 0,
            $fat_intake = $data['fat_intake'] ?? 0,
            $protein_intake = $data['protein_intake'] ?? 0,
        );

        dd($calculator);
    }
}
