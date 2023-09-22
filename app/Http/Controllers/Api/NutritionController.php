<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FoodExchange;
use App\Traits\APIHelper;
use Illuminate\Http\Request;

class NutritionController extends Controller
{
    use APIHelper;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function foodExchanges($types = "")
    {
        $filters = [
            'search' => $this->request->query('search', ''),
            'type' => $types ? explode(',', $types) : null,
        ];

        $food_exchanges = FoodExchange::filters($filters)->get();
        return $this->response($food_exchanges, __("Food exchanges retrieved successfully"), 200);
    }
}
