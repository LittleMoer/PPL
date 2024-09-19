<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\DepartementController;
use App\Models\Departement;
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

// ---------- SIGN IN ----------
Route::get('/', function () {return view('login');});

Route::post('/confirmLog', [AccountController::class,'confirmLog'])->name('confirmLog');
Route::get('/dashboard/dosen', [AccountController::class,'halaman_dashboard_dosen'])->name('halaman_dashboard_dosen');


// ---------- MAHASISWA ----------
Route::post('/confirmDataAwal', [MahasiswaController::class,'confirmDataAwal'])->name('confirmDataAwal');
Route::get('/profile/mhs', [AccountController::class,'halaman_profile_mhs'])->name('halaman_profile_mhs');

Route::get('/irs', [AccountController::class,'halaman_irs'])->name('halaman_irs');
Route::post('/input_irs', [MahasiswaController::class,'input_irs'])->name('input_irs');

Route::get('/khs', [AccountController::class,'halaman_khs'])->name('halaman_khs');
Route::post('/input_pkl', [MahasiswaController::class,'input_pkl'])->name('input_pkl');

Route::get('/pkl', [AccountController::class,'halaman_pkl'])->name('halaman_pkl');
Route::post('/input_khs', [MahasiswaController::class,'input_khs'])->name('input_khs');

Route::get('/skripsi', [AccountController::class,'halaman_skripsi'])->name('halaman_skripsi');
Route::post('/input_skripsi', [MahasiswaController::class,'input_skripsi'])->name('input_skripsi');
Route::get('/smt/{smt}', [MahasiswaController::class,'smt_mhs'])->name('smt_mhs');



// --------- OPERATOR ----------
Route::get('/entry', [OperatorController::class,'entryNew'])->name('entry');
Route::get('/profile/operator', [AccountController::class,'halaman_profile_operator'])->name('halaman_profile_operator');
Route::get('/data/mhs', [AccountController::class,'halaman_mhs_operator'])->name('halaman_mhs_operator');
Route::post('/search/mhs', [OperatorController::class,'search_mhs_operator'])->name('search_mhs_operator');
Route::get('/edit/mhs/{nim}', [AccountController::class,'edit_mhs_operator'])->name('edit_mhs_operator');
Route::get('/delete_mahasiswa/{nim}', [OperatorController::class,'delete_mhs_operator'])->name('delete_mhs_operator');
Route::post('/confirmEditMhs', [OperatorController::class,'confirmEditMhs'])->name('confirmEditMhs');

Route::get('/updateAdd', [OperatorController::class,'updateAdd'])->name('updateAdd');

// --------- DOSEN -----------
Route::get('/profile/dosen', [AccountController::class,'halaman_profile_dosen'])->name('halaman_profile_dosen');

Route::get('/dosen_irs', [AccountController::class,'halaman_dosen_irs'])->name('halaman_dosen_irs');
Route::get('/dosen_khs', [AccountController::class,'halaman_dosen_khs'])->name('halaman_dosen_khs');
Route::get('/dosen_pkl', [AccountController::class,'halaman_dosen_pkl'])->name('halaman_dosen_pkl');
Route::get('/dosen_skripsi', [AccountController::class,'halaman_dosen_skripsi'])->name('halaman_dosen_skripsi');
// pencarian mahasiswa
// Route::get('/info_mhs', [AccountController::class,'halaman_info_mhs'])->name('halaman_info_mhs');
Route::get('/detail_mhs_dosen/{mhs}', [DosenController::class,'detail_mhs_dosen'])->name('detail_mhs_dosen');
Route::get('/submit_info_mhs', [DosenController::class,'submit_info_mhs'])->name('submit_info_mhs');

// ----------- BUTTON -----------
Route::get('/setujui_irs/{nim}/{smt}', [DosenController::class,'setujui_irs'])->name('setujui_irs');
Route::get('/setujui_khs/{nim}/{smt}/{ip_smt}', [DosenController::class,'setujui_khs'])->name('setujui_khs');
Route::get('/setujui_pkl/{nim}', [DosenController::class,'setujui_pkl'])->name('setujui_pkl');
Route::get('/setujui_skripsi/{nim}', [DosenController::class,'setujui_skripsi'])->name('setujui_skripsi');

Route::get('/edit_irs/{nim}/{smt}', [DosenController::class,'edit_validasi_irs'])->name('edit_validasi_irs');
Route::get('/edit_khs/{nim}/{smt}/{ip_smt}', [DosenController::class,'edit_validasi_khs'])->name('edit_validasi_khs');
Route::get('/edit_pkl/{nim}', [DosenController::class,'edit_validasi_pkl'])->name('edit_validasi_pkl');
Route::get('/edit_skripsi/{nim}', [DosenController::class,'edit_validasi_skripsi'])->name('edit_validasi_skripsi');

Route::post('/confirmEditIRS', [DosenController::class,'confirmEditIRS'])->name('confirmEditIRS');
Route::post('/confirmEditKHS', [DosenController::class,'confirmEditKHS'])->name('confirmEditKHS');
Route::post('/confirmEditPKL', [DosenController::class,'confirmEditPKL'])->name('confirmEditPKL');
Route::post('/confirmEditSKRIPSI', [DosenController::class,'confirmEditSKRIPSI'])->name('confirmEditSKRIPSI');

// button memilih verified atau tidak
Route::get('/unverif_irs', [DosenController::class,'unverif_irs'])->name('Unverif');
Route::get('/verif_irs', [DosenController::class,'verif_irs'])->name('verif');
Route::get('/unverif_khs', [DosenController::class,'unverif_khs'])->name('Unverif');
Route::get('/verif_khs', [DosenController::class,'verif_khs'])->name('verif');
Route::get('/unverif_pkl', [DosenController::class,'unverif_pkl'])->name('Unverif');
Route::get('/verif_pkl', [DosenController::class,'verif_pkl'])->name('verif');
Route::get('/unverif_skripsi', [DosenController::class,'unverif_skripsi'])->name('Unverif');
Route::get('/verif_skripsi', [DosenController::class,'verif_skripsi'])->name('verif');

//  DELETE
Route::get('/delete_irs/{nim}/{smt}', [DosenController::class,'delete_irs'])->name('delete_irs');
Route::get('/delete_khs/{nim}/{smt}', [DosenController::class,'delete_khs'])->name('delete_khs');
Route::get('/delete_pkl/{nim}/{smt}', [DosenController::class,'delete_pkl'])->name('delete_pkl');
Route::get('/delete_skripsi/{nim}', [DosenController::class,'delete_skripsi'])->name('delete_skripsi');

// SEMESTER DI INFO MAHASISWA (DOSEN)
Route::get('/smt_1', [DosenController::class,'smt_1']);
Route::get('/smt_2', [DosenController::class,'smt_2']);
Route::get('/smt_3', [DosenController::class,'smt_3']);
Route::get('/smt_4', [DosenController::class,'smt_4']);
Route::get('/smt_5', [DosenController::class,'smt_5']);
Route::get('/smt_6', [DosenController::class,'smt_6']);
Route::get('/smt_7', [DosenController::class,'smt_7']);
Route::get('/smt_8', [DosenController::class,'smt_8']);
Route::get('/smt_9', [DosenController::class,'smt_9']);
Route::get('/smt_10', [DosenController::class,'smt_10']);
Route::get('/smt_11', [DosenController::class,'smt_11']);
Route::get('/smt_12', [DosenController::class,'smt_12']);
Route::get('/smt_13', [DosenController::class,'smt_13']);
Route::get('/smt_14', [DosenController::class,'smt_14']);
// delete pop up
Route::get('/close', [DosenController::class,'close']);

// ==== DEPARTEMENT ====
Route::get('/profile/departement', [AccountController::class,'halaman_profile_departement'])->name('halaman_profile_departement');
Route::get('/data/mahasiswa', [DepartementController::class,'data_mhs']);
Route::get('/rekap/pkl&skripsi', [DepartementController::class,'rekap_pkl']);
Route::get('/lulus/pkl/{angkatan}', [DepartementController::class,'data_lulus_pkl'])->name('lulus_pkl');
Route::get('/belum/pkl/{angkatan}', [DepartementController::class,'data_belum_lulus_pkl'])->name('belum_pkl');
Route::get('/lulus/skripsi/{angkatan}', [DepartementController::class,'data_lulus_skripsi'])->name('lulus_skripsi');
Route::get('/belum/skripsi/{angkatan}', [DepartementController::class,'data_belum_lulus_skripsi'])->name('belum_skripsi');
Route::get('/statistik/mhs', [DepartementController::class,'statistik_mahasiswa'])->name('statistik_mahasiswa');
Route::get('/stat/{status}', [DepartementController::class,'detail_status'])->name('stat');
Route::get('/detail/angkatan', [DepartementController::class,'stat_angkatan'])->name('stat_angkatan');

Route::post('/upload_batch_mhs', [DepartementController::class,'upload_batch_mhs'])->name('upload_batch_mhs');