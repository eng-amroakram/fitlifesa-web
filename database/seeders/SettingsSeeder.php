<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        if (!Storage::disk('public')->exists('images/settings')) {
            Storage::disk('public')->makeDirectory('images/settings');
        }

        if (Storage::disk('publicFolder')->exists('assets/videos/Intro.mp4')) {

            if (!Storage::disk('public')->exists('images/settings/Intro.mp4')) {
                Storage::disk('public')->delete('images/settings/Intro.mp4');
            }
            $file = Storage::disk('publicFolder')->get('assets/videos/Intro.mp4');
            Storage::disk('public')->put('images/settings/Intro.mp4', $file);
        }

        $data = [
            'email' => "eng-amroakram@gmail.com",
            'mobile' => "+966599916672",
            'site_url' => "https://www.fitlifesa.co",
            'video' => "intro.mp4",
            'privacy_policy_en' => "https://www.fitlifesa.co",
            'privacy_policy_ar' => "https://www.fitlifesa.co",
            'terms_service_en' => "https://www.fitlifesa.co",
            'terms_service_ar' => "https://www.fitlifesa.co",
            'about_us_en' => "https://www.fitlifesa.co",
            'about_us_ar' => "https://www.fitlifesa.co",
        ];

        Settings::create($data);
    }
}
