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

class DosenController extends Controller{
    function edit_validasi_irs($nim,$smt){
        $email = session('email');
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        
        $dataEdit = DB::table('info_irs')
        ->select('*')
        ->where('nim','=',$nim)
        ->where('smt','=',$smt)
        ->first();
        session(['nim' => $nim]);
        session(['smt' => $smt]);
        return view("edit_validasi_irs",['data'=>$datadosen1,'dataEdit'=> $dataEdit]);
    }
    function edit_validasi_khs($nim,$smt,$ip_smt){
        $email = session('email');
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        
        $dataEdit = DB::table('info_khs')
        ->select('*')
        ->where('nim','=',$nim)
        ->where('smt','=',$smt)
        ->first();
        session(['nim' => $nim]);
        session(['smt' => $smt]);
        session(['ip_smt' => $ip_smt]);
        return view("edit_validasi_khs",['data'=>$datadosen1,'dataEdit'=> $dataEdit]);
    }
    function edit_validasi_pkl($nim){
        $email = session('email');
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        
        $dataEdit = DB::table('info_pkls')
        ->select('i.*')
        ->from('info_pkls as i')
        ->where('nim','=',$nim)
        ->first();
        session(['nim' => $nim]);
        return view("edit_validasi_pkl",['data'=>$datadosen1,'dataEdit'=> $dataEdit]);
    }
    function edit_validasi_skripsi($nim){
        $email = session('email');
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        
        $dataEdit = DB::table('info_skripsis')
        ->select('i.*')
        ->from('info_skripsis as i')
        ->where('nim','=',$nim)
        ->first();
        session(['nim' => $nim]);
        return view("edit_validasi_skripsi",['data'=>$datadosen1,'dataEdit'=> $dataEdit]);
    }
    function confirmEditIRS(request $request){
        $email = session('email');
        $nim = session('nim');
        $smt = session('smt');

        $semester = $request->semester;
        $sks = $request->sks;

        // dd($sks);
        DB::table('info_irs')
            ->where('nim','=',$nim)
            ->where('smt','=',$smt)
            ->update([
                'smt'=> $semester,
                'sks'=> $sks,
            ]);

        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $dataEdit = DB::table('info_irs')
        ->select('*')
        ->where('nim','=',$nim)
        ->where('smt','=',$semester)
        ->first();

        $dataDosen = Dosen::select("nip")
            ->where("email","=",$email)
            ->first();
        $irs = Info_irs::select("m.nama","m.nim", "i.smt", "i.sks", "i.scan_irs")
            ->from("info_irs as i")
            ->join("mahasiswas as m", "m.nim","=","i.nim")
            ->where("m.kode_doswal","=",$dataDosen->nip)
            ->get();

        return redirect('/dosen_irs')->with('success','Data Edited');
    }
    function confirmEditKHS(request $request){
        $email = session('email');
        $nim = session('nim');
        $smt = session('smt');
        $ip_smt = session('ip_smt');

        $semester = $request->semester;
        $sks = $request->sks;
        $ip = $request->ip;
        
        // dd($sks);
        DB::table('info_khs')
        ->where('nim','=',$nim)
        ->where('smt','=',$smt)
        ->update([
            'smt'=> $semester,
            'sks'=> $sks,
            'ip_smt'=> $ip,
        ]);
        
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $dataEdit = DB::table('info_khs')
        ->select('*')
        ->where('nim','=',$nim)
        ->where('smt','=',$semester)
        ->where('ip_smt','=',$ip)
        ->first();

        $dataDosen = Dosen::select("nip")
            ->where("email","=",$email)
            ->first();
        $khs = Info_khs::select("m.nama","m.nim", "i.smt","i.ip_smt", "i.sks", "i.scan_khs")
            ->from("info_khs as i")
            ->join("mahasiswas as m", "m.nim","=","i.nim")
            ->where("m.kode_doswal","=",$dataDosen->nip)
            ->get();

            return redirect('/dosen_khs')->with('success','Data Edited');
    }
    function confirmEditPKL(request $request){
        $email = session('email');
        $nim = session('nim');

        $semester = $request->semester;
        $nilai = $request->nilai;
        
        // dd($sks);
        DB::table('info_pkls')
        ->where('nim','=',$nim)
        ->update([
            'nilai_pkl'=> $nilai,
            'Semester'=> $semester,
        ]);
        
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $dataEdit = DB::table('info_pkls')
        ->select('*')
        ->where('nim','=',$nim)
        ->first();

        $dataDosen = Dosen::select("nip")
            ->where("email","=",$email)
            ->first();
        $pkl = Info_pkl::select("m.nama","m.nim", "i.nilai_pkl","i.scan_pkl")
            ->from("info_pkls as i")
            ->join("mahasiswas as m", "m.nim","=","i.nim")
            ->where("m.kode_doswal","=",$dataDosen->nip)
            ->get();

            return redirect('/dosen_pkl')->with('success','Data Edited');
    }
    function confirmEditSKRIPSI(request $request){
        $email = session('email');
        $nim = session('nim');

        // $status = $request->status;
        $tgl_lulus = $request->tgl;
        $lama_study = $request->lama_study;
        $nilai = $request->nilai;
        
        // dd($sks);
        if($tgl_lulus == null && $lama_study == null){
            DB::table('info_skripsis')
            ->where('nim','=',$nim)
            ->update([
                
                'nilai_skripsi'=> $nilai,
            ]);
        }else{
            if($tgl_lulus == null && $lama_study != null){
                DB::table('info_skripsis')
                ->where('nim','=',$nim)
                ->update([
                    
                    'lama_study'=> $lama_study,
                    'nilai_skripsi'=> $nilai,
                ]);
            }else{
                if($tgl_lulus != null && $lama_study == null){
                    DB::table('info_skripsis')
                    ->where('nim','=',$nim)
                    ->update([
                        
                        'tgl_lulus'=> $tgl_lulus,
                        'nilai_skripsi'=> $nilai,
                    ]);
                }else{
                    if($tgl_lulus != null && $lama_study != null){
                        DB::table('info_skripsis')
                        ->where('nim','=',$nim)
                        ->update([
                            
                            'tgl_lulus'=> $tgl_lulus,
                            'lama_study'=> $lama_study,
                            'nilai_skripsi'=> $nilai,
                        ]);
                    }
                }
            }
        }
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $dataEdit = DB::table('info_skripsis')
        ->select('*')
        ->where('nim','=',$nim)
        ->first();

        $dataDosen = Dosen::select("nip")
            ->where("email","=",$email)
            ->first();
        $skripsi = Info_skripsi::select("m.nama","m.nim","i.tgl_lulus", "i.lama_study", "i.scan_skripsi")
            ->from("info_skripsis as i")
            ->join("mahasiswas as m", "m.nim","=","i.nim")
            ->where("m.kode_doswal","=",$dataDosen->nip)
            ->get();

            return redirect('/dosen_skripsi')->with('success','Data Edited');
    }

    function setujui_irs($nim,$smt){

        DB::table('info_irs')
            ->where('nim','=',$nim)
            ->where('smt','=',$smt)
            ->update([
                'stat_cek'=> 1,
            ]);
        DB::table('info_irs')
            ->where('nim','=',$nim)
            ->where('smt','=',$smt - 1)
            ->update([
                'stat_cek'=> 2,
            ]);

        return redirect('/dosen_irs');
    }
    function setujui_khs($nim,$smt,$ip_smt){
        DB::table('info_khs')
            ->where('nim','=',$nim)
            ->where('smt','=',$smt)
            ->where('ip_smt','=',$ip_smt)
            ->update([
                'stat_cek'=> 1,
            ]);

        return redirect('/dosen_khs');
    }
    function setujui_pkl($nim){
        DB::table('info_pkls')
            ->where('nim','=',$nim)
            ->update([
                'stat_cek'=> 1,
            ]);

        return redirect('/dosen_pkl');
    }
    function setujui_skripsi($nim){
        DB::table('info_skripsis')
            ->where('nim','=',$nim)
            ->update([
                'stat_cek'=> 1,
            ]);

        return redirect('/dosen_skripsi');
    }
    function unverif_irs(){
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
            ->where("i.stat_cek","=",0)
            ->get();
        return view('penyetujuan_irs',['irs' => $irs,'data' => $datadosen1]);
    }
    function verif_irs(){
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
            ->where("i.stat_cek","=",1)
            ->get();
        return view('penyetujuan_irs',['irs' => $irs,'data' => $datadosen1]);
    }

    function unverif_khs(){
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
            ->where("i.stat_cek","=",0)
            ->get();
        // dd($irs);
        return view('penyetujuan_khs',['khs' => $khs,'data' => $datadosen1]);
    }
    function verif_khs(){
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
            ->where("i.stat_cek","=",1)
            ->get();
        // dd($irs);
        return view('penyetujuan_khs',['khs' => $khs,'data' => $datadosen1]);
    }
    function unverif_pkl(){
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
            ->where("i.stat_cek","=",0)

            ->get();
        // dd($pkl);
        return view('penyetujuan_pkl',['pkl' => $pkl,'data' => $datadosen1]);
    }
    function verif_pkl(){
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
            ->where("i.stat_cek","=",1)
            ->get();
        // dd($pkl);
        return view('penyetujuan_pkl',['pkl' => $pkl,'data' => $datadosen1]);
    }
    function unverif_skripsi(){
        $email = session('email');
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $dataDosen = Dosen::select("nip")
            ->where("email","=",$email)
            ->first();
        $skripsi = Info_skripsi::select("m.nama","m.nim", "i.tgl_lulus", "i.lama_study", "i.scan_skripsi",'i.stat_cek')
            ->from("info_skripsis as i")
            ->join("mahasiswas as m", "m.nim","=","i.nim")
            ->where("m.kode_doswal","=",$dataDosen->nip)
            ->where("i.stat_cek","=",0)
            ->get();
        // dd($skripsi);
        return view('penyetujuan_skripsi',['skripsi' => $skripsi,'data' => $datadosen1]);
    }
    function verif_skripsi(){
        $email = session('email');
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $dataDosen = Dosen::select("nip")
            ->where("email","=",$email)
            ->first();
        $skripsi = Info_skripsi::select("m.nama","m.nim", "i.tgl_lulus", "i.lama_study", "i.scan_skripsi",'i.stat_cek')
            ->from("info_skripsis as i")
            ->join("mahasiswas as m", "m.nim","=","i.nim")
            ->where("m.kode_doswal","=",$dataDosen->nip)
            ->where("i.stat_cek","=",1)
            ->get();
        // dd($skripsi);
        return view('penyetujuan_skripsi',['skripsi' => $skripsi,'data' => $datadosen1]);
    }
    function delete_irs($nim,$smt){
        DB::table('info_irs')->where('nim','=',$nim)->where('smt','=',$smt)->delete();
        return redirect('/dosen_irs')->with('success','Data deleted');
    }
    function delete_khs($nim,$smt){
        DB::table('info_khs')->where('nim','=',$nim)->where('smt','=',$smt)->delete();
        return redirect('/dosen_khs')->with('success','Data deleted');
    }
    function delete_pkl($nim,$smt){
        DB::table('info_pkls')->where('nim','=',$nim)->where('semester','=',$smt)->delete();
        return redirect('/dosen_pkl')->with('success','Data deleted');
    }
    function delete_skripsi($nim){
        DB::table('info_skripsis')->where('nim','=',$nim)->delete();
        return redirect('/dosen_skripsi')->with('success','Data deleted');
    }

    function detail_mhs_dosen($mhs){
        $email = session('email');
        $mahasiswa = Mahasiswa::select('m.nama','m.nim','m.angkatan','d.nama as dosen')
        ->from('mahasiswas as m')
        ->join('dosens as d','d.nip','=','m.kode_doswal')
        ->where('m.nim','=',$mhs)
        ->first();

        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();

        $irs_smt1 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt1 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt1 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt1 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt2 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt2 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt2 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt2 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        
        $irs_smt3 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt3 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt3 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt3 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt4 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt4 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt4 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt4 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt5 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt5 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt5 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt5 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt6 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt6 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt6 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt6 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt7 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt7 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt7 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt7 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt8 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt8 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt8 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt8 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt9 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt9 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt9 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt9 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt10 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt10 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt10 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt10 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt11 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt11 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt11 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt11 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt12 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt12 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt12 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt12 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt13 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt13 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt13 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt13 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt14 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt14 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt14 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt14 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
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

        session(['mhs'=>$mhs]);
        return view('/detail_mhs_dosen',['mhs'=>$mahasiswa,'data'=>$datadosen1,'smt1'=>$stat_smt1,'smt2'=>$stat_smt2,'smt3'=>$stat_smt3,'smt4'=>$stat_smt4,'smt5'=>$stat_smt5,'smt6'=>$stat_smt6,'smt7'=>$stat_smt7,'smt8'=>$stat_smt8,'smt9'=>$stat_smt9,'smt10'=>$stat_smt10,'smt11'=>$stat_smt11,'smt12'=>$stat_smt12,'smt13'=>$stat_smt13,'smt14'=>$stat_smt14]);
    }
    function submit_info_mhs(Request $request){
        $email = session('email');
        $nama_nim = $request->mhs;
        // $smt = $request->semester;

        $mahasiswa = Mahasiswa::select('m.nama','m.nim')
        ->from('mahasiswas as m')
        ->join('dosens as d','d.nip','=','m.kode_doswal')
        // ->join('info_irs as i','i.nim','=','m.nim')
        ->where('d.email','=',$email)
        // ->where('i.smt','=',$smt)
        // ->where('i.stat_cek','=',1)
        ->where('m.nim','LIKE','%'.$nama_nim.'%')
        ->get();

        if($mahasiswa->count() == 0 ){
            $mahasiswa = Mahasiswa::select('m.nama','m.nim')
            ->from('mahasiswas as m')
            ->join('dosens as d','d.nip','=','m.kode_doswal')
            // ->join('info_irs as i','i.nim','=','m.nim')
            ->where('d.email','=',$email)
            // ->where('i.smt','=',$smt)
            // ->where('i.stat_cek','=',1)
            ->where('m.nama','LIKE','%'.$nama_nim.'%')
            ->get();
        }

        $datadosen1 = dosen::select('o.nama', 'a.role','o.nip')
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

        return view('/info_mahasiswa_dosen',['mhs'=>$mahasiswa,'data'=>$datadosen1,'jml_pkl'=>$cek_jml_pkl,'jml_skripsi'=>$cek_jml_skripsi,'jml_mhs'=>$cek_jml_mhs]);
    }
    function close(){
        $mhs = session('mhs');
        return redirect("/detail_mhs_dosen/{$mhs}");
    }
    function smt_1(){
        $email = session('email');
        $mhs = session('mhs');
        $mahasiswa = Mahasiswa::select('m.nama','m.nim','m.angkatan','d.nama as dosen')
        ->from('mahasiswas as m')
        ->join('dosens as d','d.nip','=','m.kode_doswal')
        ->where('m.nim','=',$mhs)
        ->first();
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $irs = Info_irs::select('*')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek', [1, 2])
        ->first();

        $irs_smt1 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt1 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt1 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt1 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt2 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt2 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt2 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt2 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        
        $irs_smt3 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt3 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt3 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt3 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt4 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt4 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt4 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt4 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt5 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt5 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt5 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt5 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt6 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt6 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt6 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt6 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt7 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt7 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt7 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt7 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt8 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt8 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt8 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt8 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt9 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt9 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt9 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt9 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt10 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt10 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt10 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt10 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt11 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt11 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt11 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt11 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt12 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt12 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt12 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt12 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt13 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt13 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt13 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt13 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt14 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt14 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt14 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt14 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
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

        $khs = Info_khs::select('*')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek', [1, 2])
        ->first();
        return view('popup_smt_mhs',['mhs'=>$mahasiswa,'data'=>$datadosen1,'irs'=>$irs,'khs'=>$khs,'smt1'=>$stat_smt1,'smt2'=>$stat_smt2,'smt3'=>$stat_smt3,'smt4'=>$stat_smt4,'smt5'=>$stat_smt5,'smt6'=>$stat_smt6,'smt7'=>$stat_smt7,'smt8'=>$stat_smt8,'smt9'=>$stat_smt9,'smt10'=>$stat_smt10,'smt11'=>$stat_smt11,'smt12'=>$stat_smt12,'smt13'=>$stat_smt13,'smt14'=>$stat_smt14]);
    }
    function smt_2(){
        $email = session('email');
        $mhs = session('mhs');
        $mahasiswa = Mahasiswa::select('m.nama','m.nim','m.angkatan','d.nama as dosen')
        ->from('mahasiswas as m')
        ->join('dosens as d','d.nip','=','m.kode_doswal')
        ->where('m.nim','=',$mhs)
        ->first();
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $irs = Info_irs::select('*')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek', [1, 2])
        ->first();

                $irs_smt1 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt1 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt1 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt1 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt2 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt2 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt2 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt2 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        
        $irs_smt3 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt3 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt3 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt3 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt4 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt4 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt4 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt4 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt5 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt5 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt5 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt5 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt6 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt6 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt6 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt6 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt7 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt7 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt7 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt7 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt8 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt8 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt8 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt8 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt9 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt9 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt9 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt9 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt10 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt10 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt10 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt10 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt11 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt11 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt11 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt11 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt12 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt12 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt12 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt12 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt13 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt13 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt13 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt13 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt14 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt14 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt14 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt14 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
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

        $khs = Info_khs::select('*')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek', [1, 2])
        ->first();
        return view('popup_smt_mhs',['mhs'=>$mahasiswa,'data'=>$datadosen1,'irs'=>$irs,'khs'=>$khs,'smt1'=>$stat_smt1,'smt2'=>$stat_smt2,'smt3'=>$stat_smt3,'smt4'=>$stat_smt4,'smt5'=>$stat_smt5,'smt6'=>$stat_smt6,'smt7'=>$stat_smt7,'smt8'=>$stat_smt8,'smt9'=>$stat_smt9,'smt10'=>$stat_smt10,'smt11'=>$stat_smt11,'smt12'=>$stat_smt12,'smt13'=>$stat_smt13,'smt14'=>$stat_smt14]);
    }
    function smt_3(){
        $email = session('email');
        $mhs = session('mhs');
        $mahasiswa = Mahasiswa::select('m.nama','m.nim','m.angkatan','d.nama as dosen')
        ->from('mahasiswas as m')
        ->join('dosens as d','d.nip','=','m.kode_doswal')
        ->where('m.nim','=',$mhs)
        ->first();
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $irs = Info_irs::select('*')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek', [1, 2])
        ->first();

                $irs_smt1 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt1 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt1 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt1 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt2 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt2 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt2 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt2 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        
        $irs_smt3 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt3 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt3 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt3 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt4 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt4 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt4 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt4 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt5 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt5 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt5 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt5 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt6 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt6 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt6 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt6 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt7 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt7 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt7 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt7 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt8 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt8 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt8 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt8 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt9 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt9 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt9 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt9 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt10 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt10 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt10 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt10 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt11 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt11 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt11 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt11 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt12 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt12 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt12 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt12 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt13 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt13 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt13 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt13 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt14 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt14 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt14 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt14 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
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

        $khs = Info_khs::select('*')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek', [1, 2])
        ->first();
        return view('popup_smt_mhs',['mhs'=>$mahasiswa,'data'=>$datadosen1,'irs'=>$irs,'khs'=>$khs,'smt1'=>$stat_smt1,'smt2'=>$stat_smt2,'smt3'=>$stat_smt3,'smt4'=>$stat_smt4,'smt5'=>$stat_smt5,'smt6'=>$stat_smt6,'smt7'=>$stat_smt7,'smt8'=>$stat_smt8,'smt9'=>$stat_smt9,'smt10'=>$stat_smt10,'smt11'=>$stat_smt11,'smt12'=>$stat_smt12,'smt13'=>$stat_smt13,'smt14'=>$stat_smt14]);
    }
    function smt_4(){
        $email = session('email');
        $mhs = session('mhs');
        $mahasiswa = Mahasiswa::select('m.nama','m.nim','m.angkatan','d.nama as dosen')
        ->from('mahasiswas as m')
        ->join('dosens as d','d.nip','=','m.kode_doswal')
        ->where('m.nim','=',$mhs)
        ->first();
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $irs = Info_irs::select('*')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek', [1, 2])
        ->first();

                $irs_smt1 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt1 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt1 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt1 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt2 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt2 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt2 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt2 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        
        $irs_smt3 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt3 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt3 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt3 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt4 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt4 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt4 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt4 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt5 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt5 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt5 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt5 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt6 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt6 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt6 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt6 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt7 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt7 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt7 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt7 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt8 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt8 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt8 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt8 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt9 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt9 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt9 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt9 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt10 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt10 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt10 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt10 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt11 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt11 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt11 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt11 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt12 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt12 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt12 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt12 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt13 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt13 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt13 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt13 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt14 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt14 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt14 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt14 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
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

        $khs = Info_khs::select('*')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek', [1, 2])
        ->first();
        return view('popup_smt_mhs',['mhs'=>$mahasiswa,'data'=>$datadosen1,'irs'=>$irs,'khs'=>$khs,'smt1'=>$stat_smt1,'smt2'=>$stat_smt2,'smt3'=>$stat_smt3,'smt4'=>$stat_smt4,'smt5'=>$stat_smt5,'smt6'=>$stat_smt6,'smt7'=>$stat_smt7,'smt8'=>$stat_smt8,'smt9'=>$stat_smt9,'smt10'=>$stat_smt10,'smt11'=>$stat_smt11,'smt12'=>$stat_smt12,'smt13'=>$stat_smt13,'smt14'=>$stat_smt14]);
    }
    function smt_5(){
        $email = session('email');
        $mhs = session('mhs');
        $mahasiswa = Mahasiswa::select('m.nama','m.nim','m.angkatan','d.nama as dosen')
        ->from('mahasiswas as m')
        ->join('dosens as d','d.nip','=','m.kode_doswal')
        ->where('m.nim','=',$mhs)
        ->first();
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $irs = Info_irs::select('*')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek', [1, 2])
        ->first();

                $irs_smt1 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt1 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt1 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt1 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt2 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt2 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt2 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt2 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        
        $irs_smt3 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt3 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt3 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt3 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt4 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt4 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt4 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt4 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt5 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt5 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt5 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt5 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt6 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt6 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt6 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt6 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt7 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt7 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt7 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt7 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt8 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt8 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt8 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt8 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt9 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt9 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt9 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt9 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt10 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt10 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt10 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt10 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt11 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt11 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt11 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt11 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt12 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt12 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt12 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt12 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt13 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt13 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt13 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt13 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt14 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt14 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt14 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt14 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
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

        $khs = Info_khs::select('*')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek', [1, 2])
        ->first();
        return view('popup_smt_mhs',['mhs'=>$mahasiswa,'data'=>$datadosen1,'irs'=>$irs,'khs'=>$khs,'smt1'=>$stat_smt1,'smt2'=>$stat_smt2,'smt3'=>$stat_smt3,'smt4'=>$stat_smt4,'smt5'=>$stat_smt5,'smt6'=>$stat_smt6,'smt7'=>$stat_smt7,'smt8'=>$stat_smt8,'smt9'=>$stat_smt9,'smt10'=>$stat_smt10,'smt11'=>$stat_smt11,'smt12'=>$stat_smt12,'smt13'=>$stat_smt13,'smt14'=>$stat_smt14]);
    }
    function smt_6(){
        $email = session('email');
        $mhs = session('mhs');
        $mahasiswa = Mahasiswa::select('m.nama','m.nim','m.angkatan','d.nama as dosen')
        ->from('mahasiswas as m')
        ->join('dosens as d','d.nip','=','m.kode_doswal')
        ->where('m.nim','=',$mhs)
        ->first();
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $irs = Info_irs::select('*')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek', [1, 2])
        ->first();

                $irs_smt1 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt1 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt1 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt1 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt2 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt2 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt2 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt2 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        
        $irs_smt3 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt3 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt3 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt3 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt4 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt4 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt4 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt4 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt5 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt5 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt5 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt5 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt6 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt6 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt6 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt6 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt7 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt7 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt7 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt7 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt8 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt8 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt8 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt8 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt9 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt9 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt9 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt9 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt10 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt10 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt10 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt10 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt11 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt11 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt11 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt11 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt12 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt12 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt12 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt12 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt13 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt13 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt13 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt13 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt14 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt14 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt14 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt14 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
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

        $khs = Info_khs::select('*')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek', [1, 2])
        ->first();
        return view('popup_smt_mhs',['mhs'=>$mahasiswa,'data'=>$datadosen1,'irs'=>$irs,'khs'=>$khs,'smt1'=>$stat_smt1,'smt2'=>$stat_smt2,'smt3'=>$stat_smt3,'smt4'=>$stat_smt4,'smt5'=>$stat_smt5,'smt6'=>$stat_smt6,'smt7'=>$stat_smt7,'smt8'=>$stat_smt8,'smt9'=>$stat_smt9,'smt10'=>$stat_smt10,'smt11'=>$stat_smt11,'smt12'=>$stat_smt12,'smt13'=>$stat_smt13,'smt14'=>$stat_smt14]);
    }
    function smt_7(){
        $email = session('email');
        $mhs = session('mhs');
        $mahasiswa = Mahasiswa::select('m.nama','m.nim','m.angkatan','d.nama as dosen')
        ->from('mahasiswas as m')
        ->join('dosens as d','d.nip','=','m.kode_doswal')
        ->where('m.nim','=',$mhs)
        ->first();
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $irs = Info_irs::select('*')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek', [1, 2])
        ->first();

                $irs_smt1 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt1 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt1 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt1 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt2 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt2 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt2 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt2 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        
        $irs_smt3 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt3 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt3 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt3 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt4 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt4 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt4 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt4 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt5 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt5 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt5 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt5 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt6 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt6 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt6 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt6 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt7 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt7 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt7 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt7 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt8 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt8 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt8 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt8 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt9 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt9 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt9 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt9 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt10 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt10 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt10 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt10 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt11 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt11 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt11 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt11 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt12 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt12 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt12 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt12 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt13 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt13 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt13 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt13 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt14 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt14 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt14 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt14 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
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

        $khs = Info_khs::select('*')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek', [1, 2])
        ->first();
        return view('popup_smt_mhs',['mhs'=>$mahasiswa,'data'=>$datadosen1,'irs'=>$irs,'khs'=>$khs,'smt1'=>$stat_smt1,'smt2'=>$stat_smt2,'smt3'=>$stat_smt3,'smt4'=>$stat_smt4,'smt5'=>$stat_smt5,'smt6'=>$stat_smt6,'smt7'=>$stat_smt7,'smt8'=>$stat_smt8,'smt9'=>$stat_smt9,'smt10'=>$stat_smt10,'smt11'=>$stat_smt11,'smt12'=>$stat_smt12,'smt13'=>$stat_smt13,'smt14'=>$stat_smt14]);
    }
    function smt_8(){
        $email = session('email');
        $mhs = session('mhs');
        $mahasiswa = Mahasiswa::select('m.nama','m.nim','m.angkatan','d.nama as dosen')
        ->from('mahasiswas as m')
        ->join('dosens as d','d.nip','=','m.kode_doswal')
        ->where('m.nim','=',$mhs)
        ->first();
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $irs = Info_irs::select('*')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek', [1, 2])
        ->first();

                $irs_smt1 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt1 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt1 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt1 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt2 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt2 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt2 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt2 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        
        $irs_smt3 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt3 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt3 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt3 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt4 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt4 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt4 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt4 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt5 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt5 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt5 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt5 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt6 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt6 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt6 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt6 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt7 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt7 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt7 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt7 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt8 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt8 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt8 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt8 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt9 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt9 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt9 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt9 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt10 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt10 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt10 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt10 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt11 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt11 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt11 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt11 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt12 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt12 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt12 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt12 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt13 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt13 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt13 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt13 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt14 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt14 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt14 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt14 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
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

        $khs = Info_khs::select('*')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek', [1, 2])
        ->first();
        return view('popup_smt_mhs',['mhs'=>$mahasiswa,'data'=>$datadosen1,'irs'=>$irs,'khs'=>$khs,'smt1'=>$stat_smt1,'smt2'=>$stat_smt2,'smt3'=>$stat_smt3,'smt4'=>$stat_smt4,'smt5'=>$stat_smt5,'smt6'=>$stat_smt6,'smt7'=>$stat_smt7,'smt8'=>$stat_smt8,'smt9'=>$stat_smt9,'smt10'=>$stat_smt10,'smt11'=>$stat_smt11,'smt12'=>$stat_smt12,'smt13'=>$stat_smt13,'smt14'=>$stat_smt14]);
    }
    function smt_9(){
        $email = session('email');
        $mhs = session('mhs');
        $mahasiswa = Mahasiswa::select('m.nama','m.nim','m.angkatan','d.nama as dosen')
        ->from('mahasiswas as m')
        ->join('dosens as d','d.nip','=','m.kode_doswal')
        ->where('m.nim','=',$mhs)
        ->first();
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $irs = Info_irs::select('*')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek', [1, 2])
        ->first();

                $irs_smt1 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt1 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt1 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt1 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt2 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt2 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt2 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt2 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        
        $irs_smt3 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt3 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt3 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt3 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt4 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt4 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt4 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt4 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt5 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt5 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt5 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt5 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt6 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt6 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt6 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt6 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt7 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt7 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt7 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt7 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt8 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt8 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt8 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt8 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt9 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt9 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt9 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt9 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt10 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt10 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt10 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt10 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt11 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt11 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt11 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt11 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt12 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt12 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt12 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt12 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt13 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt13 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt13 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt13 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt14 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt14 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt14 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt14 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
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

        $khs = Info_khs::select('*')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek', [1, 2])
        ->first();
        return view('popup_smt_mhs',['mhs'=>$mahasiswa,'data'=>$datadosen1,'irs'=>$irs,'khs'=>$khs,'smt1'=>$stat_smt1,'smt2'=>$stat_smt2,'smt3'=>$stat_smt3,'smt4'=>$stat_smt4,'smt5'=>$stat_smt5,'smt6'=>$stat_smt6,'smt7'=>$stat_smt7,'smt8'=>$stat_smt8,'smt9'=>$stat_smt9,'smt10'=>$stat_smt10,'smt11'=>$stat_smt11,'smt12'=>$stat_smt12,'smt13'=>$stat_smt13,'smt14'=>$stat_smt14]);
    }
    function smt_10(){
        $email = session('email');
        $mhs = session('mhs');
        $mahasiswa = Mahasiswa::select('m.nama','m.nim','m.angkatan','d.nama as dosen')
        ->from('mahasiswas as m')
        ->join('dosens as d','d.nip','=','m.kode_doswal')
        ->where('m.nim','=',$mhs)
        ->first();
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $irs = Info_irs::select('*')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek', [1, 2])
        ->first();

                $irs_smt1 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt1 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt1 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt1 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt2 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt2 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt2 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt2 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        
        $irs_smt3 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt3 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt3 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt3 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt4 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt4 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt4 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt4 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt5 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt5 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt5 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt5 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt6 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt6 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt6 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt6 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt7 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt7 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt7 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt7 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt8 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt8 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt8 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt8 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt9 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt9 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt9 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt9 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt10 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt10 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt10 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt10 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt11 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt11 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt11 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt11 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt12 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt12 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt12 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt12 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt13 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt13 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt13 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt13 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt14 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt14 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt14 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt14 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
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

        $khs = Info_khs::select('*')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek', [1, 2])
        ->first();
        return view('popup_smt_mhs',['mhs'=>$mahasiswa,'data'=>$datadosen1,'irs'=>$irs,'khs'=>$khs,'smt1'=>$stat_smt1,'smt2'=>$stat_smt2,'smt3'=>$stat_smt3,'smt4'=>$stat_smt4,'smt5'=>$stat_smt5,'smt6'=>$stat_smt6,'smt7'=>$stat_smt7,'smt8'=>$stat_smt8,'smt9'=>$stat_smt9,'smt10'=>$stat_smt10,'smt11'=>$stat_smt11,'smt12'=>$stat_smt12,'smt13'=>$stat_smt13,'smt14'=>$stat_smt14]);
    }
    function smt_11(){
        $email = session('email');
        $mhs = session('mhs');
        $mahasiswa = Mahasiswa::select('m.nama','m.nim','m.angkatan','d.nama as dosen')
        ->from('mahasiswas as m')
        ->join('dosens as d','d.nip','=','m.kode_doswal')
        ->where('m.nim','=',$mhs)
        ->first();
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $irs = Info_irs::select('*')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek', [1, 2])
        ->first();

                $irs_smt1 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt1 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt1 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt1 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt2 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt2 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt2 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt2 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        
        $irs_smt3 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt3 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt3 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt3 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt4 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt4 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt4 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt4 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt5 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt5 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt5 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt5 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt6 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt6 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt6 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt6 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt7 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt7 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt7 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt7 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt8 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt8 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt8 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt8 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt9 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt9 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt9 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt9 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt10 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt10 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt10 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt10 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt11 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt11 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt11 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt11 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt12 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt12 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt12 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt12 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt13 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt13 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt13 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt13 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt14 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt14 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt14 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt14 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
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

        $khs = Info_khs::select('*')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek', [1, 2])
        ->first();
        return view('popup_smt_mhs',['mhs'=>$mahasiswa,'data'=>$datadosen1,'irs'=>$irs,'khs'=>$khs,'smt1'=>$stat_smt1,'smt2'=>$stat_smt2,'smt3'=>$stat_smt3,'smt4'=>$stat_smt4,'smt5'=>$stat_smt5,'smt6'=>$stat_smt6,'smt7'=>$stat_smt7,'smt8'=>$stat_smt8,'smt9'=>$stat_smt9,'smt10'=>$stat_smt10,'smt11'=>$stat_smt11,'smt12'=>$stat_smt12,'smt13'=>$stat_smt13,'smt14'=>$stat_smt14]);
    }
    function smt_12(){
        $email = session('email');
        $mhs = session('mhs');
        $mahasiswa = Mahasiswa::select('m.nama','m.nim','m.angkatan','d.nama as dosen')
        ->from('mahasiswas as m')
        ->join('dosens as d','d.nip','=','m.kode_doswal')
        ->where('m.nim','=',$mhs)
        ->first();
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $irs = Info_irs::select('*')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek', [1, 2])
        ->first();

                $irs_smt1 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt1 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt1 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt1 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt2 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt2 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt2 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt2 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        
        $irs_smt3 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt3 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt3 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt3 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt4 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt4 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt4 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt4 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt5 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt5 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt5 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt5 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt6 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt6 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt6 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt6 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt7 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt7 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt7 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt7 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt8 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt8 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt8 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt8 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt9 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt9 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt9 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt9 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt10 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt10 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt10 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt10 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt11 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt11 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt11 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt11 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt12 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt12 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt12 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt12 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt13 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt13 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt13 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt13 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt14 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt14 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt14 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt14 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
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

        $khs = Info_khs::select('*')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek', [1, 2])
        ->first();
        return view('popup_smt_mhs',['mhs'=>$mahasiswa,'data'=>$datadosen1,'irs'=>$irs,'khs'=>$khs,'smt1'=>$stat_smt1,'smt2'=>$stat_smt2,'smt3'=>$stat_smt3,'smt4'=>$stat_smt4,'smt5'=>$stat_smt5,'smt6'=>$stat_smt6,'smt7'=>$stat_smt7,'smt8'=>$stat_smt8,'smt9'=>$stat_smt9,'smt10'=>$stat_smt10,'smt11'=>$stat_smt11,'smt12'=>$stat_smt12,'smt13'=>$stat_smt13,'smt14'=>$stat_smt14]);
    }
    function smt_13(){
        $email = session('email');
        $mhs = session('mhs');
        $mahasiswa = Mahasiswa::select('m.nama','m.nim','m.angkatan','d.nama as dosen')
        ->from('mahasiswas as m')
        ->join('dosens as d','d.nip','=','m.kode_doswal')
        ->where('m.nim','=',$mhs)
        ->first();
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $irs = Info_irs::select('*')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek', [1, 2])
        ->first();

                $irs_smt1 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt1 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt1 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt1 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt2 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt2 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt2 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt2 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        
        $irs_smt3 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt3 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt3 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt3 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt4 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt4 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt4 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt4 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt5 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt5 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt5 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt5 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt6 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt6 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt6 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt6 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt7 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt7 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt7 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt7 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt8 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt8 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt8 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt8 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt9 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt9 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt9 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt9 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt10 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt10 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt10 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt10 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt11 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt11 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt11 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt11 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt12 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt12 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt12 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt12 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt13 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt13 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt13 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt13 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt14 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt14 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt14 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt14 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
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

        $khs = Info_khs::select('*')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek', [1, 2])
        ->first();
        return view('popup_smt_mhs',['mhs'=>$mahasiswa,'data'=>$datadosen1,'irs'=>$irs,'khs'=>$khs,'smt1'=>$stat_smt1,'smt2'=>$stat_smt2,'smt3'=>$stat_smt3,'smt4'=>$stat_smt4,'smt5'=>$stat_smt5,'smt6'=>$stat_smt6,'smt7'=>$stat_smt7,'smt8'=>$stat_smt8,'smt9'=>$stat_smt9,'smt10'=>$stat_smt10,'smt11'=>$stat_smt11,'smt12'=>$stat_smt12,'smt13'=>$stat_smt13,'smt14'=>$stat_smt14]);
    }
    function smt_14(){
        $email = session('email');
        $mhs = session('mhs');
        $mahasiswa = Mahasiswa::select('m.nama','m.nim','m.angkatan','d.nama as dosen')
        ->from('mahasiswas as m')
        ->join('dosens as d','d.nip','=','m.kode_doswal')
        ->where('m.nim','=',$mhs)
        ->first();
        $datadosen1 = dosen::select('o.nama', 'a.role')
        ->from('dosens as o')
        ->join('accounts as a','a.email','=','o.email')
        ->where('o.email','=',$email)
        ->first();
        $irs = Info_irs::select('*')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek', [1, 2])
        ->first();

                $irs_smt1 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt1 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt1 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt1 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',1)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt2 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt2 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt2 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt2 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',2)
        ->whereIn('stat_cek',[1,2])
        ->first();
        
        $irs_smt3 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt3 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt3 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt3 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',3)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt4 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt4 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt4 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt4 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',4)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt5 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt5 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt5 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt5 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',5)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt6 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt6 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt6 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt6 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',6)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt7 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt7 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt7 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt7 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',7)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt8 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt8 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt8 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt8 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',8)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt9 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt9 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt9 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt9 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',9)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt10 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt10 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt10 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt10 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',10)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt11 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt11 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt11 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt11 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',11)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt12 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt12 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt12 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt12 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',12)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt13 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt13 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt13 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt13 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
        ->where('semester','=',13)
        ->whereIn('stat_cek',[1,2])
        ->first();

        $irs_smt14 = Info_irs::select('stat_cek')
        ->from('info_irs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $khs_smt14 = Info_khs::select('stat_cek')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $pkl_smt14 = Info_pkl::select('stat_cek')
        ->from('info_pkls')
        ->where('nim','=',$mhs)
        ->where('semester','=',14)
        ->whereIn('stat_cek',[1,2])
        ->first();
        $skripsi_smt14 = Info_skripsi::select('stat_cek')
        ->from('info_skripsis')
        ->where('nim','=',$mhs)
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

        $khs = Info_khs::select('*')
        ->from('info_khs')
        ->where('nim','=',$mhs)
        ->where('smt','=',14)
        ->whereIn('stat_cek', [1, 2])
        ->first();
        return view('popup_smt_mhs',['mhs'=>$mahasiswa,'data'=>$datadosen1,'irs'=>$irs,'khs'=>$khs,'smt1'=>$stat_smt1,'smt2'=>$stat_smt2,'smt3'=>$stat_smt3,'smt4'=>$stat_smt4,'smt5'=>$stat_smt5,'smt6'=>$stat_smt6,'smt7'=>$stat_smt7,'smt8'=>$stat_smt8,'smt9'=>$stat_smt9,'smt10'=>$stat_smt10,'smt11'=>$stat_smt11,'smt12'=>$stat_smt12,'smt13'=>$stat_smt13,'smt14'=>$stat_smt14]);
    }

}

?>