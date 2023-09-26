<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            EquipmentSeeder::class,
            MuscleSeeder::class,
            GoalSeeder::class,
            MeasurementUnitSeeder::class,
            FoodExchangeSeeder::class,
            RecipeSeeder::class,
            MealSeeder::class,
            MealPlanSeeder::class,
            QuestionSeeder::class,
            TagSeeder::class,

            // LevelSeeder::class,
            // ChallengeSeeder::class,
            // WorkoutSeeder::class,
            // ExerciseSeeder::class,
            SettingsSeeder::class,
        ]);
    }
}
