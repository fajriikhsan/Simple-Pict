<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;

class ViewController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('search');

        if ($keyword) {
            $uploads = Upload::where('judul_post', 'LIKE', "%$keyword%")
                ->orWhere('desk_post', 'LIKE', "%$keyword%")
                ->get();
        } else {
            $uploads = Upload::all();
        }

        return view('tampilan', compact('uploads', 'keyword'));
    }
}

