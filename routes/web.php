<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SavedPostController;


Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/posts', [PostController::class, 'adminIndex'])->name('admin.posts');
    Route::delete('/admin/posts/{id_post}', [PostController::class, 'admindestroy'])->name('admin.deletePost');
});

Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
Route::delete('/admin/users/{id_user}', [AdminController::class, 'destroyUser'])->name('admin.deleteUser');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/beranda', [ViewController::class, 'index'])->name('beranda');
});

Route::post('/upload', [PostController::class, 'store'])->name('upload.store');

Route::delete('/delete-post/{uploadId}', [PostController::class, 'destroy'])
    ->middleware('auth')
    ->name('deletePost');


Route::middleware(['auth'])->group(function () {
    Route::post('/toggle-save', [SavedPostController::class, 'toggleSave'])->name('posts.toggle-save');
    Route::get('/check-saved/{upload}', [SavedPostController::class, 'checkSaved'])->name('posts.check-saved');
});

Route::get('/profile', [ProfileController::class, 'show'])->name('profile');

Route::post('/profile/update-photo', [ProfileController::class, 'updatePhoto'])->name('profile.updatePhoto');

Route::get('/preview', [PostController::class, 'preview'])->name('preview');
Route::get('/get-post-owner/{id_post}', [PostController::class, 'getPostOwner']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('login');
});

Route::get('/upload', function () {
    return view('upload');
});
