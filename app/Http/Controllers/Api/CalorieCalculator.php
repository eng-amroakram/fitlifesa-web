<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CalorieCalculator extends Controller
{
    public $create = false;
    public $protein_intake = 0;
    public $carbs_intake = 0;
    public $fat_intake = 0;
    public $plan; // low_carb, low_fat, high_protien, own

    public $protein = 0;
    public $carbs = 0;
    public $fat = 0;

    public $waist = 0;
    public $neck = 0;
    public $hip = 0;

    public $fat_mass = 0;
    public $lean_mass = 0;

    public $calories = 0;
    public $min_calories = 0;
    public $max_calories = 0;

    public $protein_gram = 0;
    public $protein_calories = 0;
    public $protein_percent = 0;

    public $carbs_gram = 0;
    public $carbs_calories = 0;
    public $carbs_percent = 0;

    public $fats_gram = 0;
    public $fats_calories = 0;
    public $fats_percent = 0;

    public $body_fats_percentage = 0;
    public  $body_fat_percentage_details = 0;

    public $protein_factors = [];

    public $BMI; // Body Mass Index
    public $IBM; // Ideal Body Mass
    public $BMI_status;

    private $age;
    private $gender;
    private $height;
    private $weight;
    private $goal; // gain, maintain, lose
    private $level;   // beginner, intermediate, advanced
    private $activity; // off, low, medium, high
    private $activity_factor;

    private $kg_per_week;

    public $constant_calories = [];

    //Food Types

    public $starches = 0;
    public $fruits = 0;
    public $vegetables = 0;
    public $meats = 0;
    public $dairy = 0;
    public $oils = 0;


    public function __construct($age, $gender, $height, $weight, $goal, $level, $activity,  $kg_per_week, $carbs_intake = 0, $fat_intake = 0, $protein_intake = 0, $waist = 0, $neck = 0, $hip = 0)
    {
        $activity_factors = config('data.api.activity-factors');
        $this->protein_factors = config("data.api.protein-factors");
        $this->constant_calories = config("data.api.constant-calories");

        $this->age = (int)$age;
        $this->gender = (string)$gender;
        $this->height = (int)$height;
        $this->weight = (int)$weight;
        $this->goal = (string)$goal;
        $this->level = (string)$level;
        $this->activity = (string)$activity;
        $this->activity_factor = $activity_factors[$activity];
        $this->kg_per_week = (float)$kg_per_week;
        $this->carbs_intake = $carbs_intake;
        $this->fat_intake = $fat_intake;
        $this->protein_intake = $protein_intake;
        $this->waist = $waist;
        $this->neck = $neck;
        $this->hip = $hip;

        // dd(
        //     "age",
        //     $this->age,
        //     "gender",
        //     $this->gender,
        //     "height",
        //     $this->height,
        //     "weight",
        //     $this->weight,
        //     "goal",
        //     $this->goal,
        //     "level",
        //     $this->level,
        //     "activity",
        //     $this->activity,
        //     "activity_factor",
        //     $this->activity_factor,
        //     "kg_per_week",
        //     $this->kg_per_week,
        //     "carbs_intake",
        //     $this->carbs_intake,
        //     "fat_intake",
        //     $this->fat_intake,
        //     "protein_intake",
        //     $this->protein_intake,
        //     "waist",
        //     $this->waist,
        //     "neck",
        //     $this->neck,
        //     "hip",
        //     $this->hip,
        // );

        $this->BMI = $this->calculateBMI();
        $this->BMIStatus();
        $this->IBM = $this->calculateIBM();
    }


    public function calculateBMI()
    {
        $height_percent =  $this->height / 100;
        $BMI = $this->weight / ($height_percent * $height_percent);
        return $BMI;
    }

    public function calculateIBM()
    {
        $height_percent =  $this->height / 100;
        $IBM = 21.5 * ($height_percent * $height_percent);
        return $IBM;
    }

    public function BMIStatus()
    {
        if ($this->BMI < 18.5) {
            $this->BMI_status = "underweight";
        }

        if ($this->BMI > 18.5 && $this->BMI < 25) {
            $this->BMI_status = "normal";
        }

        if ($this->BMI > 25 && $this->BMI < 30) {
            $this->BMI_status = "overweight";
        }

        if ($this->BMI > 30) {
            $this->BMI_status = "obese";
        }
    }

    public function BMIInRange()
    {
        if ($this->BMI < 18.5 || $this->BMI > 25) {
            return true;
        }

        return false;
    }

    public function BMIOutRange()
    {
        if ($this->BMI > 18.5 && $this->BMI < 25) {
            return true;
        }

        return false;
    }

    public function calculateCalories()
    {
        if ($this->BMIInRange()) {

            if ($this->gender == "male") {
                $this->calories = (66.5 + (13.75 * $this->IBM) + (5.0031 * $this->height) - (6.755 * $this->age)) * $this->activity_factor;
            }

            if ($this->gender == "female") {
                $this->calories = (665 + (9.563 * $this->IBM) + (1.850 * $this->height) - (4.676 * $this->age)) * $this->activity_factor;
            }
        }

        if ($this->BMIInRange()) {
            if ($this->gender == "male") {
                $this->calories = (66.5 + (13.75 * $this->weight) + (5.0031 * $this->height) - (6.755 * $this->age)) * $this->activity_factor;
            }

            if ($this->gender == "female") {
                $this->calories = (665 + (9.563 * $this->weight) + (1.850 * $this->height) - (4.676 * $this->age)) * $this->activity_factor;
            }
        }

        dd(
            $this->calories,
            $this->height,
            $this->age,
            $this->activity_factor,
            $this->weight,
            $this->BMIInRange(),
            $this->BMIOutRange(),
            $this->IBM
        );

        return $this;
    }

    public function goal()
    {
        if ($this->BMIInRange()) {
            if ($this->goal == "lose") {
                $this->min_calories = $this->calories;
                $this->max_calories = $this->calories - 500;
            }

            if ($this->goal == "gain") {
                $this->min_calories = $this->calories;
                $this->max_calories = $this->calories + 500;
            }
        }

        if ($this->BMIOutRange()) {
            if ($this->goal == "lose") {
                $this->min_calories = $this->calories - 500;
                $this->max_calories = $this->calories;
            }

            if ($this->goal == "gain") {
                $this->min_calories = $this->calories;
                $this->max_calories = $this->calories + 500;
            }
        }

        return $this;
    }

    public function weightPerWeek()
    {
        if ($this->calories < 1200) {
            $this->min_calories = 1200;
        }

        if ($this->goal == "gain") {
            if (in_array($this->kg_per_week, ['0.5', 0.5])) {
                $this->calories = $this->min_calories;
            }

            if (in_array($this->kg_per_week, ['1', 1])) {
                $this->calories = $this->max_calories;
            }
        }

        if ($this->goal == "lose") {
            if (in_array($this->kg_per_week, ['0.5', 0.5])) {
                $this->calories = $this->max_calories;
            }

            if (in_array($this->kg_per_week, ['1', 1])) {
                $this->calories = $this->min_calories;
            }
        }

        return $this;
    }

    public function checkBMIGoalCalory()
    {
        if ($this->BMI > 25) {
            $this->weight = $this->IBM;
        }

        if ($this->goal == "gain") {
            $this->calories = $this->max_calories;
        }

        if ($this->goal == "lose") {
            $this->calories = $this->min_calories;
        }
    }

    public function fats()
    {
        $this->fats_calories = 0.30 * $this->calories;
        $this->fats_gram = $this->fats_calories / 9;
        $this->fats_percent = ($this->fats_calories / $this->calories);
        return $this;
    }

    public function carbs()
    {
        $this->carbs_calories = $this->calories - ($this->protein_calories + $this->fats_calories);
        $this->carbs_gram = $this->carbs_calories / 4;
        $this->carbs_percent = ($this->carbs_calories / $this->calories);
        return $this;
    }

    public function proteins()
    {
        $protein_factor = $this->protein_factors[$this->goal . '-' . $this->activity . '-' . $this->level];

        dd($this->calories);

        $this->protein_gram =  $protein_factor * $this->weight;
        $this->protein_calories = $this->protein_gram * 4;
        $this->protein_percent = ($this->protein_calories / $this->calories);

        if ($this->protein_percent < 0.10) {
            $this->protein_calories = 0.10 * $this->calories;
            $this->protein_gram = $this->protein_calories / 4;
        } elseif ($this->protein_percent > 0.35) {
            $this->protein_calories = 0.35 * $this->calories;
            $this->protein_gram = $this->protein_calories / 4;
        }

        return $this;
    }

    public function createMacronutrientsPlan()
    {
        if ($this->plan == "low_carbs") {
            $this->carbs_calories = 0.40 * $this->calories;
            $this->carbs_gram = $this->carbs_calories / 4;

            $this->fats_calories = 0.30 * $this->calories;
            $this->fats_gram = $this->fats_calories / 9;

            $this->protein_calories = $this->calories - ($this->carbs_calories + $this->fats_calories);
            $this->protein_gram = $this->protein_calories / 4;
        }

        if ($this->plan == "low_fats") {
            $this->fats_calories = 0.20  * $this->calories;
            $this->fats_gram = $this->fats_calories / 9;
            $this->protein_calories = 0.25 * $this->calories;
            $this->protein_gram = $this->protein_calories / 4;
            $this->carbs_calories = $this->calories - ($this->fats_calories + $this->protein_calories);
            $this->carbs_gram = $this->carbs_calories / 4;
        }

        if ($this->plan == "high_protiens") {
            $this->protein_calories = $this->protein_calories + 0.05 * $this->calories;
            $this->protein_gram = $this->protein_calories / 4;
            $this->carbs_calories = 0.45 * $this->calories;
            $this->carbs_gram = $this->carbs_calories / 4;
            $this->fats_calories = $this->calories - ($this->protein_calories + $this->carbs_calories);
            $this->fats_gram = $this->fats_calories / 9;
        }

        if ($this->plan == "own") {
            $this->protein_intake = $this->protein_intake / 100;
            $this->carbs_intake = $this->carbs_intake / 100;
            $this->fat_intake = $this->fat_intake / 100;

            $this->protein_calories = $this->protein_intake * $this->calories;
            $this->protein_gram = $this->protein_calories / 4;
            $this->carbs_calories = $this->carbs_intake * $this->calories;
            $this->carbs_gram = $this->carbs_calories / 4;
            $this->fats_calories = $this->fat_intake * $this->calories;
            $this->fats_gram = $this->fats_calories / 9;
        }

        if ($this->calories < 1200 || $this->min_calories < 1200) {
            $this->calories = 1200;
            $this->min_calories = 1200;
        }

        return $this;
    }

    public function bodyFatsPercentage()
    {
        if ($this->gender == "male") {
            $this->body_fats_percentage = 1.20 * $this->BMI + 0.23 * $this->age - 16.2;
        }

        if ($this->gender == "female") {
            $this->body_fats_percentage = 1.20 * $this->BMI + 0.23 * $this->age - 5.4;
        }

        return $this;
    }

    public function addWaterBeforeTraining($water)
    {
        dd($water);
    }

    public function addWaterAfterTraining($water)
    {
        dd($water);
    }

    public function oneRepetitionMaximum($weight, $reps)
    {
        $one_repetition_maximum = $weight / ((100 - (2.5 * $reps)) / 100);
        $percent = 100;
        $x = 10;

        while ($x > 10) {
            $percent = $percent - 5;
            $new = ($percent * $one_repetition_maximum) / 100;
            $x = $x - 1;
        }

        dd($percent, $new);
    }

    public function servings()
    {
        $daily_calories = $this->calories; // 2000
        $calories_of_types_foods = [80, 60, 25, 75, 120, 45];

        $starches = 80;
        $fruits = 60;
        $vegetables = 25;
        $meats = 75;
        $dairy = 120;
        $oils = 45;

        $total_fixed_calories_of_types_food = 405; // 100% of the calories of the types of food

        //The percentage of calories of the types of food
        $starches_percentage = ($starches / $total_fixed_calories_of_types_food) * 100; // 19.75%
        $fruits_percentage = ($fruits / $total_fixed_calories_of_types_food) * 100; // 14.81%
        $vegetables_percentage = ($vegetables / $total_fixed_calories_of_types_food) * 100; // 6.17%
        $meats_percentage = ($meats / $total_fixed_calories_of_types_food) * 100; // 18.52%
        $dairy_percentage = ($dairy / $total_fixed_calories_of_types_food) * 100; // 29.63%
        $oils_percentage = ($oils / $total_fixed_calories_of_types_food) * 100; // 11.11%

        //The calories of the types of food
        $starches_calories = ($starches_percentage * $daily_calories) / 100; // 19.75% * 2000 = 395
        $fruits_calories = ($fruits_percentage * $daily_calories) / 100; // 14.81% * 2000 = 296.2
        $vegetables_calories = ($vegetables_percentage * $daily_calories) / 100; // 6.17% * 2000 = 123.4
        $meats_calories = ($meats_percentage * $daily_calories) / 100; // 18.52% * 2000 = 370.4
        $dairy_calories = ($dairy_percentage * $daily_calories) / 100; // 29.63% * 2000 = 592.6
        $oils_calories = ($oils_percentage * $daily_calories) / 100; // 11.11% * 2000 = 222.2

        $calories = [$starches_calories, $fruits_calories, $vegetables_calories, $meats_calories, $dairy_calories, $oils_calories];

        $closestCalories = array_map(
            function ($calore, $calories_of_types_food) {
                return round($calore / $calories_of_types_food) * $calories_of_types_food;
            },
            $calories,
            $calories_of_types_foods,
        );

        $this->starches = $closestCalories[0] / 80;
        $this->fruits = $closestCalories[1] / 60;
        $this->vegetables = $closestCalories[2] / 25;
        $this->meats = $closestCalories[3] / 75;
        $this->dairy = $closestCalories[4] / 120;
        $this->oils = $closestCalories[5] / 45;

        return $this;
    }
}
