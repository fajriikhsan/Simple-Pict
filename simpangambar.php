<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\SavedImage;
use Illuminate\Support\Facades\Auth;


class ImageController extends Controller
{
    public function saveImage($imageId)
    {
        $user = Auth::user(); 
        $image = Image::findOrFail($imageId); 

        if ($user->savedImages()->where('image_id', $image->id)->exists()) {
            return response()->json(['message' => 'Image already saved to your library'], 400);
        }

        $user->savedImages()->attach($image->id);

        return response()->json(['message' => 'Image saved to your library'], 200);
    }
}