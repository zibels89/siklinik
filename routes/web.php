<?php

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

Route::get(
  '/',
  function () {
    return view('welcome');
  }
);

//Main
Route::get('/', 'MainController@index')->name('dashboard')->middleware('auth');

//Profile
Auth::routes([
  'register' => true,
  'verify' => false,
  'reset' => false
]);

Route::group(['prefix' => 'users'], function () {
  Route::auth();
});

Route::get('users/profile', 'ProfileController@index')->name('profile.edit')->middleware('auth');

Route::get('users/profile/{id}', 'ProfileController@edit')->name('profile.edit.admin')->middleware('auth', 'admin');

Route::patch('users/profile/simpan', 'ProfileController@simpan')->name('profile.simpan')->middleware('auth');
//endProfile

//Pasien
Route::get('/pasien', 'PasienController@index')->name('pasien')->middleware('auth');

Route::get('/pasien/tambah/', 'PasienController@tambah_pasien')->name('pasien.tambah')->middleware('auth');

Route::post('/pasien/tambah/simpan', 'PasienController@simpan_pasien')->name('pasien.simpan')->middleware('auth');

Route::post('/pasien/edit/update/', 'PasienController@update_pasien')->middleware('auth');

Route::delete('/pasien/hapus/{id}', 'PasienController@hapus_pasien')->name('pasien.destroy')->middleware('auth');

Route::get('/pasien/edit/{id}', 'PasienController@edit_pasien')->name('pasien.edit')->middleware('auth');
//End Pasien

//Obat

Route::get('/obat', 'ObatController@index')->name('obat')->middleware('auth');

Route::get('/obat/cetak_pdf', 'ObatController@cetak_pdf')->name('obat.cetak_pdf')->middleware('auth');

Route::delete('/obat/hapus/{id}', 'ObatController@hapus_obat')->name('obat.destroy')->middleware('auth', 'staff');

Route::get('/obat/edit/{id}', 'ObatController@edit_obat')->name('obat.edit')->middleware('auth', 'staff');

Route::get('/obat/tambah/', 'ObatController@tambah_obat')->name('obat.tambah')->middleware('auth', 'staff');

Route::get('/obat/tambah/stock', 'ObatController@tambah_obat_stock')->name('obat.tambah_stock')->middleware('auth', 'staff');

Route::post('/obat/tambah/simpan', 'ObatController@simpan_obat')->name('obat.simpan')->middleware('auth', 'staff');

Route::post('/obat/edit/tambah_stock', 'ObatController@tambah_stock_update')->name('tambah_stock.update')->middleware('auth', 'staff');

Route::post('/obat/edit/update/', 'ObatController@update_obat')->name('obat.update')->middleware('auth', 'staff');

Route::post('/obat/import_excel', 'ObatController@import_excel')->name('obat.import_excel')->middleware('auth', 'staff');
//End Obat


//rm

Route::get('/rm', 'RMController@index')->name('rm')->middleware('auth');

Route::delete('/rm/hapus/{id}', 'RMController@hapus_rm')->name('rm.destroy')->middleware('auth');

Route::get('/rm/edit/{id}', 'RMController@edit_rm')->name('rm.edit')->middleware('auth');

Route::get('/rm/tambah', 'RMController@tambah_rm')->name('rm.tambah')->middleware('auth');

Route::get('/rm/tambah/{idpasien}', 'RMController@tambah_rmid')->name('rm.tambah.id')->middleware('auth');

Route::post('/rm/simpan/', 'RMController@simpan_rm')->name('rm.simpan')->middleware('auth');

Route::post('/rm/update/', 'RMController@update_rm')->name('rm.update')->middleware('auth');

Route::get('/rm/list/{idpasien}', 'RMController@list_rm')->name('rm.list')->middleware('auth');

Route::get('/rm/lihat/{id}', 'RMController@lihat_rm')->name('rm.lihat')->middleware('auth');
//End rm

//Tagihan
Route::get('/tagihan/{id}', 'RMController@tagihan')->name('tagihan')->middleware('auth');
//Endtagihan

//Pengaturan
Route::get('/pengaturan', 'PengaturanController@index')->name('pengaturan')->middleware('auth', 'admin');

Route::patch('/pengaturan/simpan', 'PengaturanController@simpan')->name('pengaturan.simpan')->middleware('auth', 'admin');
//EndPengaturan



//Users
Route::get('/users', 'UserController@index')->name('user')->middleware('auth', 'admin');

Route::delete('/users/delete/{id}', 'UserController@hapus')->name('user.destroy')->middleware('auth', 'admin');


//endUsers
