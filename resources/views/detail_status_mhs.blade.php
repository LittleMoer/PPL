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
@section('main')
<style>
  .content{
    margin-left: 90px;
  }
</style>
<div class="judul_page">
    <h3><a href="/statistik/mhs">Status</a> / Mahasiswa</h3>
</div>
<div class="content">
    <div class="container">
      <div class="table-responsive">
        <table class="table custom-table">
          <thead>
            <tr>
              <th scope="col">Nama</th>
              <th scope="col">Nim</th>
              <th scope="col">Angkatan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($mhs as $item)
                <tr class="data">
                    <td >{{ $item->nama }}</td>
                    <td >{{ $item->nim }}</td>
                    <td >{{ $item->angkatan }}</td>
                </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </div>
@endsection