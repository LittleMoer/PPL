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

class MahasiswaController extends Controller{
    function confirmDataAwal(Request $request){
        $jalur_masuk = $request->jalur_masuk;
        $nama = $request->nama_lengkap;
        $no_telp = $request->no_telp;
        $email_input = $request->email;
        $alamat = $request->alamat;
        $provinsi = $request->provinsi;
        $kota = $request->kota;
        $password = $request->password;

        $nim = session('nim');
        // cek apakah email yang dimasukkan sudah dipakai atau belum
        $cek_email = Account::select('email')
        ->where('email','=', $email_input)
        ->first();
        
        // penyocokan ketika email sudah sama dengan nim yang dimasukkan
        // $cek_email1 = Account::select('email','nim_nip')
        // ->where('email','=', $email_input)
        // ->where('nim_nip','=', $nim)
        // ->first();
        // dd($cek_email);

        if(!$cek_email){
            DB::table('mahasiswas')->where('nim','=', $nim)->update(['jalur_masuk'=>$jalur_masuk,
            'email' => $email_input,
            'nama' => $nama,
            'no_hp' => $no_telp,
            'alamat' => $alamat,
            'provinsi' => $provinsi,
            'foto' => 'jojo.jpeg',
            'kab_kota' => $kota]);

            DB::table('accounts')->where('nim_nip','=', $nim)->update([
            'email' => $email_input,
            'password' => $password,]);

            $mhs1 = Mahasiswa::select('m.nama','a.role')
            ->from('mahasiswas as m')
            ->join('accounts as a','m.nim','=','a.nim_nip')
            ->where('a.nim_nip','=',$nim)
            ->first();

            session(['email' => $email_input]);
            return redirect('/profile/mhs');
        }else{
            if($cek_email){
                $prov = Prov::all();
                $kabkot = KabKot::all();
                
                $mhs1 = Mahasiswa::select('m.*','a.role','s.status as cek_status')
                ->from('mahasiswas as m')
                ->join('accounts as a','m.nim','=','a.nim_nip')
                ->join('stat_mahasiswa as s','s.kode_status','=','m.status')
                ->where('a.nim_nip','=',$nim)
                ->first();
    
                return view('update-mahasiswa',['mhs' => $mhs1, 'prov' => $prov, 'kabkot' => $kabkot , 'error_email' => 'Email sudah digunakan']);
            }
        }
    }

    function input_irs(request $request){
        $email = session('email');
        $sks = $request->sks;
        $mhs1 = Mahasiswa::select('m.nim')
        ->from('mahasiswas as m')
        ->where('m.email','=',$email)
        ->first();
        // dd($mhs1->nim);
        $this->validate($request,[
            'file_irs' => 'mimes:pdf',
        ]);
        $file = $request->file('file_irs');
        $nama_file = 'FT' .date("Ymdhis").'.' .$request->file('file_irs')->getClientOriginalExtension();
        $file->move('dokumen_ppl_projek/irs',$nama_file);

        DB::table('info_irs')->insert([
            'nim'=> $mhs1->nim,
            'smt' => $request->semester,
            'sks' => $request->sks,
            'scan_irs' => $nama_file
        ]);
        return view('informasi-irs',['mhs' => $mhs1]);
    }
    function input_khs(request $request){
        $email = session('email');
        $sks = $request->sks;
        $mhs1 = Mahasiswa::select('m.nim')
        ->from('mahasiswas as m')
        ->where('m.email','=',$email)
        ->first();
        
        $this->validate($request,[
            'file-khs' => 'mimes:pdf',
        ]);
        $file = $request->file('file-khs');
        $nama_file = 'FT' .date("Ymdhis").'.' .$request->file('file-khs')->getClientOriginalExtension();
        $file->move('dokumen_ppl_projek/khs',$nama_file);

        DB::table('info_khs')->insert([
            'nim'=> $mhs1->nim,
            'smt' => $request->semester,
            'sks' => $request->sks,
            'sks_kumulatif' => $request->sksk,
            'ip_smt' => $request->ip,
            'ipk' => $request->ipk,
            'scan_khs' => $nama_file
        ]);
        return view('informasi-khs',['mhs' => $mhs1]);
    }
    function input_pkl(request $request){
        $email = session('email');
        $mhs1 = Mahasiswa::select('m.nim')
        ->from('mahasiswas as m')
        ->where('m.email','=',$email)
        ->first();
        
        $this->validate($request,[
            'file-pkl' => 'mimes:pdf',
        ]);
        $file = $request->file('file-pkl');
        $nama_file = 'FT' .date("Ymdhis").'.' .$request->file('file-pkl')->getClientOriginalExtension();
        $file->move('dokumen_ppl_projek/pkl',$nama_file);

        DB::table('info_pkls')->insert([
            'nim'=> $mhs1->nim,
            'nilai_pkl' => $request->nilai_pkl,
            'semester' => $request->semester,
            'scan_pkl' => $nama_file
        ]);
        return view('informasi-pkl',['mhs' => $mhs1]);
    }
    function input_skripsi(request $request){
        $email = session('email');
        $mhs1 = Mahasiswa::select('m.nim')
        ->from('mahasiswas as m')
        ->where('m.email','=',$email)
        ->first();

        $this->validate($request,[
            'file-skripsi' => 'mimes:pdf',
        ]);
        
        $file = $request->file('file-skripsi');
        $nama_file = 'FT' .date("Ymdhis").'.' .$request->file('file-skripsi')->getClientOriginalExtension();
        $file->move('dokumen_ppl_projek/skripsi',$nama_file);

        $tgl_lulus = $request->tanggal_lulus;
        $lama_study = $request->lama_study;

        if($tgl_lulus == null && $lama_study == null){
            DB::table('info_skripsis')->insert([
                'nim'=> $mhs1->nim,
                'semester' => $request->semester,
                'nilai_skripsi' => $request->nilai_skripsi,
                'scan_skripsi' => $nama_file
            ]);
        }else{
            if($tgl_lulus == null && $lama_study != null){
                DB::table('info_skripsis')->insert([
                    'nim'=> $mhs1->nim,
                    'semester' => $request->semester,
                    'nilai_skripsi' => $request->nilai_skripsi,
                    'lama_study' => $lama_study,
                    'scan_skripsi' => $nama_file
                ]);
            }else{
                if($tgl_lulus != null && $lama_study == null){
                    DB::table('info_skripsis')->insert([
                        'nim'=> $mhs1->nim,
                        'semester' => $request->semester,
                        'nilai_skripsi' => $request->nilai_skripsi,
                        'tgl_lulus' => $tgl_lulus,
                        'scan_skripsi' => $nama_file
                    ]);
                }else{
                    if($tgl_lulus != null && $lama_study != null){
                        DB::table('info_skripsis')->insert([
                            'nim'=> $mhs1->nim,
                            'semester' => $request->semester,
                            'nilai_skripsi' => $request->nilai_skripsi,
                            'tgl_lulus' => $tgl_lulus,
                            'lama_study' => $lama_study,
                            'scan_skripsi' => $nama_file
                        ]);
                    }
                }
            }
        }
        return view('informasi-skripsi',['mhs' => $mhs1]);
    }
    function smt_mhs($smt){
        $email = session('email');
        $mhs1 = Mahasiswa::select('m.nim')
        ->from('mahasiswas as m')
        ->where('m.email','=',$email)
        ->first();
        $irs = Info_irs::select('i.*','s.status as info_status')
        ->from('info_irs as i')
        ->join('stat_cek as s','s.kode_status','=','i.stat_cek')
        ->where('i.nim','=',$mhs1->nim)
        ->where('i.smt','=',$smt)
        ->whereIn('stat_cek', [1, 2])
        ->first();
        $khs = Info_khs::select('i.*','s.status as info_status')
        ->from('info_khs as i')
        ->join('stat_cek as s','s.kode_status','=','i.stat_cek')
        ->where('i.nim','=',$mhs1->nim)
        ->where('i.smt','=',$smt)
        ->whereIn('stat_cek', [1, 2])
        ->first();
        $pkl = Info_pkl::select('i.*','s.status as info_status')
        ->from('info_pkls as i')
        ->join('stat_cek as s','s.kode_status','=','i.stat_cek')
        ->where('i.nim','=',$mhs1->nim)
        ->where('i.semester','=',$smt)
        ->whereIn('stat_cek', [1, 2])
        ->first();
        $skripsi = Info_skripsi::select('i.*','s.status as info_status')
        ->from('info_skripsis as i')
        ->join('stat_cek as s','s.kode_status','=','i.stat_cek')
        ->where('i.nim','=',$mhs1->nim)
        ->where('i.semester','=',$smt)
        ->whereIn('stat_cek', [1, 2])
        ->first();
        return view('detail_smt_mahasiswa',['mhs' => $mhs1,'irs'=>$irs,'khs'=>$khs,'pkl'=>$pkl,'skripsi'=>$skripsi]);
    }
}
?>