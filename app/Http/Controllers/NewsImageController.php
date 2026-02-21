<?php

namespace App\Http\Controllers;

use App\Models\NewsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

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

        $newsImage = new NewsImage();

        if ($r->hasFile('image')) {
            $newsImage->news_id = $id;
            $newsImage->image = '';

            if (!$newsImage->save()) {
                Alert::toast('News image not saved.', 'error');
                return redirect('/admin/news-images/' . $id);
            }

            $image = $r->file('image');

            $lastId = str_pad($newsImage->id, 7, '0', STR_PAD_LEFT);
            $extension = $r->image->getClientOriginalExtension();
            $imageName = date('dmY_His') . '_' . $id . '_' . $lastId . '.' . $extension;

            $image->move(public_path('uploads'), $imageName);

            $newsImage->update([
                'image' => $imageName
            ]);

            Alert::toast('News image saved.', 'success');
            return redirect('/admin/news-images/' . $id);
        }

        Alert::toast('No image uploaded.', 'error');
        return back();
    }
}
