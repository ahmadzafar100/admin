<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\News;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NewsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        $category = Category::firstOrCreate(
            [
                'name' => $row['category']
            ],
            [
                'name' => $row['category'],
                'display_name' => $row['category'],
            ]
        );

        $subcategory = Subcategory::firstOrCreate(
            [
                'name' => $row['subcategory'],
                'category_id' => $category?->id,
            ],
            [
                'name' => $row['subcategory'],
                'display_name' => $row['subcategory'],
                'category_id' => $category?->id,
            ]
        );

        $user = Auth::user();

        return new News([
            'title' => $row['title'],
            'slug' => Str::slug($row['title']),
            'summary' => $row['summary'],
            'content' => $row['content'],
            'featured_image' => '',
            'category_id' => $category?->id,
            'subcategory_id' => $subcategory?->id,
            'status' => $row['status'],
            'published_at' => date('Y-m-d H:i:s', strtotime($row['published_at'])),
            'is_featured' => ($row['is_featured'] === 'yes') ? 1 : 0,
            'is_breaking_news' => ($row['is_breaking_news'] === 'yes') ? 1 : 0,
            'user_id' => $user->id,
        ]);
    }
}
