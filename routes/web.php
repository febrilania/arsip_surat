<?php

use App\Http\Controllers\KategoriSuratController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user(); // Simpan user agar tidak dipanggil berulang

    // Daftar role yang valid
    $validRoles = ['admin', 'user'];
    // Cek apakah role user valid
    if (in_array($user->role, $validRoles)) {
        return view($user->role . '/dashboard');
    }

    // Jika role tidak valid, tampilkan error
    abort(403, 'Role tidak dikenali');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'permission:admin')->group(function () {
    Route::get('admin/kategori-surat', [KategoriSuratController::class, 'index'])->name('kategori-surat.admin.index');
    Route::post('admin/kategori-surat', [KategoriSuratController::class, 'create'])->name('kategori-surat.admin.create');
    Route::delete('admin/kategori-surat/{kategori}', [KategoriSuratController::class, 'destroy'])->name('kategori-surat.admin.destroy');
    Route::put('admin/kategori-surat/{id}', [KategoriSuratController::class, 'update'])->name('kategori-surat.admin.update');
});

require __DIR__.'/auth.php';
