<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PublicSearchController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// =======================
// PUBLIC (TANPA LOGIN)
// =======================
Route::get('/', [PublicSearchController::class, 'index'])->name('home');
Route::get('/arsip', [PublicSearchController::class, 'index'])->name('public.search');

// Preview PDF untuk publik (tanpa login)
Route::get('/preview/{document}', [PublicSearchController::class, 'preview'])
    ->name('public.preview');


// Preview dokumen untuk publik
Route::get('/documents/{document}/preview', [DocumentController::class, 'preview'])
    ->name('documents.preview');

// =======================
// HALAMAN LOGIN/AKUN
// =======================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// =======================
// AREA ADMIN / PENGELOLA (HARUS LOGIN)
// =======================
Route::middleware('auth')->group(function () {

    // Upload
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents/store', [DocumentController::class, 'store'])->name('documents.store');

    // Download dokumen (misal hanya admin yang boleh)
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

    // View detail internal
    Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');

    Route::get('/documents/{id}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::put('/documents/{id}', [DocumentController::class, 'update'])->name('documents.update');

    // Pencarian internal
    Route::get('/search', [DocumentController::class, 'search'])->name('documents.search');

    // Tags
    Route::get('/tags/{tag}', [TagController::class, 'show'])->name('tags.show');

    // Kategori
    Route::resource('categories', CategoryController::class);

    // Roles & Permissions CRUD
    Route::resource('roles', RoleController::class);
    Route::post('/roles/permissions/store', [RoleController::class, 'storePermission'])->name('roles.storePermission');

    // Users CRUD
    Route::resource('users', UserController::class);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =======================
// LOGOUT
// =======================
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

require __DIR__ . '/auth.php';
