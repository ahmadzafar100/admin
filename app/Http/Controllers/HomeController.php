<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class HomeController
{
    function index()
    {
        $newsSliders = News::where('status', 'published')->with(['category', 'subcategory'])->latest()->take(3)->get();
        $breakingNews = News::select('id', 'title')->where('is_breaking_news', 1)->with(['category', 'subcategory'])->latest()->get();
        $featuredNews = News::where('is_featured', 1)->with(['category', 'subcategory'])->latest()->take(4)->get();
        return view('homepage', compact('newsSliders', 'featuredNews', 'breakingNews'));
    }
}
