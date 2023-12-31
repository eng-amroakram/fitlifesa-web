<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FoodExchange;
use App\Models\MealPlan;
use App\Models\Post;
use App\Models\Tag;
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
            'status' => ['active'],
        ];

        $posts = Post::filters($filters)->whereHas('tag', function ($query) {
            $query->where('status', 'active');
        })->get();

        $tags = Tag::where('status', 'active')->get();

        $data = [
            'posts' => $posts,
            'tags' => $tags,
        ];

        return $this->response($data, __("Posts retrieved successfully"), 200);
    }

    public function post($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return $this->response([], __("Post not found"), 404);
        }

        return $this->response($post, __("Post retrieved successfully"), 200);
    }

    public function suggestedMealPlan()
    {
        $meal_plans = MealPlan::whereHas(
            "user",
            function ($query) {
                $query->where('type', "admin");
            }
        )->get()->random(1);

        $meal_plan = $meal_plans->count() ? $meal_plans->first() : [];

        return $this->response($meal_plan, __("Meal plan retrieved successfully"), 200);
    }
}
