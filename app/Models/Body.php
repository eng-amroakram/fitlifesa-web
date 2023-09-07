<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Body extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'goal',
        'level',
        'activity',
        'gender',
        'age',
        'kg_per_week',
        'weight',
        'height',
        'BMI',
        'BMI_status',
        'IBM',
        'calories',
        'min_calories',
        'max_calories',
        'protein_gram',
        'protein_calories',
        'protein_percent',
        'carbs_gram',
        'carbs_calories',
        'carbs_percent',
        'fats_gram',
        'fats_calories',
        'fats_percent',
        'body_fats_percentage',
        'body_fat_percentage_details',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getCheckUserBodyAttribute()
    {
        $user = auth()->user();

        if ($user) {
            $user = User::with("body")->find($user->id);
            $body = $user->body;

            if ($body) {
                if ($body->gender && $body->age && $body->weight && $body->height && $body->activity && $body->goal && $body->kg_per_week && $body->level) {
                    return true;
                }
            }
        }

        return false;
    }
}
