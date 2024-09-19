@extends('main_departement')
<style>
    .konten1{
        margin-top: 20px;
        align-items: center;
        /* background-color: red; */
        display: flex;
        justify-content: space-between;
    }
    .container-bio{
        font-weight: bold;
    }
    .container-info-bio{
        display: flex;
        /* justify-content: space-between; */
    }
    .container-info-bio:not(:first-child){
        margin-top: 20px;
    }
    .container1-info-bio{
        width: 100px;
        display: flex;
        justify-content: space-between;
    }
    .info-bio{
        margin-left: 20px;
    }
    .cont-jml-mhs{
        margin-top: 50px;
        /* background-color: red; */
        width: 500px;
        display: flex;
        flex-wrap: wrap;
    }
    .jml_mhs{
        text-align: center;
        display: inline-block;
        width: 100px;
        /* height: 100px; */
        padding: 35px 20px 35px 20px;
        border-radius: 10px;
        border: 2px solid black;
        box-shadow: 0px 5px 20px 0px black;
        -o-box-shadow: 0px 5px 20px 0px black;
        -ms-box-shadow: 0px 5px 20px 0px black;
        -moz-box-shadow: 0px 5px 20px 0px black;
        -webkit-box-shadow: 0px 5px 20px 0px black;
    }
    .jml_mhs:not(:first-child){
        margin-left: 20px;
    }
    #judul-profile{
        text-align: center;
        margin-top: 30px;
    }
</style>
@section('main')
<div class="judul_page">
    <h3>Dashboard / Profile </h3>
</div>
<div id="judul-profile"><h2>Profile Departemen</h2></div>

<div class="konten1">
    <div class="container-bio">
        <div class="container-info-bio">
            <div class="container1-info-bio">
                <div id="nama">Nama</div>
                <span>:</span>
            </div>
            <span class="info-bio">{{ $data->nama }}</span>
        </div>
        {{-- <div class="container-info-bio"><div class="container1-info-bio"><div id="nip">NIP</div><span>:</span></div><span class="info-bio">{{ $data->nip }}</span></div> --}}
        <div class="container-info-bio"><div class="container1-info-bio"><div id="email">Email</div><span>:</span></div><span class="info-bio">{{ $data->email }}</span></div>
        {{-- <div class="cont-jml-mhs">
            <div class="jml_mhs">{{ $jml_mhs }}<br> Mahasiswa</div>
            <div class="jml_mhs">{{ $jml_pkl }}<br> Lulus PKL</div>
            <div class="jml_mhs">{{ $jml_skripsi }}<br> Lulus Skripsi</div>
        </div> --}}
    </div>
    <div class="container-foto"><img id="foto-profile" src="{{ asset('icon-profile2.png') }}" alt="" width="400px" height="400px"></div>
</div>
@endsection