<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriSuratController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\UserController;
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
    $user = Auth::user();
    $validRoles = ['admin', 'user'];

    if (in_array($user->role, $validRoles)) {
        $data = DashboardController::getDashboardData();
        return view($user->role . '/dashboard', $data);
    }

    abort(403, 'Role tidak dikenali');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //kategori surat
    Route::get('kategori-surat', [KategoriSuratController::class, 'index'])->name('kategori-surat.admin.index');
    Route::post('kategori-surat', [KategoriSuratController::class, 'create'])->name('kategori-surat.admin.create');
    Route::delete('kategori-surat/{kategori}', [KategoriSuratController::class, 'destroy'])->name('kategori-surat.admin.destroy');
    Route::put('kategori-surat/{id}', [KategoriSuratController::class, 'update'])->name('kategori-surat.admin.update');

     //surat masuk
     Route::get('surat-masuk', [SuratMasukController::class, 'index'])->name('surat-masuk.admin.index');
     Route::get('surat-masuk/tambah', [SuratMasukController::class, 'create'])->name('surat-masuk.admin.create');
     Route::post('admin/surat-masuk', [SuratMasukController::class, 'store'])->name('surat-masuk.admin.store');
     Route::delete('surat-masuk/{suratMasuk}', [SuratMasukController::class, 'destroy'])->name('surat-masuk.admin.destroy');
     Route::get('surat-masuk/{suratMasuk}/edit', [SuratMasukController::class, 'edit'])->name('surat-masuk.admin.edit');
     Route::put('surat-masuk/{suratMasuk}', [SuratMasukController::class, 'update'])->name('surat-masuk.admin.update');
     Route::get('surat-masuk/{suratMasuk}/show', [SuratMasukController::class, 'show'])->name('surat-masuk.admin.show');
     Route::get('search/surat-masuk', [SuratMasukController::class, 'search'])->name('surat-masuk.admin.search');
     Route::get('surat-masuk/form/laporan', [SuratMasukController::class, 'formLaporan'])->name('surat-masuk.admin.form-laporan'); 
     Route::post('surat-masuk/laporan', [SuratMasukController::class, 'laporan_surat'])->name('surat-masuk.admin.laporan');
     Route::get('laporan-surat-masuk/pdf', [SuratMasukController::class, 'exportPdf'])->name('laporan.surat-masuk.admin.pdf');

     //surat keluar
    Route::get('admin/surat-keluar', [SuratKeluarController::class, 'index'])->name('surat-keluar.admin.index');
    Route::get('admin/surat-keluar/tambah', [SuratKeluarController::class, 'create'])->name('surat-keluar.admin.create');
    Route::post('admin/surat-keluar', [SuratKeluarController::class, 'store'])->name('surat-keluar.admin.store');
    Route::delete('admin/surat-keluar/{suratKeluar}', [SuratKeluarController::class, 'destroy'])->name('surat-keluar.admin.destroy');
    Route::get('admin/surat-keluar/{suratKeluar}/edit', [SuratKeluarController::class, 'edit'])->name('surat-keluar.admin.edit');
    Route::put('admin/surat-keluar/{suratKeluar}', [SuratKeluarController::class, 'update'])->name('surat-keluar.admin.update');
    Route::get('admin/surat-keluar/{suratKeluar}/show', [SuratKeluarController::class, 'show'])->name('surat-keluar.admin.show');
    Route::get('admin/search/surat-keluar', [SuratKeluarController::class, 'search'])->name('surat-keluar.admin.search');
    Route::get('admin/surat-keluar/form/laporan', [SuratKeluarController::class, 'formLaporan'])->name('surat-keluar.admin.form-laporan');
    Route::post('admin/surat-keluar/laporan', [SuratKeluarController::class, 'laporan_surat'])->name('surat-keluar.admin.laporan');
    Route::get('admin/laporan-surat-keluar/pdf', [SuratKeluarController::class, 'exportPdf'])->name('laporan.surat-keluar.admin.pdf');

});

Route::middleware('auth', 'permission:admin')->group(function () {
    //users
    Route::get('admin/users',[UserController::class, 'index'])->name('users.admin.index');
    Route::get('admin/users/{id}', [UserController::class, 'show'])->name('users.admin.show');
    Route::get('admin/users/edit/{id}', [UserController::class, 'edit'])->name('users.admin.edit');
    Route::post('admin/user/create',[UserController::class,'create'])->name('users.admin.create');
    Route::put('admin/users/update/{id}',[UserController::class, 'update'])->name('users.admin.update');
    Route::delete('admin/users/delete/{id}',[UserController::class, 'delete'])->name('users.admin.delete');
});

require __DIR__.'/auth.php';
