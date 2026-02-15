<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'display_name'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
