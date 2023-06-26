<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image; // facades para integrar algo externo con laravel

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $image = $request->file('file');
        $imageName = Str::uuid() . '.' . $image->extension();

        $imageToStore = Image::make($image);
        $imageToStore->fit(1000, 1000, null, 'center'); // dimensions

        // store in public/uploads
        $imagePath = public_path('uploads') . '/' . $imageName;
        $imageToStore->save($imagePath);

        return response()->json(['image' => $imageName]);
    }
}
