<?php

namespace App\Http\Controllers;

use App\Imports\CategoryImport;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::orderBy('id', 'desc')->get();
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
            Session::flash('err_msg', 'Category not saved.');
            return redirect('/admin/category');
        }
        Session::flash('success_msg', 'Category saved.');
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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv|max:2048',
        ]);

        Excel::import(new CategoryImport, $request->file('file'));
        return back()->with('success_msg', 'Data Imported Successfully');
    }
}
