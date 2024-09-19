<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Info_irs;
use App\Models\Info_pkl;
use App\Models\Info_khs;
use App\Models\Info_skripsi;
use App\Models\Operator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class OperatorController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

// --------------- ENTRY AKUN BARU ---------------
    // Fungsi untuk menampilkan value angkatan dan dosen wali
    public function entryNew() {
        $currTahun = Carbon::now()->year;
        $dataTahun = range($currTahun - 7, $currTahun + 7);
        $dataTahun = array_unique($dataTahun);
        $dataDosen = Dosen::all();
        $email = session('email');
        $dataOperator = Operator::select('o.nama', 'a.role')
        ->from('operators as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        return view('entry-mahasiswa', ['dataDosen'=> $dataDosen, 'dataTahun'=> $dataTahun,'data' => $dataOperator]);
    }

    // Fungsi untuk konfirmasi entry akun baru
    public function updateAdd( Request $request) {
        $nama = $request->input('nama_lengkap');
        $nim = $request->input('nim');
        $angkatan = $request->input('angkatan');
        $dosen = $request->input('dosen-wali');
        // $password = $request->input('password');
        $valEmail = Mahasiswa::where('nim','=', $nim)->first();
        $valnama = Mahasiswa::where('nama','=', $nama)->first();
        $password = '123';

        if(!$valEmail && !$valnama ) {
            // try {
            //     $request->validate([
            //         'nama_lengkap' => 'required|regex:/^[\pL\s]+$/u',
            //         'nim' => 'required|numeric|unique:mahasiswas,nim',
            //         'angkatan'=> 'required',
            //         'dosen'=> 'required',
            //         'email'=> 'required|email|unique:mahasiswas,email',
            //         'password'=> 'required',
            //     ]);
            // } catch (ValidationException $e) {
            //     return redirect('/')
            //         ->withErrors($e->validator)
            //         ->withInput();
            // }
            Mahasiswa::create([
                'nama' => $nama,
                'nim'=> $nim,
                'angkatan'=> $angkatan,
                'kode_doswal' => $dosen,
                'password' => $password, 
            ]);
            Account::create([
                'nim_nip'=> $nim,
                'password'=> $password,
            ]);
            return redirect('/entry');
        }else{
            return redirect('/entry')->with(['error_mhs'=>'mahasiswa sudah terdaftar']);
        }
    }
    function confirmEditMhs(Request $request) {
        DB::table('mahasiswas')
        ->where('nim','=',$request->nim)
        ->update([
            'angkatan'=> $request->angkatan,
            'kode_doswal'=> $request->dosen_wali,
            'status'=> $request->status,
        ]);
        Session::flash('flash_edit', 'Edit Berhasil');
        Session::flash('flash_duration', 5); 
        return redirect('/data/mhs');
    }
    function delete_mhs_operator($nim) {
        DB::table('mahasiswas')
        ->where('nim','=',$nim)
        ->delete();
        DB::table('accounts')
        ->where('nim_nip','=',$nim)
        ->delete();

        Session::flash('flash_delete', 'Delete Berhasil');
        Session::flash('flash_duration', 5); 
        return redirect('/data/mhs');
    }
    function search_mhs_operator(Request $request){
        $nama_nim = $request->mhs;
        // $smt = $request->semester;

        $mahasiswa = Mahasiswa::select('m.*','s.status as status_mhs')
        ->from('mahasiswas as m')
        ->join('stat_mahasiswa as s','s.kode_status','=','m.status')
        ->where('m.nim','LIKE','%'.$nama_nim.'%')
        ->get();

        if($mahasiswa->count() == 0 ){
            $mahasiswa = Mahasiswa::select('m.*','s.status as status_mhs')
            ->from('mahasiswas as m')
            ->join('stat_mahasiswa as s','s.kode_status','=','m.status')
            ->where('m.nama','LIKE','%'.$nama_nim.'%')
            ->get();
        }
        return view('data_mhs_operator',['mhs' => $mahasiswa]);
    }
}
?>