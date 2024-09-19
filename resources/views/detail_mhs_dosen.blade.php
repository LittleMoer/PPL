@extends('main_dosen')
<style>
    *{
        margin: 0;
        padding: 0;
    }
    .judul_page{
        text-align: center;
    }
    .container-info{
        margin-top: 50px;
    }
    .container-info1{
        font-size: 17px;
        margin-top: 10px;
        display: flex;
        width: 450px;
        /* background-color: lightpink; */
        text-align: center;
        /* justify-content: space-between; */
    }
    .info{
        display: flex;
        justify-content: space-between;
        /* background-color: lightblue; */
        width: 150px;
        font-size: 15px;
    }
    .container-info1 span{
        margin-left: 20px;
    }
    .container-smt{
        display: flex;
        flex-wrap: wrap;
        /* margin-top: 30px; */
        width: 900px;
        height: 300px;
        /* background-color: lawngreen; */
        align-items: center;
    }
    .smt:hover{
        background-color: rgb(196, 196, 196);
        transition: .4s;
    }
    .judul-smt{
        padding-left: 20px;
        margin-top: 20px;
    }
    .info-smt{
        border: 2px dashed black;
        box-shadow: 2px 2px black;
        margin-top: 30px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        padding-top: 20px;
    }
    .info-smt h3{
        text-align: center;
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

    .container-info-warna{
        align-items: center;
        margin-top: 10px;
        padding-left: 20px;
        width: 500px;
        display: flex;
    }
    .info-warna{
        margin-left: 20px;
    }
    .container1-info-warna{
        align-items: center;
        width: 100px;
        display: flex;
        justify-content: space-between;
    }
    #kotak-hijau{
        width: 50px;
        height: 50px;
        background-color: rgb(49, 215, 49);
    }
    #kotak-kuning{
        width: 50px;
        height: 50px;
        background-color: rgb(243, 243, 59);
    }
    #kotak-biru{
        width: 50px;
        height: 50px;
        background-color: rgb(91, 91, 224);
    }
    #kotak-oren{
        width: 50px;
        height: 50px;
        background-color: rgb(255, 136, 0);
    }
    #kotak-merah{
        width: 50px;
        height: 50px;
        background-color: rgb(246, 47, 47);
    }
</style>
@section('main')
<div class="judul_page">
    <h2>Progress Perkembangan Studi Mahasiswa Informatika <br>Fakultas Sains dan Matematika UNDIP Semarang</h2>
</div>
<div class="container-info">
    <div class="container-info1"><div class="info">Nama <span>:</span></div><span>{{ $mhs->nama }}</span></div>
    <div class="container-info1"><div class="info">NIM <span>:</span></div><span>{{ $mhs->nim }}</span></div>
    <div class="container-info1"><div class="info">Angkatan <span>:</span></div><span>{{ $mhs->angkatan }}</span></div>
    <div class="container-info1"><div class="info">Wali <span>:</span></div><span>{{ $mhs->dosen }}</span></div>
</div>
<div class="judul-smt">
    <h2>Semester</h2>
</div>
<div class="container-smt">
    <a class="{{ $smt1 }}" href="/smt_1">1</a>
    <a class="{{ $smt2 }}" href="/smt_2">2</a>
    <a class="{{ $smt3 }}" href="/smt_3">3</a>
    <a class="{{ $smt4 }}" href="/smt_4">4</a>
    <a class="{{ $smt5 }}" href="/smt_5">5</a>
    <a class="{{ $smt6 }}" href="/smt_6">6</a>
    <a class="{{ $smt7 }}" href="/smt_7">7</a>
    <a class="{{ $smt8 }}" href="/smt_8">8</a>
    <a class="{{ $smt9 }}" href="/smt_9">9</a>
    <a class="{{ $smt10 }}" href="/smt_10">10</a>
    <a class="{{ $smt11 }}" href="/smt_11">11</a>
    <a class="{{ $smt12 }}" href="/smt_12">12</a>
    <a class="{{ $smt13 }}" href="/smt_13">13</a>
    <a class="{{ $smt14 }}" href="/smt_14">14</a>
</div>

<div class="info-smt">
    <h3>Keterangan</h3>
    <div class="container-info-warna"><div class="container1-info-warna"><div id="kotak-hijau"></div><span>:</span></div><span class="info-warna">IRS & KHS verified, Lulus PKL</span></div>
    <div class="container-info-warna"><div class="container1-info-warna"><div id="kotak-kuning"></div><span>:</span></div><span class="info-warna">IRS & KHS verified, Lulus Skripsi</span></div>
    <div class="container-info-warna"><div class="container1-info-warna"><div id="kotak-biru"></div><span>:</span></div><span class="info-warna">IRS & KHS verified</span></div>
    <div class="container-info-warna"><div class="container1-info-warna"><div id="kotak-oren"></div><span>:</span></div><span class="info-warna">IRS verified</span></div>
    <div class="container-info-warna"><div class="container1-info-warna"><div id="kotak-merah"></div><span>:</span></div><span class="info-warna">Belum mengisi iRS & KHS atau tidak digunakan</span></div>
</div>
@endsection
