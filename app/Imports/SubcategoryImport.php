<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Subcategory;
use App\Services\SlugService;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;

class SubcategoryImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (Subcategory::where('name', $row[1])->exists()) {
            return null; // skip duplicate
        }

        /* $category = Category::where('name', $row[0])->first();

        if (!$category) {
            return null; // skip if category not found
        } */

        $category = Category::firstOrCreate(
            ['name' => $row[0]],
            ['name' => $row[0], 'slug' => SlugService::generateCategoryUniqueSlug($row[0])]
        );

        return new Subcategory([
            'name' => $row[1],
            'slug' => SlugService::generateSubcategoryUniqueSlug($row[1]),
            'category_id' => $category->id,
        ]);
    }
}
