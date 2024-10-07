<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm() {
        return view('login');
    }

   public function showLoginForm() {
        return view('login');
    }

    public function login(Request $request) {
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    
    if (auth()->attempt(['username' => $request->username, 'password' => $request->password])) {
        session(['username' => $request->username]);

        if (auth()->user()->role === 'user') {
            return redirect('/beranda');
        } else {
            return redirect('/admin.dashboard');
        }

        return back()->withErrors(['message' => 'Invalid credentials']);
    }
    }
}
