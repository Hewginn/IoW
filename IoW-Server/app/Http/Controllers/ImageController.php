<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function show($path)
    {
        $fullPath = storage_path('app/private/' . $path);

        if (!file_exists($fullPath)) {
            abort(404);
        }

        return response()->file($fullPath);
    }

    public function index(){
        $images = Image::with('vision')->orderBy('created_at', 'desc')->paginate(10);

        return view('cameras.index', [
            'title' => "Images",
            'images' => $images,
        ]);
    }

    public function destroy(Image $image){

        Storage::delete($image->path);

        $image->delete();

        return back()->with('success', 'Image deleted!');
    }

    public function vision(Image $image){

        $vision = $image->vision;

        return view('cameras.vision', [
            'title' => "Vision of Image",
            'image' => $image,
            'vision' => $vision
        ]);
    }
}
