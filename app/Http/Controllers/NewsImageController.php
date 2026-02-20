<?php

namespace App\Http\Controllers;

use App\Models\NewsImage;
use Illuminate\Http\Request;

class NewsImageController extends Controller
{
    function index(string $id)
    {
        $data = NewsImage::where('news_id', $id)->orderBy('id', 'desc')->get();
        return view('news-images', compact('data', 'id'));
    }

    function addImage(Request $r, string $id)
    {
        $r->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);
    }
}
