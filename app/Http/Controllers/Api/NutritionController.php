<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FoodExchange;
use App\Traits\APIHelper;
use Illuminate\Http\Request;

class NutritionController extends Controller
{
    use APIHelper;

    public function foodExchanges()
    {
        $food_exchanges = FoodExchange::all();
        return $this->response($food_exchanges, __("Food exchanges retrieved successfully"), 200);
    }
}
