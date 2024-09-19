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
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
class DepartementController extends Controller{

    function data_mhs(){
        $email = session('email');
        $mhs = Mahasiswa::select('m.*','i.smt')
        ->from('mahasiswas as m')
        ->join('info_irs as i','i.nim','m.nim')
        ->where('i.stat_cek','=',1)
        ->get();

        $datadept = Departement::select('d.*', 'a.role')
                ->from('departements as d')
                ->join('accounts as a','a.email','=','d.email')
                ->where('d.email','=',$email)
                ->first();
        return view('data_mhs_dept',['data'=>$datadept]);
    }
    function rekap_pkl(){
        $email = session('email');
        $datadept = Departement::select('d.*', 'a.role')
        ->from('departements as d')
        ->join('accounts as a','a.email','=','d.email')
        ->where('d.email','=',$email)
        ->first();

        $tahun_skrg = date('Y');

        for($i = $tahun_skrg - 6; $i < $tahun_skrg + 1; $i++){
            $jml_angkatan = Mahasiswa::where('angkatan','=',$i)->count();
            // $mhs_angkatan = Mahasiswa::where('angkatan','=',$i)->get();

            if( $jml_angkatan > 0){
                $cek_pkl = Info_pkl::select('i.*')
                ->from('info_pkls as i')
                ->join('mahasiswas as m','m.nim','=','i.nim')
                ->where('m.angkatan','=',$i)
                ->where('i.stat_cek','=',1)
                ->count();
                $cek_skripsi = Info_skripsi::select('i.*')
                ->from('info_skripsis as i')
                ->join('mahasiswas as m','m.nim','=','i.nim')
                ->where('m.angkatan','=',$i)
                ->where('i.stat_cek','=',1)
                ->count();

                session(['sudahpkl'.$i => $cek_pkl,'belumpkl'.$i => $jml_angkatan - $cek_pkl,'sudahskripsi'.$i => $cek_skripsi,'belumskripsi'.$i => $jml_angkatan - $cek_skripsi]);
            }else{
                session(['sudahpkl'.$i => '-','belumpkl'.$i => '-','sudahskripsi'.$i => '-','belumskripsi'.$i => '-']);
            }
        }
        // dd(session('sudahpkl'.'2017'));
        return view('rekap_pkl',['data'=>$datadept]);
    }

    function data_lulus_pkl($angkatan){
        $email = session('email');
        $datadept = Departement::select('d.*', 'a.role')
        ->from('departements as d')
        ->join('accounts as a','a.email','=','d.email')
        ->where('d.email','=',$email)
        ->first();

        $pkl = Info_pkl::select("i.*",'m.nama')
        ->from('info_pkls as i')
        ->join('mahasiswas as m','m.nim','=','i.nim')
        ->where('m.angkatan','=',$angkatan)
        ->where('i.stat_cek','=',1)
        ->get();

        return view('lulus_pkl',['data'=>$datadept,'pkl'=>$pkl]);
    }
    function data_belum_lulus_pkl($angkatan){
        $email = session('email');
        $datadept = Departement::select('d.*', 'a.role')
        ->from('departements as d')
        ->join('accounts as a','a.email','=','d.email')
        ->where('d.email','=',$email)
        ->first();

        $pkl = Info_pkl::select("i.*")
        ->from('info_pkls as i')
        ->join('mahasiswas as m','m.nim','=','i.nim')
        ->where('m.angkatan','=',$angkatan)
        ->where('i.stat_cek','=',1)
        ->get();

        $nim_pkl = $pkl->pluck('nim');
        $cek_mhs = Mahasiswa::whereNotIn('nim', $nim_pkl)->where('angkatan','=',$angkatan)->get();
        return view('belum_lulus_pkl',['data'=>$datadept,'mhs'=>$cek_mhs]);
    }
    function data_lulus_skripsi($angkatan){
        
        $email = session('email');
        $datadept = Departement::select('d.*', 'a.role')
        ->from('departements as d')
        ->join('accounts as a','a.email','=','d.email')
        ->where('d.email','=',$email)
        ->first();

        $skripsi = Info_skripsi::select("i.*",'m.nama')
        ->from('info_skripsis as i')
        ->join('mahasiswas as m','m.nim','=','i.nim')
        ->where('m.angkatan','=',$angkatan)
        ->where('i.stat_cek','=',1)
        ->get();

        return view('lulus_skripsi',['data'=>$datadept,'skripsi'=>$skripsi]);
    }
    function data_belum_lulus_skripsi($angkatan){
        $email = session('email');
        $datadept = Departement::select('d.*', 'a.role')
        ->from('departements as d')
        ->join('accounts as a','a.email','=','d.email')
        ->where('d.email','=',$email)
        ->first();

        $skripsi = Info_skripsi::select("i.*")
        ->from('info_skripsis as i')
        ->join('mahasiswas as m','m.nim','=','i.nim')
        ->where('m.angkatan','=',$angkatan)
        ->where('i.stat_cek','=',1)
        ->get();

        $nim_skripsi = $skripsi->pluck('nim');
        $cek_mhs = Mahasiswa::whereNotIn('nim', $nim_skripsi)->where('angkatan','=',$angkatan)->get();
        return view('belum_lulus_skripsi',['data'=>$datadept,'mhs'=>$cek_mhs]);
    }

    public $jml1;
    function statistik_mahasiswa(){
        $email = session('email');
        $datadept = Departement::select('d.*', 'a.role')
        ->from('departements as d')
        ->join('accounts as a','a.email','=','d.email')
        ->where('d.email','=',$email)
        ->first();
        
        $jml_mhs = [];
        for($i = 1; $i <= 7; $i++){
            $cek_jml = Mahasiswa::where('status','=',$i)->count();
            $label = DB::table('stat_mahasiswa')
            ->select('status')
            ->where('kode_status','=',$i)
            ->first();
            $jml_mhs[] = $cek_jml;
            $jml['jml'][] = (int) $cek_jml;
            $jml['label'][] = $label->status;
        }
        $this->jml1 = json_encode($jml);

        return view('chart_dept',['data'=>$datadept,'jml'=>$this->jml1,'jml_mhs_stat'=>$jml_mhs]);
    }
    function detail_status($status){
        $email = session('email');
        $cek_stat = DB::table('stat_mahasiswa')
        ->select('kode_status')
        ->where('status','=',$status)
        ->first();
        $datadept = Departement::select('d.*', 'a.role')
        ->from('departements as d')
        ->join('accounts as a','a.email','=','d.email')
        ->where('d.email','=',$email)
        ->first();
        // dd($cek_stat);
        $mhs = Mahasiswa::where('status','=',$cek_stat->kode_status)->get();
        return view('detail_status_mhs',['data'=>$datadept,'mhs'=>$mhs]);
    }
    function stat_angkatan(request $request){
        $email = session('email');
        $datadept = Departement::select('d.*', 'a.role')
        ->from('departements as d')
        ->join('accounts as a','a.email','=','d.email')
        ->where('d.email','=',$email)
        ->first();
        
        $jml_mhs = [];
        for($i = 1; $i <= 7; $i++){
            $cek_jml = Mahasiswa::where('status','=',$i)->where('angkatan','=',$request->angkatan)->count();
            $label = DB::table('stat_mahasiswa')
            ->select('status')
            ->where('kode_status','=',$i)
            ->first();
            $jml_mhs[] = $cek_jml;
            $jml['jml'][] = (int) $cek_jml;
            $jml['label'][] = $label->status;
        }
        $this->jml1 = json_encode($jml);

        return view('chart_dept',['data'=>$datadept,'jml'=>$this->jml1,'jml_mhs_stat'=>$jml_mhs]);
    }
    function upload_batch_mhs(request $request){
        $this->validate($request,[
            'file_mhs' => 'mimes:xlsx',
        ]);
        $file = $request->file('file_mhs');
        $nama_file = 'File_batch'.'.'.$file->getClientOriginalExtension();
        $file->move('file_batch_mhs',$nama_file);
        $nama_file_excel = 'file_batch_mhs/'.$nama_file;

        // Load file Excel
        $spreadsheet = IOFactory::load($nama_file_excel);
        // Mendapatkan sheet pertama dalam file Excel
        $sheet = $spreadsheet->getActiveSheet();
        // Mendapatkan seluruh data dari sheet sebagai array
        $data = $sheet->toArray();
        for($i = 0; $i < count($data); $i++){
            $cek_null = false;
            for($j = 0 ; $j < count($data[$i]); $j++ ){
                if($data[$i][$j] == null){
                    $cek_null = true;
                }
            }
            if($cek_null){
                File::delete('file_batch_mhs/'.$nama_file);
                return redirect('/entry')->with(['error_file' => 'Data kurang lengkap pada baris ke '.$i+1]);
            }else{
                $cek_nim_mhs = Mahasiswa::select('*')
                    ->from('mahasiswas')
                    ->where('nim','=',$data[$i][1])
                    ->first();
                $cek_nama_mhs = Mahasiswa::select('*')
                    ->from('mahasiswas')
                    ->where('nama','=',$data[$i][0])
                    ->first();
                // cek ada mahasiswa dengan nim atau nama yang di input atau tidak
                if($cek_nim_mhs || $cek_nama_mhs){
                    File::delete('file_batch_mhs/'.$nama_file);
                    return redirect('/entry')->with(['error_file' => 'Data pada NIM : '.$data[$i][1].' sudah tersedia']);
                }else{
                    DB::table('mahasiswas')->insert([
                        'nama' => $data[$i][0],
                        'nim' => $data[$i][1],
                        'angkatan' => $data[$i][2],
                        'kode_doswal' => $data[$i][3]
                    ]);
                    DB::table('accounts')->insert([
                        'nim_nip' => $data[$i][1]
                    ]);
                }
            }
        }
        File::delete('file_batch_mhs/'.$nama_file);
        return redirect('/entry')->with(['sukses' => 'Data berhasil ditambahkan']);


    }
    //  ========== VERSI UNTUK FILE YANG PDF =================

    // function upload_batch_mhs(request $request){
    //     $this->validate($request,[
    //         'file_mhs' => 'mimes:pdf',
    //     ]);
    //     $file = $request->file('file_mhs');
        
    //     $nama_file = 'File_batch'.'.'.$file->getClientOriginalExtension();
    //     $file->move('file_batch_mhs',$nama_file);
    //     $parser = new Parser();
    //     $pdf = $parser->parseFile(public_path('file_batch_mhs/'.$nama_file));

    //     $text = $pdf->getText();
    //     $lines = explode("\n", $text);
    //     foreach ($lines as $line) {
    //         // Bersihkan whitespace yang tidak diperlukan
    //         $cleanedLine = trim(preg_replace('/\s+/', '', $line));
    
    //         // Pisahkan berdasarkan tanda ":" jika ada
    //         $parts = explode(':', $cleanedLine);
            

    //         if (count($parts) === 4) {
    //             $nama = trim($parts[0]);
    //             $nim = trim($parts[1]);
    //             $angkatan = ($parts[2]);
    //             $doswal = trim($parts[3]);

    //             DB::table('mahasiswas')->insert([
    //                 'nim' => $nim,
    //                 'nama' => $nama,
    //                 'angkatan' => $angkatan,
    //                 'kode_doswal' => $doswal
    //             ]);
    //             DB::table('accounts')->insert([
    //                 'nim_nip' => $nim
    //             ]);
    //         }else{
    //             File::delete('file_batch_mhs/'.$nama_file);
    //             return redirect('/entry')->with(['error_file' => 'Terdapat Penulisan Salah']);
    //         }
    //     }
    //     File::delete('file_batch_mhs/'.$nama_file);
    //     return redirect('/entry')->with(['sukses' => 'Data berhasil ditambahkan']);
    // }
}
?>