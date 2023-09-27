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

        foreach ($fruits as $fruit) {
            FoodExchange::create([
                'measurement_units' => $fruit['quantity'],
                'image' => '',
                'title_ar' => $fruit['title_ar'],
                'title_en' => $fruit['title_en'],
                'status' => 'active',
                'type' => 'fruit'
            ]);
        }

        $vegetables = config('data.Seeders.food.vegetables');

        foreach ($vegetables as $vegetable) {
            FoodExchange::create([
                'measurement_units' => $vegetable['quantity'],
                'image' => '',
                'title_ar' => $vegetable['title_ar'],
                'title_en' => $vegetable['title_en'],
                // 'quantity' => $quantity,
                'status' => 'active',
                'type' => 'vegetable'
            ]);
        }

        $dairy = config('data.Seeders.food.dairies');

        foreach ($dairy as $dair) {
            FoodExchange::create([
                'measurement_units' => $dair['quantity'],
                'image' => '',
                'title_ar' => $dair['title_ar'],
                'title_en' => $dair['title_en'],
                // 'quantity' => $quantity,
                'status' => 'active',
                'type' => 'dairy'
            ]);
        }

        $meat = config('data.Seeders.food.meats');

        foreach ($meat as $mea) {
            FoodExchange::create([
                'measurement_units' => $mea['quantity'],
                'image' => '',
                'title_ar' => $mea['title_ar'],
                'title_en' => $mea['title_en'],
                // 'quantity' => $quantity,
                'status' => 'active',
                'type' => 'meat'
            ]);
        }

        $starch = config('data.Seeders.food.starches');

        foreach ($starch as $sta) {
            FoodExchange::create([
                'measurement_units' => $sta['quantity'],
                'image' => '',
                'title_ar' => $sta['title_ar'],
                'title_en' => $sta['title_en'],
                // 'quantity' => $quantity,
                'status' => 'active',
                'type' => 'starch'
            ]);
        }

        $fat = config('data.Seeders.food.fats');

        foreach ($fat as $fa) {
            FoodExchange::create([
                'measurement_units' => $fa['quantity'],
                'image' => '',
                'title_ar' => $fa['title_ar'],
                'title_en' => $fa['title_en'],
                // 'quantity' => $quantity,
                'status' => 'active',
                'type' => 'fat'
            ]);
        }
    }
}
