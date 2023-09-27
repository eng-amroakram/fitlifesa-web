<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FoodExchange;
use App\Models\Post;
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

    public function posts($sections = "", $tag_ids = null)
    {
        $filters = [
            'search' => $this->request->query('search', ''),
            'section' => $sections ? explode(',', $sections) : null,
            'tag_id' => $tag_ids ? explode(',', $tag_ids) : null,
        ];

        $posts = Post::filters($filters)->whereHas('tag', function ($query) {
            $query->where('status', 'active');
        })->get();

        return $this->response($posts, __("Posts retrieved successfully"), 200);
    }
}
