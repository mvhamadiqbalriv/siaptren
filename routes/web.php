<?php

use App\Http\Controllers\Absensi\AbsensiAsatidzController;
use App\Http\Controllers\Absensi\AbsensiSantriController;
use App\Http\Controllers\Absensi\JadwalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Keuangan\PemasukanEksternalController;
use App\Http\Controllers\Keuangan\PembayaranGajiController;
use App\Http\Controllers\Keuangan\PembayaranSppController;
use App\Http\Controllers\Keuangan\PengeluaranLainnyaController;
use App\Http\Controllers\Laporan\LaporanAbsensiAsatidzController;
use App\Http\Controllers\Laporan\LaporanAbsensiSantriController;
use App\Http\Controllers\Laporan\LaporanDistribusiGajiController;
use App\Http\Controllers\Laporan\LaporanPemasukanEksternalController;
use App\Http\Controllers\Laporan\LaporanPembayaranSppController;
use App\Http\Controllers\Laporan\LaporanPengeluaranLainController;
use App\Http\Controllers\Master\AlumniController;
use App\Http\Controllers\Master\AsatidzController;
use App\Http\Controllers\Master\MataPelajaranController;
use App\Http\Controllers\Master\SantriController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\PendaftaranController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::name('pendaftaran')->group(function () {
    Route::get('/daftar', [PendaftaranController::class, 'index']);
    Route::post('/daftar', [PendaftaranController::class, 'daftar']);
});

Route::post('pendaftaran/download-formulir', [PendaftaranController::class, 'downloadByEmail']);
Route::get('pendaftaran/download-formulir/{id}', [PendaftaranController::class, 'download']);
Route::get('pendaftaran/success/{id}', [PendaftaranController::class, 'success']);

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile', [UserController::class, 'profile']);
    Route::get('/ganti-password', [UserController::class, 'password']);
    Route::put('/ganti-password', [UserController::class, 'password'])->name('ganti-password');

    // =========Master============
    Route::prefix('master')->group(function () {
        Route::resource('user', UserController::class);

        Route::prefix('civitas')->group(function () {
            Route::get('asatidz/upload/{id}', [AsatidzController::class, 'upload']);
            Route::post('asatidz/upload/{id}', [AsatidzController::class, 'upload'])->name('asatidz.upload');
            Route::resource('asatidz', AsatidzController::class)->except(['destroy']);

            Route::get('santri/upload/{id}', [SantriController::class, 'upload']);
            Route::post('santri/upload/{id}', [SantriController::class, 'upload'])->name('santri.upload');
            Route::get('santri/export', [SantriController::class, 'export'])->name('santri.export');
            Route::put('santri/verifikasi/{id}', [SantriController::class, 'verifikasi'])->name('santri.verifikasi');
            Route::resource('santri', SantriController::class)->except(['destroy', 'create']);

            Route::get('alumni/export', [AlumniController::class, 'export'])->name('alumni.export');
            Route::resource('alumni', AlumniController::class)->except(['destroy']);
        });

        Route::resource('mata-pelajaran', MataPelajaranController::class)->except(['show', 'destroy']);
    });

    // =========Absensi=============
    Route::prefix('absensi')->group(function () {
        Route::resource('jadwal', JadwalController::class)->except(['show', 'destroy']);

        Route::prefix('data')->group(function () {
            Route::resource('asatidz', AbsensiAsatidzController::class)->names([
                'index' => 'absensi-asatidz.index',
                'store' => 'absensi-asatidz.store',
                'create' => 'absensi-asatidz.create',
                'update' => 'absensi-asatidz.update',
                'edit' => 'absensi-asatidz.edit',
            ])->except(['show', 'destroy']);

            Route::get('santri/jadwal/{tanggal}', [AbsensiSantriController::class, 'jadwal']);
            Route::get('santri/list/{kode_jadwal}/tanggal/{tanggal}', [AbsensiSantriController::class, 'list']);
            Route::resource('santri', AbsensiSantriController::class)->names([
                'index' => 'absensi-santri.index',
                'store' => 'absensi-santri.store',
                'create' => 'absensi-santri.create',
                'update' => 'absensi-santri.update',
                'edit' => 'absensi-santri.edit',
            ])->except(['show', 'destroy']);
        });
    });

    // ========== Keuangan =============
    Route::prefix('keuangan')->group(function () {
        Route::prefix('pemasukan')->group(function () {
            Route::get('pembayaran-spp/tunggakan/{santri}', [PembayaranSppController::class, 'tunggakan']);
            Route::get('pembayaran-spp/santri', [PembayaranSppController::class, 'santri']);
            Route::resource('pembayaran-spp', PembayaranSppController::class);

            Route::put('eksternal/batal/{id}', [PemasukanEksternalController::class, 'batal']);
            Route::resource('eksternal', PemasukanEksternalController::class)->except(['edit', 'update', 'destroy']);
        });

        Route::prefix('pengeluaran')->group(function () {
            Route::get('pembayaran-gaji/download/{periode}', [PembayaranGajiController::class, 'download'])->name('pembayaran-gaji.download');
            Route::resource('pembayaran-gaji', PembayaranGajiController::class);

            Route::put('lainnya/batal/{id}', [PengeluaranLainnyaController::class, 'batal']);
            Route::resource('lainnya', PengeluaranLainnyaController::class)->except(['edit', 'update', 'destroy']);
        });
    });

    // ========= Laporan ==============
    Route::prefix('laporan')->group(function () {
        Route::prefix('absensi')->group(function () {

            Route::get('santri/cetak', [LaporanAbsensiSantriController::class, 'cetak'])->name('absensi-santri.cetak');
            Route::get('santri/get-mapel/{tanggal}', [LaporanAbsensiSantriController::class, 'getMapel']);
            Route::get('santri/get-guru/{mapel}', [LaporanAbsensiSantriController::class, 'getGuru']);
            Route::get('santri', [LaporanAbsensiSantriController::class, 'index']);

            Route::get('asatidz/cetak', [LaporanAbsensiAsatidzController::class, 'cetak'])->name('absensi-asatidz.cetak');
            Route::get('asatidz', [LaporanAbsensiAsatidzController::class, 'index']);
        });

        Route::prefix('keuangan')->group(function () {
            Route::get('pemasukan-eksternal/cetak', [LaporanPemasukanEksternalController::class, 'cetak'])->name('pemasukan-eksternal.cetak');
            Route::get('pemasukan-eksternal', [LaporanPemasukanEksternalController::class, 'index']);

            Route::get('pengeluaran-lain/cetak', [LaporanPengeluaranLainController::class, 'cetak'])->name('pengeluaran-lain.cetak');
            Route::get('pengeluaran-lain', [LaporanPengeluaranLainController::class, 'index']);

            Route::get('gaji-asatidz/cetak', [LaporanDistribusiGajiController::class, 'cetak'])->name('laporan-gaji.cetak');
            Route::get('gaji-asatidz', [LaporanDistribusiGajiController::class, 'index']);

            Route::get('pembayaran-spp/cetak', [LaporanPembayaranSppController::class, 'cetak'])->name('laporan-spp.cetak');
            Route::get('pembayaran-spp', [LaporanPembayaranSppController::class, 'index']);
        });
    });
});
