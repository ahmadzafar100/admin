<?php

namespace App\Http\Controllers;

use App\Imports\CategoryImport;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::orderBy('id', 'desc')->get();
        $title = 'Delete Category!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('category', ['data' => $category]);
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
            'name' => 'required|unique:categories',
            'display_name' => 'required'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->display_name = $request->display_name;
        if (!$category->save()) {
            Alert::toast('Category not saved.', 'error');
            // Session::flash('err_msg', 'Category not saved.');
            return redirect('/admin/category');
        }
        Alert::toast('Category added successfully!', 'success');
        // Session::flash('success_msg', 'Category saved.');
        return redirect('/admin/category');
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
        $data = Category::find($id);
        return view('category', ['editdata' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'display_name' => 'required'
        ]);

        $category = Category::find($id);
        $category->name = $request->name;
        $category->display_name = $request->display_name;
        if (!$category->save()) {
            // Session::flash('err_msg', 'Category not updated.');
            Alert::toast('Category not updated.', 'error');
            return redirect('/admin/category');
        }
        Alert::toast('Category updated.', 'success');
        // Session::flash('success_msg', 'Category updated.');
        return redirect('/admin/category');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $del = Category::destroy($id);
        if (!$del) {
            Alert::toast('Category not deleted.', 'error');
            return redirect()->back();
        }
        // return back()->with('success_msg', 'Category deleted.');
        Alert::toast('Category deleted.', 'success');
        return redirect()->back();
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv|max:2048',
        ]);

        Excel::import(new CategoryImport, $request->file('file'));
        Alert::toast('Category Imported Successfully', 'success');
        return redirect()->back();
    }

    function deactivate($id)
    {
        $update = Category::find($id);
        $update->status = 0;

        if ($update->save()) {
            // Session::flash('action_msg', 'Category deactivated.');
            Alert::toast('Category deactivated.', 'success');
            return redirect('/admin/category');
        }
    }

    function activate($id)
    {
        $update = Category::find($id);
        $update->status = 1;

        if ($update->save()) {
            // Session::flash('action_msg', 'Category activated.');
            Alert::toast('Category activated.', 'success');
            return redirect('/admin/category');
        }
    }
}
