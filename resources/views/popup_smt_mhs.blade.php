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
    .smt{
        display: block;
        text-align: center;
        background-color: lightcoral;
        margin-left: 20px;
        margin-right: 20px;
        width: 100px;
        padding-top: 25px;
        height: 50px;
        text-decoration: none;
        color: black;
    }
    /* POP UP */
    .container-popup{
        /* display: none; */
        position: fixed;
        width: 100%;
        background-color: rgb(0, 0, 0,0.8);
        height: 100vh;
        z-index: 1;
        text-align: center;
    }
    .popup-konten{
        text-align: center;
        margin-top: 200px;
    }
    .judul-menu{
        text-decoration: none;
        color: black;
        margin-left: 10px;
        padding-top: 25px;
        border-radius: 30px;
        width: 100px;
        height: 50px;
        display: inline-block;
        margin-top: 20px;
        background-color: white;
    }
    .main-konten{
        box-shadow: 8px 8px black;
        text-align: left;
        border-radius: 20px;
        display: inline-block;
        background-color: grey;
        width: 400px;
        height: 250px;
    }
    .khs{
        display: none;
        margin-top: 30px;
        padding-left: 15px;
    }
    .container-gtw1{
        align-items: center;
        display: flex;
    }
    .container-gtw{
        align-items: center;

        display: flex;
        justify-content: space-between;
        width: 150px;
    }
    .khs-popup:not(:first-child){
        margin-top: 15px;
    }
    .info-popup{
        display: inline-block;
        margin-left: 30px;
        /* margin-top: 10px; */
    }
    .download-file{
        text-align: center;
    }
    .download-file a{
        text-decoration: none;
        border-radius: 30px;
        text-align: center;
        display: inline-block;
        width: 150px;
        background-color: rgb(195, 195, 195);
        margin-top: 10px;
        /* margin-top: 40px; */
        padding-top: 10px;
        padding-bottom: 10px;
        color: black;
    }
    .download-file a:hover{
        color: white;
        transition: .3s;
        background-color: rgb(52, 52, 52);
    }
    #file-khs{
        display: none;
    }
    #file-irs{
        /* display: none; */
    }
    .irs{
        display: flex;
        /* display: none; */
        margin-top: 20px;
        margin-left: 40px;
    }
    .sks-irs{
        font-size: 30px;
        width: 120px;
        height: 120px;
        text-align: center;
        border-radius: 100%;
        border: 3px dashed black;
        background-color: rgb(255, 255, 255);
    }
    .sks-irs p{
        margin-top: 40px;
    }
    .list-popup a{
        border: 3px dashed black;
        padding-top: 5px;
        border-radius: 20px;
        display: inline-block;
        width: 150px;
        height: 30px;
        background-color: grey;
        text-decoration: none;
        color: black;
    }
    .list-popup a:hover{
        transition: .3s;
        background-color: rgb(196, 196, 196);
    }
    .judul-irs{
        margin-left: 40px;
        margin-bottom: 10px;
    }
    .irs-konten-2{
        margin-left: 70px;
    }
    #judul-irs-smt{
        margin-left: 30px;
        margin-bottom: 13px;
    }
    .pemisah{
        margin-top: 10px;
    }
    .judul-smt{
        padding-left: 20px;
        margin-top: 20px;
    }
    .info-smt{
        border: 2px solid black;
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
    transition: .3s;
    box-shadow: 5px 5px black;
    background-color: rgb(255, 124, 124);
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
<div class="container-popup">
    <div class="popup-konten">
        <div class="list-popup">
            <a href=""  class="irs-list" id="btn-irs">IRS</a>
            <a href=""  class="khs-list" id="btn-khs">KHS</a>
        </div>
        <div class="main-konten">
            <div class="irs">
                <div class="irs-konten-1">
                    <div class="judul-irs"><h4>SKS</h4></div>
                    <div class="sks-irs"><p>@if ($irs != null)
                        {{ $irs->sks }}
                    @else
                        -
                    @endif</p></div>
                </div>
                <div class="irs-konten-2">
                    <div class="judul-irs" id="judul-irs-smt"><h4>Semester</h4></div>
                    <div class="sks-irs"><p>@if ($irs != null)
                        {{ $irs->smt }}
                    @else
                        -
                    @endif</p></div>
                </div>
            </div>
            <div class="khs">
                <div class="container-gtw1"><div class="container-gtw"><div class="khs-popup">SKS Semester </div><span>:</span></div><span class="info-popup">
                    @if ($khs != null)
                        {{ $khs->sks }}
                    @else
                        -
                    @endif</span></div>
                <hr class="pemisah">
                <div class="container-gtw1"><div class="container-gtw"><div class="khs-popup">IP Semester </div><span>:</span></div><span class="info-popup">
                    @if ($khs != null)
                        {{ $khs->smt }}
                    @else
                        -
                    @endif</span></div>
                <hr class="pemisah">

                <div class="container-gtw1"><div class="container-gtw"><div class="khs-popup">SKS Kumulatif </div><span>:</span></div><span class="info-popup">
                    @if ($khs != null)
                        {{ $khs->sks_kumulatif }}
                    @else
                        -
                    @endif</span></div>
                <hr class="pemisah">
                <div class="container-gtw1"><div class="container-gtw"><div class="khs-popup">IP Kumulatif </div><span>:</span></div><span class="info-popup"></span>
                    @if ($khs != null)
                        {{ $khs->ipk }}
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="download-file">
                <a href="@if ($irs != null)
                    dokumen_ppl_projek/irs/{{ $irs->scan_irs }}
            @else
                
            @endif"  id="file-irs">Lihat IRS</a>
                <a href="@if ($khs != null)
                     dokumen_ppl_projek/khs/{{ $khs->scan_khs }}
        @else
            
        @endif"  id="file-khs">Lihat KHS</a>
                
                <a href="/close" id="close">Close</a>
            </div>
        </div>
    </div>
</div>
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
    <div class="container-info-warna"><div class="container1-info-warna"><div id="kotak-kuning"></div><span>:</span></div><span class="info-warna">Lulus Skripsi</span></div>
    <div class="container-info-warna"><div class="container1-info-warna"><div id="kotak-biru"></div><span>:</span></div><span class="info-warna">IRS & KHS verified</span></div>
    <div class="container-info-warna"><div class="container1-info-warna"><div id="kotak-oren"></div><span>:</span></div><span class="info-warna">IRS verified</span></div>
    <div class="container-info-warna"><div class="container1-info-warna"><div id="kotak-merah"></div><span>:</span></div><span class="info-warna">Belum mengisi iRS & KHS atau tidak digunakan</span></div>
</div>
<script>
    document.getElementById('btn-irs').addEventListener("click", function(event){
        event.preventDefault(); // Prevent the default behavior of the link
        var irs = document.getElementsByClassName('irs')[0];
        var khs = document.getElementsByClassName('khs')[0];
        var cont_file = document.getElementsByClassName('download-file')[0];
        var file_irs = document.getElementById('file-irs');
        var file_khs = document.getElementById('file-khs');
  
        irs.style.display = 'flex';
        khs.style.display = 'none';
        file_irs.style.marginTop = '20px';
        file_irs.style.display = 'inline-block';
        file_khs.style.display = 'none';
    });

    document.getElementById('btn-khs').addEventListener("click", function(event){
        event.preventDefault(); // Prevent the default behavior of the link
        var irs = document.getElementsByClassName('irs')[0];
        var khs = document.getElementsByClassName('khs')[0];
        var khs_popup = document.getElementsByClassName('khs-popup');
        var info_popup = document.getElementsByClassName('info-popup');
        var cont_file = document.getElementsByClassName('download-file')[0];
        var file_irs = document.getElementById('file-irs');
        var file_khs = document.getElementById('file-khs');
  
        for(var i = 1; i< khs_popup.length;i++){
            var element = khs_popup[i];
            element.style.marginTop = '10px';
        }
        // for(var i = 1; i< info_popup.length;i++){
        //     var element1 = info_popup[i];
        //     element1.style.marginTop = '10px';

        // }
        irs.style.display = 'none';
        khs.style.display = 'inline-block';
        khs.style.marginLeft = '30px';
        file_khs.style.marginTop = '10px';
        file_irs.style.display = 'none';
        file_khs.style.display = 'inline-block';
    });
</script>


@endsection
