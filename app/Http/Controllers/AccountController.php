<?php
namespace App\Http\Controllers;

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
use App\Models\Prov;
use App\Models\KabKot;
use App\Models\Departement;

class AccountController extends Controller{
    function confirmLog(Request $request){
        $email = $request->email;
        $password = $request->password;

        $akun = Account::select('role')
        ->from('accounts')
        ->where('email','=', $email)
        ->where('password','=', $password)
        ->first();
        //  untuk ketika mahasiswa belum mempunyai email
        $akun1 = Account::select('role')
        ->from('accounts')
        ->where('nim_nip','=', $email)
        ->where('password','=', $password)
        ->first();

        $validasi_akun = Account::select('*')
        ->where('email','=', $email)
        ->where('password','=', $password)
        ->first();

        //  untuk mahasiswa yang belum ada email
        $validasi_akun1 = Account::select('*')
        ->where('nim_nip','=', $email)
        ->where('password','=', $password)
        ->first();

        // JIKA SUDAH MEMPUNYAI EMAIL TAPI MEMASUKKAN INPUT DENGAN NIM
        // if($validasi_akun1){
        //     $cek_akun2 = Account::select('email')
        //     ->where('nim_nip','=', $email)
        //     ->first();

        //     if($cek_akun2->email != null){
        //         return redirect('/')->with('error_akun','Masukkan Email');
        //     }
        // }
        if($validasi_akun){
            if($akun->role =='mahasiswa'){
                $cek_akun = Mahasiswa::select('alamat','kab_kota','provinsi','jalur_masuk','no_hp')
                    ->from('mahasiswas')
                    ->where('email','=',$email)
                    ->where('alamat','=',null)
                    ->where('kab_kota','=',null)
                    ->where('provinsi','=',null)
                    ->where('jalur_masuk','=',null)
                    ->where('no_hp','=',null)
                    ->first();
                $cek_akun_verified = Mahasiswa::select('alamat','kab_kota','provinsi','jalur_masuk','no_hp')
                    ->from('mahasiswas')
                    ->where('email','=',$email)
                    ->where('alamat','!=',null)
                    ->where('kab_kota','!=',null)
                    ->where('provinsi','!=',null)
                    ->where('jalur_masuk','!=',null)
                    ->where('no_hp','!=',null)
                    ->where('status','=',1)
                    ->first();
                $mhs1 = Mahasiswa::select('m.*','a.role','s.status as cek_status','a.password')
                    ->from('mahasiswas as m')
                    ->join('accounts as a','m.email','=','a.email')
                    ->join('stat_mahasiswa as s','s.kode_status','=','m.status')
                    ->where('a.email','=',$email)
                    ->first();
                
                $prov = Prov::all();
                $kabkot = KabKot::all();
                if($cek_akun){
                    session(['email' => $email]);
                    session(['nim' => $mhs1->nim]);
                    return view('update-mahasiswa',['mhs' => $mhs1, 'prov' => $prov, 'kabkot' => $kabkot, 'error_email' => '']);
                }else{
                    if($cek_akun_verified){
                        session(['email' => $email]);
                        session(['nim' => $mhs1->nim]);
                        
                        return redirect('/profile/mhs');
                    }else{
                        session(['email' => $email]);
                        session(['nim' => $mhs1->nim]);

                        return view('update-mahasiswa',['mhs' => $mhs1, 'prov' => $prov, 'kabkot' => $kabkot, 'error_email' => '']);
                    }
                }
            }
            elseif($akun->role =='operator'){
                $dataOperator = Operator::select('o.nama', 'a.role')
                ->from('operators as o')
                ->join('accounts as a','a.email','=','o.email')
                ->where('o.email','=',$email)
                ->first();

                session(['email' => $email]);
                return redirect('/profile/operator');
            }elseif($akun->role == 'dosen'){
                $datadosen = dosen::select('o.*', 'a.role')
                ->from('dosens as o')
                ->join('accounts as a','a.email','=','o.email')
                ->where('o.email','=',$email)
                ->first();

                session(['email' => $email]);
                return redirect('/dashboard/dosen');
            }elseif($akun->role == 'departement'){
                $datadept = Departement::select('d.*', 'a.role')
                ->from('departements as d')
                ->join('accounts as a','a.email','=','d.email')
                ->where('d.email','=',$email)
                ->first();
                session(['email' => $email]);
                return redirect('/profile/departement');
            }
        }else{
            if(!$validasi_akun && $validasi_akun1){
                if($akun1->role =='mahasiswa'){
                    $cek_akun = Mahasiswa::select('nim','alamat','kab_kota','provinsi','jalur_masuk','no_hp')
                        ->from('mahasiswas')
                        ->where('nim','=',$email)
                        ->where('alamat','=',null)
                        ->where('kab_kota','=',null)
                        ->where('provinsi','=',null)
                        ->where('jalur_masuk','=',null)
                        ->where('no_hp','=',null)
                        ->first();
                    $cek_akun_verified = Mahasiswa::select('nim','alamat','kab_kota','provinsi','jalur_masuk','no_hp')
                        ->from('mahasiswas')
                        ->where('nim','=',$email)
                        ->where('alamat','!=',null)
                        ->where('kab_kota','!=',null)
                        ->where('provinsi','!=',null)
                        ->where('jalur_masuk','!=',null)
                        ->where('no_hp','!=',null)
                        ->where('status','=',1)

                        ->first();
                    $mhs1 = Mahasiswa::select('m.*','a.role','s.status as cek_status','a.password')
                        ->from('mahasiswas as m')
                        ->join('accounts as a','m.nim','=','a.nim_nip')
                        ->join('stat_mahasiswa as s','s.kode_status','=','m.status')
                        ->where('a.nim_nip','=',$email)
                        ->first();
                    
                    $prov = Prov::all();
                    $kabkot = KabKot::all();
                    if($cek_akun){
                        session(['nim' => $email]);
                        return view('update-mahasiswa',['mhs' => $mhs1, 'prov' => $prov, 'kabkot' => $kabkot, 'error_email' => '']);
                    }else{
                        if($cek_akun_verified){
                            $get_email = Account::select('email')
                            ->where('nim_nip','=',$email)
                            ->first();

                            session(['email' => $get_email->email]);
                            session(['nim' => $email]);
                            return redirect('/profile/mhs');
                        }else{
                            session(['nim' => $email]);
                            return view('update-mahasiswa',['mhs' => $mhs1, 'prov' => $prov, 'kabkot' => $kabkot, 'error_email' => '']);
                        }
                    }
                }elseif($akun1->role =='operator'){
                    $dataOperator = Operator::select('o.*', 'a.role')
                    ->from('operators as o')
                    ->join('accounts as a','a.email','=','o.email')
                    ->where('o.nip','=',$email)
                    ->first();

                    session(['email' => $dataOperator->email]);
                    return redirect('/profile/operator');
                }elseif($akun1->role == 'dosen'){
                    $datadosen = dosen::select('o.*', 'a.role')
                    ->from('dosens as o')
                    ->join('accounts as a','a.email','=','o.email')
                    ->where('o.nip','=',$email)
                    ->first();
    
                    session(['email' => $datadosen->email]);
                    return redirect('/dashboard/dosen');
                }elseif($akun1->role == 'departement'){
                    $datadept = Departement::select('d.*', 'a.role')
                        ->from('departements as d')
                        ->join('accounts as a','a.email','=','d.email')
                        ->where('d.nip','=',$email)
                        ->first();
                        session(['email' => $datadept->email]);
                    return redirect('/profile/departement');
                }
            }else{
                if(!$validasi_akun && !$validasi_akun1){
                    return redirect('/')->with('error_akun','Data yang anda masukkan salah');
                }
            }
        }
    }

    function halaman_dashboard_dosen(){
        $email = session('email');
        $mhs = dosen::select('m.*')
        ->from('dosens as d')
        ->join('mahasiswas as m','m.kode_doswal','=','d.nip')
        ->where('d.email','=',$email)
        ->get();
        
        $datadosen = dosen::select('o.*', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();

        $cek_mhs = Mahasiswa::select('nim')
        ->where('kode_doswal','=',$datadosen->nip)
        ->get();

        $nimMahasiswa = $cek_mhs->pluck('nim')->toArray();
        

        $cek_jml_mhs = Mahasiswa::where('kode_doswal','=',$datadosen->nip)->count();

        $cek_jml_pkl = Info_pkl::select('nim')
        ->from('info_pkls')
        ->whereIn('nim',$nimMahasiswa)
        ->where('stat_cek','=',1)
        ->count();

        $cek_jml_skripsi = Info_skripsi::select('nim')
        ->from('info_skripsis')
        ->whereIn('nim',$nimMahasiswa)
        ->where('stat_cek','=',1)
        ->count();


        return view('dashboard_dosen', ['data'=> $datadosen,'mhs'=>$mhs,'jml_pkl'=>$cek_jml_pkl,'jml_skripsi'=>$cek_jml_skripsi,'jml_mhs'=>$cek_jml_mhs]);
    }
    function halaman_irs(){
        $email = session('email');
        $mhs1 = Mahasiswa::select('m.nama','a.role')
        ->from('mahasiswas as m')
        ->join('accounts as a','m.email','=','a.email')
        ->where('a.email','=',$email)
        ->first();
        if(!$mhs1){
            $mhs1 = Mahasiswa::select('m.nama','a.role')
            ->from('mahasiswas as m')
            ->join('accounts as a','m.email','=','a.email')
            ->where('a.nim_nip','=',$email)
            ->first();
        }
        return view('informasi-irs',['mhs' => $mhs1]);
    }
    function halaman_khs(){
        $email = session('email');
        $mhs1 = Mahasiswa::select('m.nama','a.role')
        ->from('mahasiswas as m')
        ->join('accounts as a','m.email','=','a.email')
        ->where('a.email','=',$email)
        ->first();
        if(!$mhs1){
            $mhs1 = Mahasiswa::select('m.nama','a.role')
            ->from('mahasiswas as m')
            ->join('accounts as a','m.email','=','a.email')
            ->where('a.nim_nip','=',$email)
            ->first();
        }
        return view('informasi-khs',['mhs' => $mhs1]);
    }
    function halaman_pkl(){
        $email = session('email');
        $mhs1 = Mahasiswa::select('m.nama','a.role')
        ->from('mahasiswas as m')
        ->join('accounts as a','m.email','=','a.email')
        ->where('a.email','=',$email)
        ->first();
        if(!$mhs1){
            $mhs1 = Mahasiswa::select('m.nama','a.role')
            ->from('mahasiswas as m')
            ->join('accounts as a','m.email','=','a.email')
            ->where('a.nim_nip','=',$email)
            ->first();
        }
        return view('informasi-pkl',['mhs' => $mhs1]);
    }
    function halaman_skripsi(){
        $email = session('email');
        $mhs1 = Mahasiswa::select('m.nama','a.role')
        ->from('mahasiswas as m')
        ->join('accounts as a','m.email','=','a.email')
        ->where('a.email','=',$email)
        ->first();
        if(!$mhs1){
            $mhs1 = Mahasiswa::select('m.nama','a.role')
            ->from('mahasiswas as m')
            ->join('accounts as a','m.email','=','a.email')
            ->where('a.nim_nip','=',$email)
            ->first();
        }
        return view('informasi-skripsi',['mhs' => $mhs1]);
    }
    function halaman_dosen_irs(){
        $email = session('email');
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $dataDosen = Dosen::select("nip")
            ->where("email","=",$email)
            ->first();
        $irs = Info_irs::select("m.nama","m.nim", "i.smt", "i.sks", "i.scan_irs",'i.stat_cek')
            ->from("info_irs as i")
            ->join("mahasiswas as m", "m.nim","=","i.nim")
            ->where("m.kode_doswal","=",$dataDosen->nip)
            ->get();
        return view('penyetujuan_irs',['irs' => $irs,'data' => $datadosen1]);
    }
    function halaman_dosen_pkl(){
        $email = session('email');
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $dataDosen = Dosen::select("nip")
            ->where("email","=",$email)
            ->first();
        $pkl = Info_pkl::select("m.nama","m.nim","i.semester", "i.nilai_pkl","i.scan_pkl",'i.stat_cek')
            ->from("info_pkls as i")
            ->join("mahasiswas as m", "m.nim","=","i.nim")
            ->where("m.kode_doswal","=",$dataDosen->nip)
            ->get();
        // dd($pkl);
        return view('penyetujuan_pkl',['pkl' => $pkl,'data' => $datadosen1]);
    }
    function halaman_dosen_khs(){
        $email = session('email');
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $dataDosen = Dosen::select("nip")
            ->where("email","=",$email)
            ->first();
        $khs = Info_khs::select("m.nama","m.nim", "i.smt","i.ip_smt", "i.sks", "i.scan_khs",'i.stat_cek')
            ->from("info_khs as i")
            ->join("mahasiswas as m", "m.nim","=","i.nim")
            ->where("m.kode_doswal","=",$dataDosen->nip)
            ->get();
        // dd($irs);
        return view('penyetujuan_khs',['khs' => $khs,'data' => $datadosen1]);
    }
    function halaman_dosen_skripsi(){
        $email = session('email');
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $dataDosen = Dosen::select("nip")
            ->where("email","=",$email)
            ->first();
        $skripsi = Info_skripsi::select("m.nama","m.nim", "i.tgl_lulus", "i.lama_study", "i.scan_skripsi",'i.stat_cek','i.semester')
            ->from("info_skripsis as i")
            ->join("mahasiswas as m", "m.nim","=","i.nim")
            ->where("m.kode_doswal","=",$dataDosen->nip)
            ->get();
        // dd($skripsi);
        return view('penyetujuan_skripsi',['skripsi' => $skripsi,'data' => $datadosen1]);
    }
    
    function halaman_profile_dosen(){
        $email = session('email');
        $datadosen1 = dosen::select('o.*', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();

        $cek_mhs = Mahasiswa::select('nim')
        ->where('kode_doswal','=',$datadosen1->nip)
        ->get();

        $nimMahasiswa = $cek_mhs->pluck('nim')->toArray();
        

        $cek_jml_mhs = Mahasiswa::where('kode_doswal','=',$datadosen1->nip)->count();

        $cek_jml_pkl = Info_pkl::select('nim')
        ->from('info_pkls')
        ->whereIn('nim',$nimMahasiswa)
        ->where('stat_cek','=',1)
        ->count();

        $cek_jml_skripsi = Info_skripsi::select('nim')
        ->from('info_skripsis')
        ->whereIn('nim',$nimMahasiswa)
        ->where('stat_cek','=',1)
        ->count();

        return view('profile_dosen',['data' => $datadosen1,'jml_pkl'=>$cek_jml_pkl,'jml_skripsi'=>$cek_jml_skripsi,'jml_mhs'=>$cek_jml_mhs]);
    }
    function halaman_profile_mhs(){
        $email = session('email');
        $mhs = Mahasiswa::select('m.*','d.nama as dosen','k.kab_kot as kota','p.provinsi as prov','a.role')
        ->from('mahasiswas as m')
        ->join('dosens as d','d.nip','=','m.kode_doswal')
        ->join('kab_kots as k','k.id_kab_kot','=','m.kab_kota')
        ->join('provs as p','p.id_prov','=','m.provinsi')
        ->join('accounts as a','a.nim_nip','=','m.nim')
        ->where('m.email','=',$email)
        ->first();
        
        // dd($mhs->foto);
        $irs_smt1 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt1 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt1 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt1 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt2 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt2 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt2 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt2 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        
        $irs_smt3 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt3 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt3 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt3 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt4 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt4 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt4 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt4 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt5 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt5 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt5 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt5 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt6 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt6 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt6 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt6 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt7 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt7 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt7 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt7 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt8 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt8 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt8 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt8 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt9 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt9 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt9 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt9 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt10 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt10 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt10 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt10 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt11 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt11 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt11 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt11 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt12 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt12 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt12 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt12 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt13 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt13 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt13 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt13 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt14 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt14 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs->nim)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt14 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt14 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs->nim)
        ->where('semester','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();

                
        if($irs_smt1 && $khs_smt1){
            if($pkl_smt1 && !$skripsi_smt1){
                $stat_smt1 = 'hijau';
            }else{
                if($skripsi_smt1){
                    $stat_smt1 = 'kuning';
                }else{
                    if(!$pkl_smt1 && !$skripsi_smt1){
                        $stat_smt1 = 'biru';
                    }
                }
            }
        }else{
            if($irs_smt1 && !$khs_smt1 && !$pkl_smt1 && !$skripsi_smt1){
                $stat_smt1 = 'oren';
            }else{
                if($irs_smt1 && !$khs_smt1 && $pkl_smt1 && !$skripsi_smt1){
                        $stat_smt1 = 'oren';
                }else{
                    if($irs_smt1 && !$khs_smt1 && !$pkl_smt1 && $skripsi_smt1){
                        $stat_smt1 = 'oren';
                    }else{
                        if(!$irs_smt1 && !$khs_smt1 && !$pkl_smt1 && !$skripsi_smt1){
                            $stat_smt1 = 'merah';
                        }
                    }
                }
            }
        }
        
        if($irs_smt2 && $khs_smt2){
            if($pkl_smt2 && !$skripsi_smt2){
                $stat_smt2 = 'hijau';
            }else{
                if($skripsi_smt2){
                    $stat_smt2 = 'kuning';
                }else{
                    if(!$pkl_smt2 && !$skripsi_smt2){
                        $stat_smt2 = 'biru';
                    }
                }
            }
        }else{
            if($irs_smt2 && !$khs_smt2 && !$pkl_smt2 && !$skripsi_smt2){
                $stat_smt2 = 'oren';
            }else{
                if($irs_smt2 && !$khs_smt2 && $pkl_smt2 && !$skripsi_smt2){
                        $stat_smt2 = 'oren';
                }else{
                    if($irs_smt2 && !$khs_smt2 && !$pkl_smt2 && $skripsi_smt2){
                        $stat_smt2 = 'oren';
                    }else{
                        if(!$irs_smt2 && !$khs_smt2 && !$pkl_smt2 && !$skripsi_smt2){
                            $stat_smt2 = 'merah';
                        }
                    }
                }
            }
        }
        
        if($irs_smt3 && $khs_smt3){
            if($pkl_smt3 && !$skripsi_smt3){
                $stat_smt3 = 'hijau';
            }else{
                if($skripsi_smt3){
                    $stat_smt3 = 'kuning';
                }else{
                    if(!$pkl_smt3 && !$skripsi_smt3){
                        $stat_smt3 = 'biru';
                    }
                }
            }
        }else{
            if($irs_smt3 && !$khs_smt3 && !$pkl_smt3 && !$skripsi_smt3){
                $stat_smt3 = 'oren';
            }else{
                if($irs_smt3 && !$khs_smt3 && $pkl_smt3 && !$skripsi_smt3){
                        $stat_smt3 = 'oren';
                }else{
                    if($irs_smt3 && !$khs_smt3 && !$pkl_smt3 && $skripsi_smt3){
                        $stat_smt3 = 'oren';
                    }else{
                        if(!$irs_smt3 && !$khs_smt3 && !$pkl_smt3 && !$skripsi_smt3){
                            $stat_smt3 = 'merah';
                        }
                    }
                }
            }
        }
        
        if($irs_smt4 && $khs_smt4){
            if($pkl_smt4 && !$skripsi_smt4){
                $stat_smt4 = 'hijau';
            }else{
                if($skripsi_smt4){
                    $stat_smt4 = 'kuning';
                }else{
                    if(!$pkl_smt4 && !$skripsi_smt4){
                        $stat_smt4 = 'biru';
                    }
                }
            }
        }else{
            if($irs_smt4 && !$khs_smt4 && !$pkl_smt4 && !$skripsi_smt4){
                $stat_smt4 = 'oren';
            }else{
                if($irs_smt4 && !$khs_smt4 && $pkl_smt4 && !$skripsi_smt4){
                        $stat_smt4 = 'oren';
                }else{
                    if($irs_smt4 && !$khs_smt4 && !$pkl_smt4 && $skripsi_smt4){
                        $stat_smt4 = 'oren';
                    }else{
                        if(!$irs_smt4 && !$khs_smt4 && !$pkl_smt4 && !$skripsi_smt4){
                            $stat_smt4 = 'merah';
                        }
                    }
                }
            }
        }
        
        if($irs_smt5 && $khs_smt5){
            if($pkl_smt5 && !$skripsi_smt5){
                $stat_smt5 = 'hijau';
            }else{
                if($skripsi_smt5){
                    $stat_smt5 = 'kuning';
                }else{
                    if(!$pkl_smt5 && !$skripsi_smt5){
                        $stat_smt5 = 'biru';
                    }
                }
            }
        }else{
            if($irs_smt5 && !$khs_smt5 && !$pkl_smt5 && !$skripsi_smt5){
                $stat_smt5 = 'oren';
            }else{
                if($irs_smt5 && !$khs_smt5 && $pkl_smt5 && !$skripsi_smt5){
                        $stat_smt5 = 'oren';
                }else{
                    if($irs_smt5 && !$khs_smt5 && !$pkl_smt5 && $skripsi_smt5){
                        $stat_smt5 = 'oren';
                    }else{
                        if(!$irs_smt5 && !$khs_smt5 && !$pkl_smt5 && !$skripsi_smt5){
                            $stat_smt5 = 'merah';
                        }
                    }
                }
            }
        }
        
        if($irs_smt6 && $khs_smt6){
            if($pkl_smt6 && !$skripsi_smt6){
                $stat_smt6 = 'hijau';
            }else{
                if($skripsi_smt6){
                    $stat_smt6 = 'kuning';
                }else{
                    if(!$pkl_smt6 && !$skripsi_smt6){
                        $stat_smt6 = 'biru';
                    }
                }
            }
        }else{
            if($irs_smt6 && !$khs_smt6 && !$pkl_smt6 && !$skripsi_smt6){
                $stat_smt6 = 'oren';
            }else{
                if($irs_smt6 && !$khs_smt6 && $pkl_smt6 && !$skripsi_smt6){
                        $stat_smt6 = 'oren';
                }else{
                    if($irs_smt6 && !$khs_smt6 && !$pkl_smt6 && $skripsi_smt6){
                        $stat_smt6 = 'oren';
                    }else{
                        if(!$irs_smt6 && !$khs_smt6 && !$pkl_smt6 && !$skripsi_smt6){
                            $stat_smt6 = 'merah';
                        }
                    }
                }
            }
        }
        
        if($irs_smt7 && $khs_smt7){
            if($pkl_smt7 && !$skripsi_smt7){
                $stat_smt7 = 'hijau';
            }else{
                if($skripsi_smt7){
                    $stat_smt7 = 'kuning';
                }else{
                    if(!$pkl_smt7 && !$skripsi_smt7){
                        $stat_smt7 = 'biru';
                    }
                }
            }
        }else{
            if($irs_smt7 && !$khs_smt7 && !$pkl_smt7 && !$skripsi_smt7){
                $stat_smt7 = 'oren';
            }else{
                if($irs_smt7 && !$khs_smt7 && $pkl_smt7 && !$skripsi_smt7){
                        $stat_smt7 = 'oren';
                }else{
                    if($irs_smt7 && !$khs_smt7 && !$pkl_smt7 && $skripsi_smt7){
                        $stat_smt7 = 'oren';
                    }else{
                        if(!$irs_smt7 && !$khs_smt7 && !$pkl_smt7 && !$skripsi_smt7){
                            $stat_smt7 = 'merah';
                        }
                    }
                }
            }
        }
        
        if($irs_smt8 && $khs_smt8){
            if($pkl_smt8 && !$skripsi_smt8){
                $stat_smt8 = 'hijau';
            }else{
                if($skripsi_smt8){
                    $stat_smt8 = 'kuning';
                }else{
                    if(!$pkl_smt8 && !$skripsi_smt8){
                        $stat_smt8 = 'biru';
                    }
                }
            }
        }else{
            if($irs_smt8 && !$khs_smt8 && !$pkl_smt8 && !$skripsi_smt8){
                $stat_smt8 = 'oren';
            }else{
                if($irs_smt8 && !$khs_smt8 && $pkl_smt8 && !$skripsi_smt8){
                        $stat_smt8 = 'oren';
                }else{
                    if($irs_smt8 && !$khs_smt8 && !$pkl_smt8 && $skripsi_smt8){
                        $stat_smt8 = 'oren';
                    }else{
                        if(!$irs_smt8 && !$khs_smt8 && !$pkl_smt8 && !$skripsi_smt8){
                            $stat_smt8 = 'merah';
                        }
                    }
                }
            }
        }
        
        if($irs_smt9 && $khs_smt9){
            if($pkl_smt9 && !$skripsi_smt9){
                $stat_smt9 = 'hijau';
            }else{
                if($skripsi_smt9){
                    $stat_smt9 = 'kuning';
                }else{
                    if(!$pkl_smt9 && !$skripsi_smt9){
                        $stat_smt9 = 'biru';
                    }
                }
            }
        }else{
            if($irs_smt9 && !$khs_smt9 && !$pkl_smt9 && !$skripsi_smt9){
                $stat_smt9 = 'oren';
            }else{
                if($irs_smt9 && !$khs_smt9 && $pkl_smt9 && !$skripsi_smt9){
                        $stat_smt9 = 'oren';
                }else{
                    if($irs_smt9 && !$khs_smt9 && !$pkl_smt9 && $skripsi_smt9){
                        $stat_smt9 = 'oren';
                    }else{
                        if(!$irs_smt9 && !$khs_smt9 && !$pkl_smt9 && !$skripsi_smt9){
                            $stat_smt9 = 'merah';
                        }
                    }
                }
            }
        }
        
        if($irs_smt10 && $khs_smt10){
            if($pkl_smt10 && !$skripsi_smt10){
                $stat_smt10 = 'hijau';
            }else{
                if($skripsi_smt10){
                    $stat_smt10 = 'kuning';
                }else{
                    if(!$pkl_smt10 && !$skripsi_smt10){
                        $stat_smt10 = 'biru';
                    }
                }
            }
        }else{
            if($irs_smt10 && !$khs_smt10 && !$pkl_smt10 && !$skripsi_smt10){
                $stat_smt10 = 'oren';
            }else{
                if($irs_smt10 && !$khs_smt10 && $pkl_smt10 && !$skripsi_smt10){
                        $stat_smt10 = 'oren';
                }else{
                    if($irs_smt10 && !$khs_smt10 && !$pkl_smt10 && $skripsi_smt10){
                        $stat_smt10 = 'oren';
                    }else{
                        if(!$irs_smt10 && !$khs_smt10 && !$pkl_smt10 && !$skripsi_smt10){
                            $stat_smt10 = 'merah';
                        }
                    }
                }
            }
        }
        
        if($irs_smt11 && $khs_smt11){
            if($pkl_smt11 && !$skripsi_smt11){
                $stat_smt11 = 'hijau';
            }else{
                if($skripsi_smt11){
                    $stat_smt11 = 'kuning';
                }else{
                    if(!$pkl_smt11 && !$skripsi_smt11){
                        $stat_smt11 = 'biru';
                    }
                }
            }
        }else{
            if($irs_smt11 && !$khs_smt11 && !$pkl_smt11 && !$skripsi_smt11){
                $stat_smt11 = 'oren';
            }else{
                if($irs_smt11 && !$khs_smt11 && $pkl_smt11 && !$skripsi_smt11){
                        $stat_smt11 = 'oren';
                }else{
                    if($irs_smt11 && !$khs_smt11 && !$pkl_smt11 && $skripsi_smt11){
                        $stat_smt11 = 'oren';
                    }else{
                        if(!$irs_smt11 && !$khs_smt11 && !$pkl_smt11 && !$skripsi_smt11){
                            $stat_smt11 = 'merah';
                        }
                    }
                }
            }
        }
        
        if($irs_smt12 && $khs_smt12){
            if($pkl_smt12 && !$skripsi_smt12){
                $stat_smt12 = 'hijau';
            }else{
                if($skripsi_smt12){
                    $stat_smt12 = 'kuning';
                }else{
                    if(!$pkl_smt12 && !$skripsi_smt12){
                        $stat_smt12 = 'biru';
                    }
                }
            }
        }else{
            if($irs_smt12 && !$khs_smt12 && !$pkl_smt12 && !$skripsi_smt12){
                $stat_smt12 = 'oren';
            }else{
                if($irs_smt12 && !$khs_smt12 && $pkl_smt12 && !$skripsi_smt12){
                        $stat_smt12 = 'oren';
                }else{
                    if($irs_smt12 && !$khs_smt12 && !$pkl_smt12 && $skripsi_smt12){
                        $stat_smt12 = 'oren';
                    }else{
                        if(!$irs_smt12 && !$khs_smt12 && !$pkl_smt12 && !$skripsi_smt12){
                            $stat_smt12 = 'merah';
                        }
                    }
                }
            }
        }
        
        if($irs_smt13 && $khs_smt13){
            if($pkl_smt13 && !$skripsi_smt13){
                $stat_smt13 = 'hijau';
            }else{
                if($skripsi_smt13){
                    $stat_smt13 = 'kuning';
                }else{
                    if(!$pkl_smt13 && !$skripsi_smt13){
                        $stat_smt13 = 'biru';
                    }
                }
            }
        }else{
            if($irs_smt13 && !$khs_smt13 && !$pkl_smt13 && !$skripsi_smt13){
                $stat_smt13 = 'oren';
            }else{
                if($irs_smt13 && !$khs_smt13 && $pkl_smt13 && !$skripsi_smt13){
                        $stat_smt13 = 'oren';
                }else{
                    if($irs_smt13 && !$khs_smt13 && !$pkl_smt13 && $skripsi_smt13){
                        $stat_smt13 = 'oren';
                    }else{
                        if(!$irs_smt13 && !$khs_smt13 && !$pkl_smt13 && !$skripsi_smt13){
                            $stat_smt13 = 'merah';
                        }
                    }
                }
            }
        }
        
        if($irs_smt14 && $khs_smt14){
            if($pkl_smt14 && !$skripsi_smt14){
                $stat_smt14 = 'hijau';
            }else{
                if($skripsi_smt14){
                    $stat_smt14 = 'kuning';
                }else{
                    if(!$pkl_smt14 && !$skripsi_smt14){
                        $stat_smt14 = 'biru';
                    }
                }
            }
        }else{
            if($irs_smt14 && !$khs_smt14 && !$pkl_smt14 && !$skripsi_smt14){
                $stat_smt14 = 'oren';
            }else{
                if($irs_smt14 && !$khs_smt14 && $pkl_smt14 && !$skripsi_smt14){
                        $stat_smt14 = 'oren';
                }else{
                    if($irs_smt14 && !$khs_smt14 && !$pkl_smt14 && $skripsi_smt14){
                        $stat_smt14 = 'oren';
                    }else{
                        if(!$irs_smt14 && !$khs_smt14 && !$pkl_smt14 && !$skripsi_smt14){
                            $stat_smt14 = 'merah';
                        }
                    }
                }
            }
        }

        return view('profile_mhs',['mhs'=> $mhs,'smt1'=>$stat_smt1,'smt2'=>$stat_smt2,'smt3'=>$stat_smt3,'smt4'=>$stat_smt4,'smt5'=>$stat_smt5,'smt6'=>$stat_smt6,'smt7'=>$stat_smt7,'smt8'=>$stat_smt8,'smt9'=>$stat_smt9,'smt10'=>$stat_smt10,'smt11'=>$stat_smt11,'smt12'=>$stat_smt12,'smt13'=>$stat_smt13,'smt14'=>$stat_smt14]);
    }
    function halaman_profile_operator(){
        $email = session('email');
        $dataOperator = Operator::select('o.*', 'a.role')
        ->from('operators as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();

        return view('profile_operator',['data' => $dataOperator]);
    }
    function halaman_profile_departement(){
        $email = session('email');
        $datadept = Departement::select('o.*', 'a.role')
        ->from('departements as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        
        return view('profile_dept',['data' => $datadept]);
    }
    function halaman_mhs_operator(){
        $email = session('email');
        $dataOperator = Operator::select('o.*', 'a.role')
        ->from('operators as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();

        $mhs = Mahasiswa::select('m.nama','m.nim','m.angkatan','s.status as status_mhs')
        ->from('mahasiswas as m')
        ->join('stat_mahasiswa as s','s.kode_status','=','m.status')
        ->get();
        return view('data_mhs_operator',['data' => $dataOperator,'mhs'=>$mhs]);
    }
    function edit_mhs_operator($nim){
        $email = session('email');
        $dataOperator = Operator::select('o.*', 'a.role')
        ->from('operators as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();

        $mhs = Mahasiswa::select('m.*','s.status as status_mhs')
        ->from('mahasiswas as m')
        ->join('stat_mahasiswa as s','s.kode_status','=','m.status')
        ->where('m.nim','=',$nim)
        ->first();
        $dosen = Dosen::select('*')
        ->from('dosens')
        ->get();
        return view('edit_mhs_operator',['data' => $dataOperator,'mhs'=>$mhs,'doswal'=>$dosen]);
    }
}
?>