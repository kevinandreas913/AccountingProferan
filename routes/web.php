<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\JurnalUmumController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\LabaRugiController;
use App\Http\Controllers\NeracaController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PenyesuaianController;
use App\Http\Controllers\PerubahanModalController;
use App\Http\Controllers\PiutangController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UtangController;
use App\Http\Controllers\VisiMisiController;
use Illuminate\Support\Facades\Hash;
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
    return view('index');
});

Route::get('/advance-kalkulator', function() {
    return view('templates/advance-kalkulator');
});
Route::get('/normal-kalkulator', function() {
    return view('templates/normal-kalkulator');
});

// Authentication
Route::prefix('auth')->middleware('guest')->group(function() {
    Route::get('/login', [LoginController::class, 'index'])->name('auth.login.view');
    Route::post('/login', [LoginController::class, 'login'])->name('auth.login');

    Route::get('/admin/login', [LoginController::class, 'index_admin'])->name('auth.admin.login.view');
    Route::post('/admin/login', [LoginController::class, 'login_admin'])->name('auth.admin.login');

    Route::get('/register', [RegisterController::class, 'index'])->name('auth.register.view');
    Route::post('/register', [RegisterController::class, 'register'])->name('auth.register');
});


// User Panel
Route::middleware('auth')->group(function() {
    Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/data-assets', [DashboardController::class, 'dataAssets'])->name('dashboard.dataAssets');
    Route::get('/dashboard/data-liability', [DashboardController::class, 'dataLiability'])->name('dashboard.dataLiability');

    Route::get('/pemasukan', [PemasukanController::class, 'index'])->name('pemasukan.view');
    Route::get('/pemasukan/table', [PemasukanController::class, 'table'])->name('pemasukan.table');
    Route::post('/pemasukan', [PemasukanController::class, 'createUpdate'])->name('pemasukan.createUpdate');
    Route::get('/pemasukan/edit/{id}', [PemasukanController::class, 'edit'])->name('pemasukan.edit');
    Route::post('/pemasukan/destroy', [PemasukanController::class, 'destroy'])->name('pemasukan.destroy');

    Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.view');
    Route::get('/pengeluaran/table', [PengeluaranController::class, 'table'])->name('pengeluaran.table');
    Route::post('/pengeluaran', [PengeluaranController::class, 'createUpdate'])->name('pengeluaran.createUpdate');
    Route::get('/pengeluaran/edit/{id}', [PengeluaranController::class, 'edit'])->name('pengeluaran.edit');
    Route::post('/pengeluaran/destroy', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');

    Route::get('/utang', [UtangController::class, 'index'])->name('utang.view');
    Route::get('/utang/table', [UtangController::class, 'table'])->name('utang.table');
    Route::post('/utang', [UtangController::class, 'createUpdate'])->name('utang.createUpdate');
    Route::get('/utang/edit/{id}', [UtangController::class, 'edit'])->name('utang.edit');
    Route::post('/utang/destroy', [UtangController::class, 'destroy'])->name('utang.destroy');

    Route::get('/piutang', [PiutangController::class, 'index'])->name('piutang.view');
    Route::get('/piutang/table', [PiutangController::class, 'table'])->name('piutang.table');
    Route::post('/piutang', [PiutangController::class, 'createUpdate'])->name('piutang.createUpdate');
    Route::get('/piutang/edit/{id}', [PiutangController::class, 'edit'])->name('piutang.edit');
    Route::post('/piutang/destroy', [PiutangController::class, 'destroy'])->name('piutang.destroy');

    Route::get('/penyesuaian', [PenyesuaianController::class, 'index'])->name('penyesuaian.view');
    Route::get('/penyesuaian/table', [PenyesuaianController::class, 'table'])->name('penyesuaian.table');
    Route::post('/penyesuaian', [PenyesuaianController::class, 'createUpdate'])->name('penyesuaian.createUpdate');
    Route::get('/penyesuaian/edit/{id}', [PenyesuaianController::class, 'edit'])->name('penyesuaian.edit');
    Route::post('/penyesuaian/destroy', [PenyesuaianController::class, 'destroy'])->name('penyesuaian.destroy');


    Route::prefix('laporan')->group(function() {
        Route::get('/jurnal-umum', [JurnalUmumController::class, 'index'])->name('laporan.jurnal.umum.view');
        Route::get('/jurnal-umum/cetak', [JurnalUmumController::class, 'print'])->name('laporan.jurnal.umum.print');

        Route::get('/laba-rugi', [LabaRugiController::class, 'index'])->name('laporan.laba.rugi.view');
        Route::get('/laba-rugi/cetak', [LabaRugiController::class, 'print'])->name('laporan.laba.rugi.print');

        Route::get('/perubahan-modal', [PerubahanModalController::class, 'index'])->name('laporan.perubahan.modal.view');
        Route::get('/perubahan-modal/cetak', [PerubahanModalController::class, 'print'])->name('laporan.perubahan.modal.print');

        Route::get('/neraca', [NeracaController::class, 'index'])->name('laporan.neraca.view');
        Route::get('/neraca/cetak', [NeracaController::class, 'print'])->name('laporan.neraca.print');
    });
});

// Admin Panel
Route::prefix('admin')->middleware(['auth:admin'])->group(function() {
    Route::post('/logout', [LoginController::class, 'logout_admin'])->name('auth.admin.logout');

    Route::get('/dashboard', function() {
        return view('pages.dashboard.admin');
    });

    Route::prefix('visi-misi')->group(function() {
        Route::get('/', [VisiMisiController::class, 'index'])->name('visi_misi.index');
        Route::get('/table', [VisiMisiController::class, 'table'])->name('visi_misi.table');
        Route::post('/storeOrUpdate', [VisiMisiController::class, 'storeOrUpdate'])->name('visi_misi.storeOrUpdate');
        Route::post('/hapus', [VisiMisiController::class, 'hapus'])->name('visi_misi.hapus');
        Route::get('/edit/{id}', [VisiMisiController::class, 'edit'])->name('visi_misi.edit');
    });

    Route::prefix('berita')->group(function() {
        Route::get('/', [BeritaController::class, 'index'])->name('berita.index');
        Route::get('/table', [BeritaController::class, 'table'])->name('berita.table');
        Route::post('/storeOrUpdate', [BeritaController::class, 'storeOrUpdate'])->name('berita.storeOrUpdate');
        Route::post('/hapus', [BeritaController::class, 'hapus'])->name('berita.hapus');
        Route::get('/edit/{id}', [BeritaController::class, 'edit'])->name('berita.edit');
        Route::post('/ubah-status', [BeritaController::class, 'ubah_status'])->name('berita.ubah_status');
    });

    Route::prefix('kontak')->group(function() {
        Route::get('/', [KontakController::class, 'index'])->name('kontak.index');
        Route::get('/table', [KontakController::class, 'table'])->name('kontak.table');
        Route::post('/storeOrUpdate', [KontakController::class,'storeOrUpdate'])->name('kontak.storeOrUpdate');
        Route::get('/edit/{id}', [KontakController::class, 'edit'])->name('kontak.edit');
    });
});