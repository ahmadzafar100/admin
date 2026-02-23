<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index()
    {
        $category = Category::count();
        $categoryLastCreated = Category::latest()->first();
        $subcategory = Subcategory::count();
        $subcategoryLastCreated = Subcategory::latest()->first();
        $newsTotal = News::count();
        $newsBreaking = News::where('is_breaking_news', 1)->count();
        $newsFeatured = News::where('is_featured', 1)->count();
        $newsDraft = News::where('status', 'draft')->count();
        $newsPublished = News::where('status', 'published')->count();
        $newsArchived = News::where('status', 'archived')->count();
        $lastNewsCreated = News::latest()->first();
        $lastNewsUpdated = News::latest('updated_at')->first();
        return view('dashboard', compact('category', 'categoryLastCreated', 'subcategory', 'subcategoryLastCreated', 'newsTotal', 'newsBreaking', 'newsFeatured', 'newsDraft', 'newsPublished', 'newsArchived', 'lastNewsCreated', 'lastNewsUpdated'));
    }
}
