<?php

namespace App\Http\Controllers;

use App\Exports\NewsExport;
use App\Models\Category;
use App\Models\News;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /* public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:create news', [
            'only' => ['create', 'store']
        ]);
    } */

    public function index(Request $r)
    {
        $data = News::with(['category', 'subcategory'])->latest()->get();
        $data = News::with(['category', 'subcategory'])
            ->when($r->status !== null, function ($query) use ($r) {
                $query->where('status', $r->status);
            })
            ->when($r->is_breaking !== null, function ($query) use ($r) {
                $query->where('is_breaking_news', $r->is_breaking);
            })
            ->when($r->is_featured !== null, function ($query) use ($r) {
                $query->where('is_featured', $r->is_featured);
            })->latest()->get();
        $title = 'Delete Category!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('news', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cat = Category::where('status', 1)->orderBy('name')->get();
        return view('post-news', compact('cat'));
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
                // 'slug' => 'required|max:255',
                'summary' => 'required|max:255',
                'content' => 'required',
                // 'featured_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
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
        $news->slug = $this->generateUniqueSlug($request->title);
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
        // Storage::disk('public')->putFileAs('uploads', $request->file('featured_image'), $imageName);

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
        return view('post-news', compact('editdata', 'cat', 'subcat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all(), $request->file('featured_image'));
        $request->validate(
            [
                'category_id' => 'required',
                'subcategory_id' => 'required',
                'title' => 'required|max:255',
                // 'slug' => 'required|max:255',
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
        $news->slug = $this->generateUniqueSlug($request->title);
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
        $subcategories = Subcategory::where(['category_id' => $categoryId, 'status' => 1])->get();

        return response()->json($subcategories);
    }

    public function updateStatus(Request $request)
    {
        $news = News::findOrFail($request->news_id);
        $news->status = $request->status;
        $news->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully'
        ]);
    }

    public function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (News::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    public function export()
    {
        return Excel::download(new NewsExport, 'news_' . date('dmY_His') . '.xlsx');
    }
}
