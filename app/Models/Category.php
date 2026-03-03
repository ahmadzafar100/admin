<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            if ($category->isForceDeleting()) {
                $category->subcategories()->forceDelete();
            } else {
                $category->subcategories()->delete();
            }
        });
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
