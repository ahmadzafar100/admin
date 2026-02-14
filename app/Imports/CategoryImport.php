<?php

namespace App\Imports;

use App\Models\Category;
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
            'display_name' => $row[1],
        ]);
    }
}
