@extends('main_operator')
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="tabel/https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

<link rel="stylesheet" href="tabel/fonts/icomoon/style.css">

<link rel="stylesheet" href="tabel/css/owl.carousel.min.css">

<!-- Bootstrap CSS -->
{{-- <link rel="stylesheet" href="tabel/css/bootstrap.min.css"> --}}

<!-- Style -->
<link rel="stylesheet" href={{ asset('tabel/css/style.css') }}>
<style>
    .data{
        /* display: block; */
    }
    #download{
        background-color: rgb(161, 164, 161);
        padding: 5px 15px 5px 15px;
        border-radius: 10px;
        color: white;
        text-decoration: none;
    }
    #download:hover{
        background-color: rgb(102, 103, 102);
        color: white;
    }
    .btn-action{
        display: block;
        background-color: grey;
        margin-top: 2px;
        padding: 2px 10px 2px 10px;
        color: white;
        border-radius: 10px;
        font-weight: bold;
    }
    .btn-action:hover{
        transform: .5s;
        background-color: rgb(200, 200, 200);
        color: rgb(69, 69, 69);
    }
    .btn-action1{
        font-weight: bold;
        display: block;
        background-color: red;
        margin-top: 2px;
        padding: 2px 10px 2px 10px;
        color: rgb(0, 0, 0);
        border-radius: 10px;
    }
    .btn-action1:hover{
        transform: .5s;
        background-color: rgb(134, 2, 2);
        color: rgb(69, 69, 69);
    }

    .link-menu{
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
      width: 1000px;

    }
    .tr-1{
      border-bottom: 1px solid black;
    }
    .tr-1 th{
      padding-top: 10px;
      padding-bottom: 10px;
      border-bottom: 1px solid black;
    }
    .flash{
      text-align: center;
      margin-top: 30px;
      font-weight: 700;
      padding-top: 10px;
      padding-bottom: 10px;
      background-color: lightgreen;
    }
    #cont_flash{
        margin-top: 20px;
        margin-bottom: 30px;
        text-align: right;
    }
    #flash{
        display: inline-block;
        width: 200px;
        text-align: center;
        font-weight: 600;
        padding: 15px 15px 15px 15px;
        background-color: rgb(61, 201, 61);
        transition: opacity 0.5s ease-in-out;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        border: 1px solid black;
    }
    #mhs{
        margin-top: 20px;
        /* margin-left: 10px; */
        text-align: center;
        /* border-radius: 10px; */
        /* border: 0px solid rgb(182, 182, 182); */
        /* border-bottom: 2px solid rgb(182, 182, 182); */
        border-radius: 10px;
        padding: 5px;
        width: 500px;
    }
    #mhs:focus{
        outline: none;
        box-shadow: 0px 2px 0px 0px black;
    }
    .cont_mhs{
      margin-top: 15px;
      text-align: center;
    }
</style>
@section('flash')
@if (session('flash_edit'))
    <div id="cont_flash"><div id="flash">{{session('flash_edit')}}</div></div>

    <script>
        var flashElement = document.getElementById("flash");
        function munculkanFlash() {
            flashElement.style.opacity = "1"; // Mengubah opacity menjadi 1
        }

        setTimeout(munculkanFlash, 500);
        function hilangkanFlash() {
            flashElement.style.opacity = "0"; 
            setTimeout(function() {
                flashElement.style.display = "none"; 
            }, 500); 
        }

        setTimeout(hilangkanFlash, 2000); 

    </script>
@elseif (session('flash_delete'))
    <div id="cont_flash"><div id="flash">{{session('flash_delete')}}</div></div>

    <script>
        var flashElement = document.getElementById("flash");
        function munculkanFlash() {
            flashElement.style.opacity = "1"; // Mengubah opacity menjadi 1
        }

        setTimeout(munculkanFlash, 500);
        function hilangkanFlash() {
            flashElement.style.opacity = "0"; 
            setTimeout(function() {
                flashElement.style.display = "none"; 
            }, 500); 
        }

        setTimeout(hilangkanFlash, 2000); 

    </script>
@endif
@endsection
@section('main')
<style>
    .nav-side.logout{
        margin-top: 325px;
    }
    </style>
<div class="judul_page">
    <h3>INFORMASI PERWALIAN / PENYETUJUAN IRS</h3>
</div>
<div class="cont_mhs">
  <form action="/search/mhs" method="POST">
    @csrf
    <input type="text" name="mhs" class="mhs" id="mhs" placeholder="Masukkan NIM or Nama" >
  </form>
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
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($mhs as $item)
                  <tr class="data">
                      <td style="text-align: left;" >{{ $item->nama }}</td>
                      <td >{{ $item->nim }}</td>
                      <td >{{ $item->angkatan }}</td>
                      <td >{{ $item->status_mhs }}</td>
                      <td>
                        <a id="edit" href={{ route('edit_mhs_operator', ['nim' => urlencode($item->nim)]) }} class="btn-action">Edit</a>
                        <a id="delete" href={{ route('delete_mhs_operator', ['nim' => urlencode($item->nim)]) }} class="btn-action1" >Delete</a>
                      </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
  
        </div>
      </div>
    </div>
@endsection