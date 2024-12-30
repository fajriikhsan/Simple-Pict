<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all(); 

        return view('admin.users', compact('users'));
    }
    
    public function destroyUser($id_user)
    {
        try {
            $user = User::findOrFail($id_user);
            $user->delete();
    
            return redirect()->route('admin.users')->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.users')->with('error', 'Failed to delete user');
        }
    }

}
