@extends('main_departement')
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="tabel/https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

<link rel="stylesheet" href="tabel/fonts/icomoon/style.css">

<link rel="stylesheet" href="tabel/css/owl.carousel.min.css">

<!-- Bootstrap CSS -->
{{-- <link rel="stylesheet" href="tabel/css/bootstrap.min.css"> --}}

<!-- Style -->
<link rel="stylesheet" href="tabel/css/style.css">
<style>
    .link-menu{
        text-decoration: none;
        color: rgb(83, 83, 160);
    }
    .link-menu:hover{
      color: rgb(48, 48, 203);
      text-decoration: underline;
      transition: .3s;
    }
    .tr-1 th:hover{
      background-color: rgb(169, 167, 228);
      display: block;
      transition: .3s;
      border-radius: 20px;
    }

    .table-menu-atas{
      overflow: auto;
      margin-top: 50px;
      text-align: center;
      width: 1050px;

    }
    .tr-1{
      border-bottom: 1px solid black;
    }
    .tr-1 th{
        
      padding-top: 10px;
      padding-bottom: 10px;
      border-bottom: 1px solid black;
    }
</style>
@section('main')
<div class="judul_page">
    <h2>Data Mahasiswa</h2>
</div>
<div class="menu_nav">
    <div class="container-tabel-menu-atas">
      <table class="table-menu-atas" cellspacing="10">
        <thead>
          <tr class="tr-1">
            <th scope=""><a class="link-menu" href="/data/mahasiswa">Data Mahasiswa</a></th>
            <th scope=""><a class="link-menu" href="/rekap/pkl&skripsi">Rekap PKL & Skripsi</a></th>
          </tr>
        </thead>
      </table>
    </div>
</div>
  <div class="content">
      <div class="container">
        <div class="table-responsive">
          {{-- <table class="table custom-table">
            <thead>
              <tr>
                <th scope="col">Nama</th>
                <th scope="col">Nim</th>
                <th scope="col">Semester</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($mhs as $item)
                  <tr class="data">
                      <td >{{ $item->nama }}</td>
                      <td >{{ $item->nim }}</td>
                      <td >{{ $item->smt }}</td>
                      <td >{{ $item->status_mhs }}</td>
                  </tr>
              @endforeach
            </tbody>
          </table> --}}
        </div>
      </div>
    </div>
@endsection