<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Subcategory;
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
        if (Subcategory::where('name', $row[0])->exists()) {
            return null; // skip duplicate
        }

        /* $category = Category::where('name', $row[0])->first();

        if (!$category) {
            return null; // skip if category not found
        } */

        $category = Category::firstOrCreate(
            ['name' => $row[0]],
            ['name' => $row[0], 'display_name' => $row[0]]
        );

        return new Subcategory([
            'name' => $row[1],
            'display_name' => $row[2],
            'category_id' => $category->id,
        ]);
    }
}
