<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class FrontController
{
    function index()
    {
        $newsSliders = News::where('status', 'published')->with(['category', 'subcategory'])->latest()->take(3)->get();
        $breakingNews = News::where('status', 'published')->where('is_breaking_news', 1)->with(['category', 'subcategory'])->latest()->get();
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
        $latestNews5 = $latestNews->slice(9, 2);
        $latestNews6 = $latestNews->slice(11, 2);

        return view('homepage', compact('newsSliders', 'featuredNews', 'breakingNews', 'featuredNewsAll', 'latestNews1', 'latestNews2', 'latestNews3', 'latestNews4', 'latestNews5', 'latestNews6'));
    }

    function categoryWise($category)
    {
        $categoryName = $category;
        $news = News::where('status', 'published')
            ->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            })
            ->with(['category', 'subcategory'])
            ->latest()
            ->get();
        return view('news', compact('news', 'categoryName'));
    }

    function subcategoryWise($category, $subcategory)
    {
        $categoryName = $category;
        $subcategoryName = $subcategory;
        $news = News::where('status', 'published')
            ->whereHas('subcategory', function ($query) use ($subcategory) {
                $query->where('slug', $subcategory);
            })
            ->with(['category', 'subcategory'])
            ->latest()
            ->get();
        return view('news', compact('news', 'categoryName', 'subcategoryName'));
    }
    function newsDetail($category, $subcategory, $news)
    {
        $categoryName = $category;
        $subcategoryName = $subcategory;
        $news = News::where('slug', $news)->with(['category', 'subcategory'])->firstOrFail();
        if (!session()->has('news_' . $news->id)) {
            $news->increment('views');
            session()->put('news_' . $news->id, true);
        }
        return view('news-detail', compact('news', 'categoryName', 'subcategoryName'));
    }

    function search(Request $request)
    {
        $keyword = $request->search;

        $news = News::where('status', 'published')
            ->where('title', 'LIKE', "%{$keyword}%")
            ->orWhere('summary', 'LIKE', "%{$keyword}%")
            ->orWhere('content', 'LIKE', "%{$keyword}%")
            ->orWhereHas('category', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%");
            })
            ->orWhereHas('subcategory', function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%$keyword%");
            })
            ->with(['category', 'subcategory'])
            ->latest()
            ->get();

        return view('news', compact('news', 'keyword'));
    }
}
