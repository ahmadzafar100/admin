<?php

namespace App\Imports;

use App\Models\Category;
use App\Services\SlugService;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;

class CategoryImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (Category::where('name', $row[0])->exists()) {
            return null; // skip duplicate
        }

        return new Category([
            'name' => $row[0],
            'slug' => SlugService::generateCategoryUniqueSlug($row[0]),
        ]);
    }
}
