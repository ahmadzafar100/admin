<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class HomeController
{
    function index()
    {
        $newsSliders = News::where('status', 'published')->with(['category', 'subcategory'])->latest()->take(3)->get();
        $breakingNews = News::select('id', 'title')->where('status', 'published')->where('is_breaking_news', 1)->with(['category', 'subcategory'])->latest()->get();
        $featuredNews = News::where('status', 'published')->where('is_featured', 1)->with(['category', 'subcategory'])->latest()->take(4)->get();
        $featuredNewsAll = News::where('status', 'published')->where('is_featured', 1)->with(['category', 'subcategory'])->latest()->get();
        $latestNews = News::where('status', 'published')
            ->with(['category', 'subcategory'])
            ->latest()
            ->take(13) // total needed: 4+2+2+1+4 = 13
            ->get();

        $latestNews1 = $latestNews->slice(0, 4);
        $latestNews2 = $latestNews->slice(4, 2);
        $latestNews3 = $latestNews->slice(6, 2);
        $latestNews4 = $latestNews->slice(8, 1);
        $latestNews5 = $latestNews->slice(9, 4);
        return view('homepage', compact('newsSliders', 'featuredNews', 'breakingNews', 'featuredNewsAll', 'latestNews1', 'latestNews2', 'latestNews3', 'latestNews4', 'latestNews5'));
    }
}
