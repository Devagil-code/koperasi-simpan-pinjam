<?php

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


Auth::routes();
Route::get('/', function () {
    return redirect()->route('login');
});
Route::group(['middleware' => 'web'], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::get('laporan-simpanan', 'LaporanController@simpanan')->name('laporan.simpanan');
        Route::get('laporan-pinjaman', 'LaporanController@pinjaman')->name('laporan.pinjaman');
        Route::get('laporan-simpanan-all', 'LaporanAllController@simpananAll')->name('laporan.simpanan-all');
        Route::post('laporan-simpanan-validation', 'LaporanAllController@validationSimpanan')->name('laporan-simpanan-all.validation');
        Route::post('laporan-simpanan-export', 'LaporanAllController@exportSimpanan')->name('laporan-simpanan-all.export');
        Route::get('laporan-pinjaman-all', 'LaporanAllController@pinjamanAll')->name('laporan.pinjaman-all');
        Route::post('laporan-pinjaman-validation', 'LaporanAllController@validationPinjaman')->name('laporan-pinjaman-all.validation');
        Route::post('laporan-pinjaman-export', 'LaporanAllController@exportPinjaman')->name('laporan-pinjaman-all.export');
        Route::get('/user/{user}/profile-user/', 'UserController@editPasswordMember')->name('user.user-profile');
        Route::put('/user/profile/{user}', 'UserController@putEditPassword')->name('user.edit-password');
        Route::get('/home', 'HomeController@index')->name('home');
        Route::resource('anggota', 'AnggotaController');
        Route::get('/anggota-export', 'AnggotaController@export')->name('anggota.export');
        Route::resource('divisi', 'DivisiController');
        Route::resource('transaksi-harian', 'TransaksiHarianController');
        Route::resource('periode', 'PeriodeController');
        Route::resource('role', 'RoleController');
        Route::resource('module', 'ModuleController');
        Route::get('copy-saldo-copy/{copy_saldo}', 'CopySaldoController@copySaldo')->name('copy-saldo.copy');
        Route::resource('copy-saldo', 'CopySaldoController');
        Route::post('detach-permission/{role_id}', 'PermissionController@detachPermission')->name('permission.detach');
        Route::post('attach-permission/{role_id}', 'PermissionController@attachPermission')->name('permission.attach');
        Route::resource('permission', 'PermissionController');
        Route::get('laporan-kas-bank', 'LaporanController@cashBank')->name('laporan.cash-bank');
        Route::get('laporan-perdivisi', 'LaporanController@perDivisi')->name('laporan.per-divisi');
        Route::get('transaksi-harian.chek-anggota', 'TransaksiHarianController@cekAnggota')->name('transaksi-harian.chek-anggota');
        Route::resource('user', 'UserController');
        Route::resource('option', 'OptionController');
        Route::post('company-options', 'OptionController@saveCompany')->name('company.option');
        Route::post('email-options', 'OptionController@saveEmail')->name('email.option');
        Route::post('sosmed', 'OptionController@saveSosmed')->name('social-media');
        Route::resource('transaksi-simpanan', 'TransaksiSimpananController');
        Route::resource('transaksi-pinjaman', 'TransaksiPinjamanController');
        Route::resource('transaksi-divisi', 'TransaksiDivisiController');
        Route::get('/simpanan-debet/upload', 'SimpananDebetController@upload')->name('simpanan-debet.upload');
        Route::post('/simpanan-debet/doupload', 'SimpananDebetController@doUpload')->name('simpanan-debet.doupload');
        Route::get('/simpanan-kredit/upload', 'SimpananKreditController@upload')->name('simpanan-kredit.upload');
        Route::post('/simpanan-kredit/doupload', 'SimpananKreditController@doUpload')->name('simpanan-kredit.doupload');
        Route::get('/pinjaman-kredit/upload', 'PinjamanKreditController@upload')->name('pinjaman-kredit.upload');
        Route::post('/pinjaman-kredit/doupload', 'PinjamanKreditController@doUpload')->name('pinjaman-kredit.doupload');
        Route::get('/pinjaman-debet/upload', 'PinjamanDebetController@upload')->name('pinjaman-debet.upload');
        Route::post('/pinjaman-debet/doupload', 'PinjamanDebetController@doUpload')->name('pinjaman-debet.doupload');
        Route::get('/simpanan-debet/close-book', 'SimpananDebetController@closeBook')->name('simpanan-debet.close-book');
        Route::get('/simpanan-kredit/close-book', 'SimpananKreditController@closeBook')->name('simpanan-kredit.close-book');
        Route::get('/pinjaman-debet/close-book', 'PinjamanDebetController@closeBook')->name('pinjaman-debet.close-book');
        Route::get('/pinjaman-kredit/close-book', 'PinjamanKreditController@closeBook')->name('pinjaman-kredit.close-book');
        Route::get('/divisi-debet/close-book', 'DivisiDebetController@closeBook')->name('divisi-debet.close-book');
        Route::get('/divisi-kredit/close-book', 'DivisiKreditController@closeBook')->name('divisi-kredit.close-book');

        Route::resource('simpanan-debet', 'SimpananDebetController');
        Route::resource('simpanan-kredit', 'SimpananKreditController');
        Route::resource('pinjaman-debet', 'PinjamanDebetController');
        Route::resource('pinjaman-kredit', 'PinjamanKreditController');
        Route::resource('divisi-debet', 'DivisiDebetController');
        Route::resource('divisi-kredit', 'DivisiKreditController');
        Route::get('/check-biaya-debet/{divisi}', 'BiayaController@checkBiayaDebet')->name('check-biaya-debet.get');
        Route::get('/check-biaya-kredit/{divisi}', 'BiayaController@checkBiayaKredit')->name('check-biaya-kredit.get');
        Route::resource('biaya', 'BiayaController');
        Route::get('/user/reset-password/{user}', 'UserController@resetPassword')->name('user.reset-password');
        Route::put('/user/reset-pass/{user}', 'UserController@putResetPass')->name('user.reset-pass');
        Route::resource('/user-anggota', 'UserAnggotaController');
        Route::post('/periode-close-book/{periode}', 'PeriodeController@closeBook')->name('periode.close-book');
        Route::post('/simpanan-anggota/cari', 'LaporanController@cariSimpanan')->name('simpanan-anggota.cari');
        Route::post('/simpanan-anggota/excel', 'LaporanController@simpananExcel')->name('simpanan-anggota.excel');
        Route::post('/pinjaman-anggota/cari', 'LaporanController@cariPinjaman')->name('pinjaman-anggota.cari');
        Route::post('/pinjaman-anggota/excel', 'LaporanController@pinjamanExcel')->name('pinjaman-anggota.excel');
    });
});
