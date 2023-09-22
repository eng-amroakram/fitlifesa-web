<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Traits\APIHelper;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    use APIHelper;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getSettings()
    {
        $settings = Settings::first();

        $array = [
            "email" => $settings->email,
            "mobile" => $settings->mobile,
            "site_url" => $settings->site_url,
            "video" => $settings->video,
            "privacy_policy" => $settings->privacy_policy,
            "terms_service" => $settings->terms_service,
            "about_us" => $settings->about_us,
        ];

        if ($settings) {
            return $this->response($array, __("Settings fetched successfully"), 200);
        }
    }
}
