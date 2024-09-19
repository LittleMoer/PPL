@extends('main_mahasiswa')
<style>
    .konten1{
        margin-top: 20px;
        align-items: center;
        /* background-color: red; */
        display: flex;
        justify-content: space-between;
    }
    .container-bio{
        /* font-weight: bold; */
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
    .judul-profile{
        text-align: center;
        margin-top: 30px;
    }
    .container-smt{
        display: flex;
        flex-wrap: wrap;
        /* margin-top: 30px; */
        width: 1000px;
        height: 300px;
        /* background-color: lawngreen; */
        align-items: center;
        margin: auto;
    }
    .main1{
        background-color: rgb(239, 239, 239);
        /* position: fixed; */
        border-radius: 20px;
        box-shadow: 0px 2px 5px 0px black;
        -o-box-shadow: 0px 2px 5px 0px black;
        -ms-box-shadow: 0px 2px 5px 0px black;
        -moz-box-shadow: 0px 2px 5px 0px black;
        -webkit-box-shadow: 0px 2px 5px 0px black;
        overflow: auto;
        width: 1050px;
    }
    .merah{
        display: block;
        text-align: center;
        background-color: rgb(246, 47, 47);
        margin-left: 20px;
        margin-right: 20px;
        width: 100px;
        padding-top: 25px;
        height: 50px;
        text-decoration: none;
        color: black;
        font-weight: bold;
        box-shadow: 5px 5px rgb(0, 0, 0,.4);
    }
    .oren{
        display: block;
        text-align: center;
        background-color: rgb(255, 136, 0);
        margin-left: 20px;
        margin-right: 20px;
        width: 100px;
        padding-top: 25px;
        height: 50px;
        text-decoration: none;
        color: black;
        font-weight: bold;
        box-shadow: 5px 5px rgb(0, 0, 0,.4);

    }
    .biru{
        display: block;
        text-align: center;
        background-color: rgb(91, 91, 224);
        margin-left: 20px;
        margin-right: 20px;
        width: 100px;
        padding-top: 25px;
        height: 50px;
        text-decoration: none;
        color: black;
        font-weight: bold;
        box-shadow: 5px 5px rgb(0, 0, 0,.4);

    }
    .kuning{
        display: block;
        text-align: center;
        background-color: rgb(243, 243, 59);
        margin-left: 20px;
        margin-right: 20px;
        width: 100px;
        padding-top: 25px;
        height: 50px;
        text-decoration: none;
        color: black;
        font-weight: bold;
        box-shadow: 5px 5px rgb(0, 0, 0,.4);

    }
    .hijau{
        display: block;
        text-align: center;
        background-color: rgb(49, 215, 49);
        margin-left: 20px;
        margin-right: 20px;
        width: 100px;
        padding-top: 25px;
        height: 50px;
        text-decoration: none;
        color: black;
        font-weight: bold;
        box-shadow: 5px 5px rgb(0, 0, 0,.4);

    }
    .merah:hover,
    .oren:hover,
    .biru:hover,
    .kuning:hover,
    .hijau:hover {
    transition: .5s;
    box-shadow: 5px 5px black;
    color: white;
    background-color: rgb(52, 52, 52);
    }
</style>
@section('main')
<div class="judul_page">
    <h3>Dashboard / Profile</h3>
</div>
<div class="judul-profile"><h2>Profile Mahasiswa</h2></div>

<div class="konten1">
    <div class="container-bio">
        <div class="container-info-bio">
            <div class="container1-info-bio">
                <div id="nama">Nama</div>
                <span>:</span>
            </div>
            <span class="info-bio">{{ $mhs->nama }}</span>
        </div>
        <div class="container-info-bio"><div class="container1-info-bio"><div id="nim">NIM</div><span>:</span></div><span class="info-bio">{{ $mhs->nim }}</span></div>
        <div class="container-info-bio"><div class="container1-info-bio"><div id="angkatan">angkatan</div><span>:</span></div><span class="info-bio">{{ $mhs->angkatan }}</span></div>
        <div class="container-info-bio"><div class="container1-info-bio"><div id="email">Email</div><span>:</span></div><span class="info-bio">{{ $mhs->email }}</span></div>
        <div class="container-info-bio"><div class="container1-info-bio"><div id="provinsi">Provinsi</div><span>:</span></div><span class="info-bio">{{ $mhs->prov }}</span></div>
        <div class="container-info-bio"><div class="container1-info-bio"><div id="kab_kota">Kab/Kota</div><span>:</span></div><span class="info-bio">{{ $mhs->kota }}</span></div>
        <div class="container-info-bio"><div class="container1-info-bio"><div id="alamat">Alamat</div><span>:</span></div><span class="info-bio">{{ $mhs->alamat }}</span></div>
        <div class="container-info-bio"><div class="container1-info-bio"><div id="no_hp">No telp</div><span>:</span></div><span class="info-bio">{{ $mhs->no_hp }}</span></div>
        <div class="container-info-bio"><div class="container1-info-bio"><div id="jalur_masuk">Jalur Masuk</div><span>:</span></div><span class="info-bio">{{ $mhs->jalur_masuk }}</span></div>
        <div class="container-info-bio"><div class="container1-info-bio"><div id="kode_doswal">Dosen Wali</div><span>:</span></div><span class="info-bio">{{ $mhs->dosen }}</span></div>
    </div>
    <div class="container-foto"><img id="foto-profile" src="{{ asset($mhs->foto) }}" alt="Profile" width="400px" height="400px" style="border-radius: 100%;"></div>
</div>
@endsection
@section('main1')
<div class="judul-profile"><h2>Semester</h2></div>
<div class="container-smt">
    <a class="{{ $smt1 }}" href= {{ route('smt_mhs', ['smt'=>1]) }}>1</a>
    <a class="{{ $smt2 }}" href={{ route('smt_mhs', ['smt'=>2]) }}>2</a>
    <a class="{{ $smt3 }}" href={{ route('smt_mhs', ['smt'=>3]) }}>3</a>
    <a class="{{ $smt4 }}" href={{ route('smt_mhs', ['smt'=>4]) }}>4</a>
    <a class="{{ $smt5 }}" href={{ route('smt_mhs', ['smt'=>5]) }}>5</a>
    <a class="{{ $smt6 }}" href={{ route('smt_mhs', ['smt'=>6]) }}>6</a>
    <a class="{{ $smt7 }}" href={{ route('smt_mhs', ['smt'=>7]) }}>7</a>
    <a class="{{ $smt8 }}" href={{ route('smt_mhs', ['smt'=>8]) }}>8</a>
    <a class="{{ $smt9 }}" href={{ route('smt_mhs', ['smt'=>9]) }}>9</a>
    <a class="{{ $smt10 }}" href={{ route('smt_mhs', ['smt'=>10]) }}>10</a>
    <a class="{{ $smt11 }}" href={{ route('smt_mhs', ['smt'=>11]) }}>11</a>
    <a class="{{ $smt12 }}" href={{ route('smt_mhs', ['smt'=>12]) }}>12</a>
    <a class="{{ $smt13 }}" href={{ route('smt_mhs', ['smt'=>13]) }}>13</a>
    <a class="{{ $smt14 }}" href={{ route('smt_mhs', ['smt'=>14]) }}>14</a>
</div>
@endsection