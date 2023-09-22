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
        if ($settings) {
            return $this->response($settings->toArray(), __("Settings fetched successfully"), 200);
        }
    }
}
