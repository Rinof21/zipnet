<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PublicSearchController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuickLinkController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// =======================
// PUBLIC (TANPA LOGIN / PROTEKSI PIN)
// =======================

// Verification PIN routes
Route::get('/public-pin', [PublicSearchController::class, 'showPinForm'])->name('public.pin.show');
Route::post('/public-pin', [PublicSearchController::class, 'verifyPin'])->name('public.pin.verify');

// Halaman publik yang dilindungi PIN (jika fitur PIN diaktifkan)
Route::middleware('public_pin')->group(function () {
    Route::get('/', [PublicSearchController::class, 'index'])->name('home');
    Route::get('/arsip', [PublicSearchController::class, 'index'])->name('public.search');
    Route::get('/preview/{document}', [PublicSearchController::class, 'preview'])->name('public.preview');
});

// Preview dokumen internal
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

    // Trash & Soft Delete Dokumen
    Route::get('/documents/trash/list', [DocumentController::class, 'trash'])->name('documents.trash');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->middleware('permission:edit dokumen')->name('documents.destroy');
    Route::post('/documents/trash/{id}/restore', [DocumentController::class, 'restore'])->middleware('permission:edit dokumen')->name('documents.restore');
    Route::delete('/documents/trash/{id}/force-delete', [DocumentController::class, 'forceDelete'])->middleware('permission:edit dokumen')->name('documents.forceDelete');

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

    // Quick Links / Menu Titik 9 (Khusus Super Admin)
    Route::resource('quick-links', QuickLinkController::class)->middleware('role:Super Admin');

    // Pengaturan PIN Publik (memerlukan izin kelola pin)
    Route::middleware('permission:kelola pin')->group(function () {
        Route::get('/settings/public-pin', [SettingController::class, 'publicPin'])->name('settings.public-pin');
        Route::post('/settings/public-pin', [SettingController::class, 'updatePublicPin'])->name('settings.public-pin.update');
    });

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
