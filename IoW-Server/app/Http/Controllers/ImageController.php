<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    // Returning a full image
    public function show($path)
    {
        $fullPath = storage_path('app/private/' . $path);

        if (!file_exists($fullPath)) {
            abort(404);
        }

        return response()->file($fullPath);
    }

    // Returning all images with prediction results
    public function index(){
        $images = Image::with('vision')->orderBy('created_at', 'desc')->paginate(10);

        return view('cameras.index', [
            'title' => "Images",
            'images' => $images,
        ]);
    }

    // Delete an image
    public function destroy(Image $image){

        Storage::delete($image->path);

        $image->delete();

        return back()->with('success', 'Image deleted!');
    }

    // Return the full prediction of one image
    public function vision(Image $image){

        $vision = DB::table('visions')
            ->select([
                DB::raw('`result`'),
                DB::raw('`Healthy` as healthy'),
                DB::raw('`Black Rot` as black_rot'),
                DB::raw('`Leaf Blight` as leaf_blight'),
                DB::raw('`Esca` as esca'),
                DB::raw('`Downy Mildew` as downy_mildew'),
                DB::raw('`Powdery Mildew` as powdery_mildew'),
            ])
            ->where('id', $image->id)
            ->first();


        return view('cameras.vision', [
            'title' => "Vision of Image",
            'image' => $image,
            'vision' => $vision
        ]);
    }
}
