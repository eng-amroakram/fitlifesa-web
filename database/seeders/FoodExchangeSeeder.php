<?php

namespace Database\Seeders;

use App\Models\FoodExchange;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodExchangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fruits = config('data.Seeders.food.fruits');

        foreach ($fruits as $fruit => $quantity) {
            FoodExchange::create([
                'measurement_units' => [],
                'image' => '',
                'title_ar' => __($fruit),
                'title_en' => $fruit,
                'quantity' => $quantity,
                'status' => 'active',
                'type' => 'fruit'
            ]);
        }

        $vegetables = config('data.Seeders.food.vegetables');

        foreach ($vegetables as $vegetable => $quantity) {
            FoodExchange::create([
                'measurement_units' => [],
                'image' => '',
                'title_ar' => __($vegetable),
                'title_en' => $vegetable,
                'quantity' => $quantity,
                'status' => 'active',
                'type' => 'vegetable'
            ]);
        }
    }
}
