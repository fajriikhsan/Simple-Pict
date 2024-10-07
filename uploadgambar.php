<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller
{
    public function create() {
        return view('upload-form'); 
    }

    
    public function store(Request $request) {
        $request->validate([
            'image' => 'required|mimes:jpg,jpeg,png,gif|max:20000', 
        ]);

        
        if ($request->hasFile('image')) {
            
            $filePath = $request->file('image')->store('public/images');
            
            $fileName = basename($filePath);

            return back()->with('success', 'Image uploaded successfully!');
        }

        return back()->withErrors('Image upload failed.');
    }
}