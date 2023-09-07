<?php

namespace App\Models;

use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    use ModelHelper;

    protected $file_path = 'images/equipment';

    protected $fillable = [
        'image',
        'title_ar',
        'title_en',
        'status',
    ];

    public function scopeData($query)
    {
        return $query->select(['id', 'image', 'title_ar', 'title_en', 'status', 'created_at', 'updated_at']);
    }

    public function scopeFilters(Builder $builder, array $filters = [])
    {
        $filters = array_merge([
            'search' => '',
            'status' => null,
        ], $filters);

        $builder->when($filters['search'] != '', function ($query) use ($filters) {
            $query->where('title_ar', 'like', '%' . $filters['search'] . '%')
                ->orWhere('title_en', 'like', '%' . $filters['search'] . '%');
        });

        $builder->when($filters['search'] == '' && $filters['status'] != null, function ($query) use ($filters) {
            $query->whereIn('status', $filters['status']);
        });
    }

    public function getImageTableAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('assets/images/no-image-available.jpg');
    }

    public function getTitleAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->title_ar : $this->title_en;
    }

    public function scopeGetRules(Builder $builder, $id = "")
    {
        return [
            "title_ar" => ["required"],
            "title_en" => ["required"],
            "image" => ["required"],
        ];
    }

    public function scopeGetMessages(Builder $builder)
    {
        return [
            "title_ar.required" => __("This field is required"),
            "title_en.required" => __("This field is required"),
            "image.required" => __("This field is required"),
        ];
    }

    public function scopeStore(Builder $builder, $data)
    {
        $data['status'] = 'active';
        $data['image'] = $builder->storeFile($data['image']);
        $this->deleteLivewireTempImage();

        $model = $builder->create($data);

        if ($model) {
            return __("Added Successfully");
        }

        return false;
    }

    public function scopeUpdateModel(Builder $builder, $data, $id)
    {
        $image = $data['image'];
        $model = $builder->find($id);

        if (gettype($image) == "object") {
            $builder->deleteImage($id);
            $data['image'] = $builder->storeFile($image);
            $this->deleteLivewireTempImage();
        } else {
            unset($data['image']);
            unset($data['status']);
        }

        $result =  $model->update($data);

        if ($result) {
            return __("Updated Successfully");
        }

        return false;
    }
}
