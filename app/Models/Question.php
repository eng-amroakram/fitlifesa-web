<?php

namespace App\Models;

use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    use ModelHelper;

    protected $fillable = [
        'question',
        'choices',
        'status',
    ];

    public function scopeData($query)
    {
        return $query->select(['id', 'question', 'choices', 'status', 'created_at', 'updated_at']);
    }

    public function scopeFilters(Builder $builder, array $filters = [])
    {
        $filters = array_merge([
            'search' => '',
            'status' => null,
        ], $filters);

        $builder->when($filters['search'] != '', function ($query) use ($filters) {
            $query->where('question', 'like', '%' . $filters['search'] . '%');
        });

        $builder->when($filters['search'] == '' && $filters['status'] != null, function ($query) use ($filters) {
            $query->whereIn('status', $filters['status']);
        });
    }

    public function getQuestionAttribute()
    {
        return __($this->attributes['question']);
    }

    public function getChoicesAttribute($value)
    {
        $answers = json_decode($value);

        $choices = [];

        foreach ($answers as $answer) {
            $choices[] = __($answer);
        }

        return $choices;
    }

    public function setChoicesAttribute($value)
    {
        $this->attributes['choices'] = json_encode($value);
    }

    public function scopeGetRules(Builder $builder, $id = "")
    {
        return [
            "question" => ["required"],
        ];
    }

    public function scopeGetMessages(Builder $builder)
    {
        return [
            "question.required" => __("This field is required"),
        ];
    }

    public function scopeStore(Builder $builder, $data)
    {
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
