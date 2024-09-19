@extends('main_departement')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('tabel/fonts/icomoon/style.css') }}">

<link rel="stylesheet" href="{{ asset('tabel/css/owl.carousel.min.css') }}">

<!-- Bootstrap CSS -->
{{-- <link rel="stylesheet" href="tabel/css/bootstrap.min.css"> --}}

<!-- Style -->
<link rel="stylesheet" href="{{ asset('tabel/css/style.css') }}">
<style>
    .cont_btn{
        text-align: center;
        margin-top: 40px;

    }
    .btn_rekap{
        cursor: pointer;
        padding-top: 5px;
        padding-bottom: 5px;
        border-radius: 20px;
        background-color: rgb(89, 236, 89);
        width: 300px;
        margin-right: 50px;
        
    }
</style>
@section('main')
<div class="judul_page">
    <h3><a href="/rekap/pkl&skripsi">Rekap Skripsi</a> / Lulus</h3>
</div>
<div class="content">
    <div class="container">
      <div class="table-responsive">
        <table class="table custom-table" id="tabel_skripsi">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama</th>
              <th scope="col">Nim</th>
              <th scope="col">Semester</th>
              <th scope="col">Nilai</th>
              <th scope="col">File</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($skripsi as $item)
                <tr class="data">
                    <td>{{ $loop->iteration }}</td>
                    <td >{{ $item->nama }}</td>
                    <td >{{ $item->nim }}</td>
                    <td >{{ $item->semester }}</td>
                    <td >{{ $item->nilai_skripsi }}</td>
                    <td ><a href="{{ asset('dokumen_ppl_projek/skripsi/' . $item->scan_skripsi) }}" target="_blank" id="download">Lihat File</a></td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="cont_btn">
    <input type="button" class="btn_rekap" id="cetak_skripsi" value="Cetak" onclick="cetak('tabel_skripsi')">
  </div>
  <script>
    function cetak(tabelId) {
        var cetakdata = document.getElementById(tabelId);
        if (cetakdata) {
            var newWin = window.open('', '_blank');
            newWin.document.write('<html><head><title>Cetak</title>');
            newWin.document.write('<style>');
            newWin.document.write('th { text-align: center; border-bottom: 1px solid black; margin-bottom: 30px;}');
            newWin.document.write('td { text-align: left; padding: 10px 15px 10px 15px;}');
            newWin.document.write('</style>');
            newWin.document.write('<h3 style="margin-bottom:20px;">Informasi Mahasiswa Lulus Skripsi</h3>');
            newWin.document.write('</head><body>');
            newWin.document.write(cetakdata.outerHTML);
            newWin.document.write('</body></html>');
            newWin.print();
            newWin.close();
        } else {
            alert("Tabel tidak ditemukan!");
        }
    }
</script>
@endsection