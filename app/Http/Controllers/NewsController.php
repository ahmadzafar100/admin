<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cat = Category::orderBy('name')->get();
        $subcat = Subcategory::orderBy('name')->get();
        $data = News::with(['category', 'subcategory'])->latest()->get();

        return view('news', compact('cat', 'subcat', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'subcategory' => 'required',
            'title' => 'required|max:255',
            'summary' => 'required|max:255',
            'content' => 'required',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg|max:1024',
            'status' => 'required',
            'published_at' => 'required',
            'is_featured' => 'required',
            'is_breaking_news' => 'required',
        ]);

        $is_featured = $request->is_featured ?? 0;
        $is_breaking_news = $request->is_breaking_news ?? 0;

        $news = new News;
        $news->category_id = $request->category_id;
        $news->subcategory_id = $request->subcategory_id;
        $news->title = $request->title;
        $news->slug = 'https://google.com';
        $news->summary = $request->summary;
        $news->content = $request->content;
        $news->featured_image = '';
        $news->status = $request->status;
        $news->published_at = $request->published_at;
        $news->is_featured = $is_featured;
        $news->is_breaking_news = $is_breaking_news;
        $news->user_id = session('user')->id;

        dd($request->all());

        if (!$news->save()) {
            // Session::flash('err_msg', 'News not saved.');
            Alert::toast('News not saved.', 'error');
            return redirect('/admin/news');
        }
        Alert::toast('News saved.', 'success');
        // Session::flash('success_msg', 'News saved.');
        return redirect('/admin/news');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)->get();

        return response()->json($subcategories);
    }
}
