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

    // Upload (memerlukan izin tambah dokumen)
    Route::get('/documents/create', [DocumentController::class, 'create'])->middleware('permission:tambah dokumen')->name('documents.create');
    Route::post('/documents/store', [DocumentController::class, 'store'])->middleware('permission:tambah dokumen')->name('documents.store');

    // Download dokumen
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

    // View detail internal
    Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');

    // Edit dokumen (memerlukan izin edit dokumen)
    Route::get('/documents/{id}/edit', [DocumentController::class, 'edit'])->middleware('permission:edit dokumen')->name('documents.edit');
    Route::put('/documents/{id}', [DocumentController::class, 'update'])->middleware('permission:edit dokumen')->name('documents.update');

    // Lampiran dokumen
    Route::get('/documents/attachments/{attachment}/download', [DocumentController::class, 'downloadAttachment'])->name('documents.attachments.download');
    Route::delete('/documents/attachments/{attachment}', [DocumentController::class, 'destroyAttachment'])->middleware('permission:edit dokumen')->name('documents.attachments.destroy');

    // Pencarian internal
    Route::get('/search', [DocumentController::class, 'search'])->name('documents.search');

    // Tags
    Route::get('/tags/{tag}', [TagController::class, 'show'])->name('tags.show');

    // Kategori (memerlukan izin kelola kategori)
    Route::resource('categories', CategoryController::class)->middleware('permission:kelola kategori');

    // Roles & Permissions CRUD (memerlukan izin kelola peran)
    Route::resource('roles', RoleController::class)->middleware('permission:kelola peran');
    Route::post('/roles/permissions/store', [RoleController::class, 'storePermission'])->middleware('permission:kelola peran')->name('roles.storePermission');

    // Users CRUD (memerlukan izin kelola pengguna)
    Route::resource('users', UserController::class)->middleware('permission:kelola pengguna');

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
