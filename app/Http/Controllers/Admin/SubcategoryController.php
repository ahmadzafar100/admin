<?php

namespace App\Http\Controllers\Admin;

use App\Imports\SubcategoryImport;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class SubcategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:create subcategories')->only(['create', 'store', 'import']);
    }

    public function index()
    {
        $data = Subcategory::with('category')->latest()->get();
        $title = 'Delete subcategory!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('admin.subcategory', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cat = Category::where('status', 1)->orderBy('name')->get();
        return view('admin.create-subcategory', compact('cat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'name' => 'required|unique:subcategories',
        ]);

        $subcategory = new Subcategory();
        $subcategory->category_id = $request->category;
        $subcategory->name = $request->name;
        $subcategory->slug = $this->generateUniqueSlug($request->name);
        if (!$subcategory->save()) {
            // Session::flash('err_msg', 'Subcategory not saved.');
            Alert::toast('Subcategory not saved.', 'error');
            return redirect('/admin/subcategory');
        }
        // Session::flash('success_msg', 'Subcategory saved.');
        Alert::toast('Subcategory saved.', 'success');
        return redirect('/admin/subcategory');
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
        $data = Subcategory::find($id);
        $category = Category::orderBy('name')->get();
        return view('admin.create-subcategory', ['editdata' => $data, 'cat' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category' => 'required',
            'name' => 'required|unique:subcategories,name,' . $id,
        ]);

        $subcategory = Subcategory::find($id);
        $subcategory->category_id = $request->category;
        $subcategory->name = $request->name;
        $subcategory->slug = $this->generateUniqueSlug($request->name);
        if (!$subcategory->save()) {
            // Session::flash('err_msg', 'Subcategory not updated.');
            Alert::toast('Subcategory not updated.', 'error');
            return redirect('/admin/subcategory');
        }
        // Session::flash('success_msg', 'Subcategory updated.');
        Alert::toast('Subcategory updated.', 'success');
        return redirect('/admin/subcategory');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $del = Subcategory::destroy($id);
        if (!$del) {
            Alert::toast('Subcategory not deleted.', 'error');
            return redirect()->back();
        }
        // return back()->with('success_msg', 'subcategory deleted.');
        Alert::toast('Subcategory deleted.', 'success');
        return redirect()->back();
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv|max:2048',
        ]);

        Excel::import(new SubcategoryImport, $request->file('file'));
        Alert::toast('Subcategory Imported Successfully.', 'success');
        return redirect('/admin/subcategory');
    }

    function deactivate($id)
    {
        $update = Subcategory::find($id);
        $update->status = 0;

        if ($update->save()) {
            // Session::flash('action_msg', 'Subcategory deactivated.');
            Alert::toast('Subcategory deactivated.', 'success');
            return redirect('/admin/subcategory');
        }
    }

    function activate($id)
    {
        $update = Subcategory::find($id);
        $update->status = 1;

        if ($update->save()) {
            // Session::flash('action_msg', 'Subcategory activated.');
            Alert::toast('Subcategory activated.', 'success');
            return redirect('/admin/subcategory');
        }
    }

    public function changeStatus(Request $request, $id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $subcategory->status = $request->status;
        $subcategory->save();

        return response()->json([
            'message' => 'Status updated successfully'
        ]);
    }

    public function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (Subcategory::where('slug', $slug)->exists()) {
            if ($count === 1) continue;
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
