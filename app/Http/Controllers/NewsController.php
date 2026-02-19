<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
        $data = News::with(['category', 'subcategory'])->latest()->get();
        $title = 'Delete Category!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('news', compact('cat', 'data'));
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
        $request->validate(
            [
                'category_id' => 'required',
                'subcategory_id' => 'required',
                'title' => 'required|max:255',
                'summary' => 'required|max:255',
                'content' => 'required',
                'featured_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                'croppedImage' => 'required',
                'status' => 'required',
                'published_at' => 'required',
                'is_featured' => 'nullable|boolean',
                'is_breaking_news' => 'nullable|boolean',
            ],
            [
                'category_id.required' => 'Category is required.',
                'subcategory_id.required' => 'Subcategory is required.',
            ]
        );

        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');
        $data['is_breaking_news'] = $request->has('is_breaking_news');

        $news = new News();
        $news->category_id = $data['category_id'];
        $news->subcategory_id = $data['subcategory_id'];
        $news->title = $data['title'];
        $news->slug = time();
        $news->summary = $data['summary'];
        $news->content = $data['content'];
        // $news->featured_image = $imageName;
        $news->status = $data['status'];
        $news->published_at = date('Y-m-d H:i:s', strtotime($data['published_at']));
        $news->is_featured = $data['is_featured'];
        $news->is_breaking_news = $data['is_breaking_news'];
        $news->user_id = session('user')->id;

        // dd($request->all());

        if (!$news->save()) {
            // Session::flash('err_msg', 'News not saved.');
            Alert::toast('News not saved.', 'error');
            return redirect('/admin/news');
        }

        $image = $request->croppedImage;

        // Remove base64 header
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);

        $lastId = str_pad($news->id, 7, '0', STR_PAD_LEFT);
        $extension = $data['featured_image']->getClientOriginalExtension();
        $imageName = date('dmY_His') . '_' . $lastId . '.' . $extension;

        File::put(public_path('uploads/' . $imageName), base64_decode($image));

        $news->update([
            'featured_image' => $imageName
        ]);

        Alert::toast('News saved.', 'success');
        // Session::flash('success_msg', 'News saved.');
        return redirect('/admin/news');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = News::findOrFail($id);
        return view('news-detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cat = Category::orderBy('name')->get();
        $editdata = News::findOrFail($id);
        $subcat = Subcategory::where('category_id', $editdata->category_id)->orderBy('name')->get();
        return view('news', compact('editdata', 'cat', 'subcat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        dd($request->all(), $request->file('featured_image'));
        $request->validate(
            [
                'category_id' => 'required',
                'subcategory_id' => 'required',
                'title' => 'required|max:255',
                'summary' => 'required|max:255',
                'content' => 'required',
                'featured_image' => 'mimes:jpeg,png,jpg|max:5120',
                'status' => 'required',
                'published_at' => 'required',
                'is_featured' => 'nullable|boolean',
                'is_breaking_news' => 'nullable|boolean',
            ],
            [
                'category_id.required' => 'Category is required.',
                'subcategory_id.required' => 'Subcategory is required.',
            ]
        );

        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');
        $data['is_breaking_news'] = $request->has('is_breaking_news');

        $news = News::findOrFail($id);

        $filename = explode('.', $news->featured_image);

        if ($request->hasFile('featured_image')) {

            $image = $request->croppedImage;

            // Remove base64 header
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);

            $lastId = str_pad($id, 7, '0', STR_PAD_LEFT);
            $extension = $data['featured_image']->getClientOriginalExtension();
            $imageName = $filename[0] . '.' . $extension;

            File::put(public_path('uploads/' . $imageName), base64_decode($image));
        } else {
            $imageName = $news->featured_image;
        }

        $news->category_id = $data['category_id'];
        $news->subcategory_id = $data['subcategory_id'];
        $news->title = $data['title'];
        $news->slug = time();
        $news->summary = $data['summary'];
        $news->content = $data['content'];
        $news->featured_image = $imageName;
        $news->status = $data['status'];
        $news->published_at = date('Y-m-d H:i:s', strtotime($data['published_at']));
        $news->is_featured = $data['is_featured'];
        $news->is_breaking_news = $data['is_breaking_news'];
        $news->user_id = session('user')->id;

        // dd($request->all());

        if (!$news->save()) {
            // Session::flash('err_msg', 'News not saved.');
            Alert::toast('News not updated.', 'error');
            return redirect('/admin/news');
        }

        Alert::toast('News updated.', 'success');
        // Session::flash('success_msg', 'News saved.');
        return redirect('/admin/news');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $del = News::destroy($id);
        if (!$del) {
            Alert::toast('News not deleted.', 'error');
            return redirect()->back();
        }
        Alert::toast('News deleted.', 'success');
        return redirect()->back();
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)->get();

        return response()->json($subcategories);
    }
}
