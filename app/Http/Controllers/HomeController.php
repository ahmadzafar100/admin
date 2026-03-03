<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class HomeController
{
    function index()
    {
        // $categories = Category::where('status', 1)->orderBy('name')->get();
        return view('homepage');
    }
}
