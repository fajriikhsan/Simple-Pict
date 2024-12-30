<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Upload;
use App\Models\User;
use App\Models\SavedPost;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10000',
            'judul_post' => 'nullable|string|max:255',
            'desk_post' => 'nullable|string',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false, 
                'message' => 'Anda harus login terlebih dahulu'
            ], 401);
        }

        if ($request->hasFile('image')) {
            $originalName = $request->file('image')->getClientOriginalName();
            $filename = time() . '_' . $originalName;

            $filePath = $request->file('image')->storeAs('uploads', $filename, 'public');

            $upload = new Upload();
            $upload->id_user = Auth::id();
            $upload->file_post = $filePath;
            $upload->judul_post = $request->input('judul_post');
            $upload->desk_post = $request->input('desk_post');
            $upload->save();

            $imageUrl = Storage::url($filePath);

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil diupload!',
                'image_url' => $imageUrl,
                'post_id' => $upload->id
            ]);
        }

        return response()->json([
            'success' => false, 
            'message' => 'Gagal mengupload gambar'
        ], 400);

        return redirect()->route('home');
    }

    public function destroy($uploadId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false, 
                'message' => 'Anda harus login terlebih dahulu'
            ], 401);
        }
        
        $post = Upload::findOrFail($uploadId);
        if ($post->id_user != Auth::id()) {
            return response()->json([
                'success' => false, 
                'message' => 'Anda tidak memiliki izin menghapus postingan ini'
            ], 403);
        }
        
        SavedPost::where('id_post', $uploadId)->delete();
        $post->delete();
        
        return response()->json([
            'success' => true, 
            'message' => 'Postingan berhasil dihapus'
        ]);
    }
    

    public function preview(Request $request) {
        $title = $request->query('title');
        $description = $request->query('description');
        $image = $request->query('image');

        $upload = Upload::where('judul_post', $title)->first(); 

        if ($upload) {

            return view('preview', [
                'title' => $title,
                'description' => $description,
                'image' => $image,
                'id_post' => $upload->id,
                'post_user_id' => $upload->id_user,
                'current_user_id' => Auth::id()
            ]);

        }

        return redirect()->back()->with('error', 'Gambar tidak ditemukan.');
    }
    
     public function adminIndex()
    {
        $posts = Upload::with('user')->paginate(10);
        return view('admin.posts', compact('posts'));
    }

    public function admindestroy($id_post)
    {
        $upload = Upload::find($id_post);

        if (!$upload) {
            return redirect()->back()->with('error', 'Gambar tidak ditemukan.');
        }

        if (Auth::user()->role === 'admin' || Auth::id() === $upload->id_user) {
            if ($upload->image_path && Storage::exists($upload->image_path)) {
                Storage::delete($upload->image_path);
            }

            $upload->delete();
            return redirect()->route('admin.posts')->with('success', 'Post berhasil dihapus');
        }

        return redirect()->route('admin.posts')
            ->with('error', 'Anda tidak memiliki izin untuk menghapus post ini');
    }


    public function getPostOwner($id_post)
    {
        $post = Upload::find($id_post);
        $user = User::find($post->id_user);
        
        return response()->json([
            'username' => $user->username,
            'profile_photo' => $user->profile_photo
        ]);
    }    
}