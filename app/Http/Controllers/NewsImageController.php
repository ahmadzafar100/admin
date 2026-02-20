<?php

namespace App\Http\Controllers;

use App\Models\NewsImage;
use Illuminate\Http\Request;

class NewsImageController extends Controller
{
    function index()
    {
        $data = NewsImage::orderBy('id', 'desc')->get();
        return view('news-images', compact('data'));
    }
}
