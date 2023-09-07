<?php

namespace App\Models;

use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;
    use ModelHelper;

    protected $file_path = 'images/meals';

    protected $fillable = [
        'user_id',
        'recipes', // 'json
        'title_ar',
        'title_en',
        'status',
        'type'
    ];

    public function scopeData($query)
    {
        return $query->select(['id', 'user_id', 'recipes', 'title_ar', 'title_en', 'status', 'type', 'created_at', 'updated_at']);
    }

    public function scopeFilters(Builder $builder, array $filters = [])
    {
        $filters = array_merge([
            'search' => '',
            'status' => null,
            'type' => null,
        ], $filters);

        $builder->when($filters['search'] != '', function ($query) use ($filters) {
            $query->where('title_ar', 'like', '%' . $filters['search'] . '%')
                ->orWhere('title_en', 'like', '%' . $filters['search'] . '%');
        });

        $builder->when($filters['search'] == '' && $filters['status'] != null, function ($query) use ($filters) {
            $query->whereIn('status', $filters['status']);
        });

        $builder->when($filters['search'] == '' && $filters['type'] != null, function ($query) use ($filters) {
            $query->whereIn('type', $filters['type']);
        });

    }

    public function getMealTypeNameAttribute()
    {
        return $this->mealType ? $this->mealType->title : "None";
    }

    public function getTitleAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->title_ar : $this->title_en;
    }

    public function getRecipesAttribute($value)
    {
        return json_decode($value);
    }

    public function setRecipesAttribute($value)
    {
        $this->attributes['recipes'] = json_encode($value);
    }

    public function getRecipesNamesAttribute()
    {
        return getRecipesNames($this->recipes);
    }

    public function scopeGetRules(Builder $builder, $id = "")
    {
        return [
            'recipes' => 'required', // 'json
            "title_ar" => ["required"],
            "title_en" => ["required"],
            "type" => ["required", "in:breakfast,lunch,dinner,snack"],
        ];
    }

    public function scopeGetMessages(Builder $builder)
    {
        return [
            'recipes.required' => __("This field is required"), // 'json
            "title_ar.required" => __("This field is required"),
            "title_en.required" => __("This field is required"),
            "type.required" => __("This field is required"),
        ];
    }

    public function scopeStore(Builder $builder, $data)
    {
        $data['user_id'] = auth()->id();
        $data['status'] = 'active';

        $model = $builder->create($data);

        if ($model) {
            return __("Added Successfully");
        }

        return false;
    }

    public function scopeUpdateModel(Builder $builder, $data, $id)
    {
        $model = $builder->find($id);

        $result =  $model->update($data);

        if ($result) {
            return __("Updated Successfully");
        }

        return false;
    }
}
