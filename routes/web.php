<?php

use App\Http\Controllers\KategoriSuratController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
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
})->middleware('guest');

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
    //kategori surat
    Route::get('admin/kategori-surat', [KategoriSuratController::class, 'index'])->name('kategori-surat.admin.index');
    Route::post('admin/kategori-surat', [KategoriSuratController::class, 'create'])->name('kategori-surat.admin.create');
    Route::delete('admin/kategori-surat/{kategori}', [KategoriSuratController::class, 'destroy'])->name('kategori-surat.admin.destroy');
    Route::put('admin/kategori-surat/{id}', [KategoriSuratController::class, 'update'])->name('kategori-surat.admin.update');

    //surat masuk
    Route::get('admin/surat-masuk', [SuratMasukController::class, 'index'])->name('surat-masuk.admin.index');
    Route::get('admin/surat-masuk/tambah', [SuratMasukController::class, 'create'])->name('surat-masuk.admin.create');
    Route::post('admin/surat-masuk', [SuratMasukController::class, 'store'])->name('surat-masuk.admin.store');
    Route::delete('admin/surat-masuk/{suratMasuk}', [SuratMasukController::class, 'destroy'])->name('surat-masuk.admin.destroy');
    Route::get('admin/surat-masuk/{suratMasuk}/edit', [SuratMasukController::class, 'edit'])->name('surat-masuk.admin.edit');
    Route::put('admin/surat-masuk/{suratMasuk}', [SuratMasukController::class, 'update'])->name('surat-masuk.admin.update');
    Route::get('admin/surat-masuk/{suratMasuk}/show', [SuratMasukController::class, 'show'])->name('surat-masuk.admin.show');

    //surat keluar
    Route::get('admin/surat-keluar', [SuratKeluarController::class, 'index'])->name('surat-keluar.admin.index');
    Route::get('admin/surat-keluar/tambah', [SuratKeluarController::class, 'create'])->name('surat-keluar.admin.create');
    Route::post('admin/surat-keluar', [SuratKeluarController::class, 'store'])->name('surat-keluar.admin.store');
    Route::delete('admin/surat-keluar/{suratKeluar}', [SuratKeluarController::class, 'destroy'])->name('surat-keluar.admin.destroy');
    Route::get('admin/surat-keluar/{suratKeluar}/edit', [SuratKeluarController::class, 'edit'])->name('surat-keluar.admin.edit');
    Route::put('admin/surat-keluar/{suratKeluar}', [SuratKeluarController::class, 'update'])->name('surat-keluar.admin.update');
    Route::get('admin/surat-keluar/{suratKeluar}/show', [SuratKeluarController::class, 'show'])->name('surat-keluar.admin.show');
});

require __DIR__.'/auth.php';
