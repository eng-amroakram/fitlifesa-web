<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = config("data.Seeders.tags");

        foreach ($tags as $id => $tag) {
            Tag::create([
                "title_ar" => $tag["ar"],
                "title_en" => $tag["en"],
                "status" => "active",
            ]);
        }
    }
}
