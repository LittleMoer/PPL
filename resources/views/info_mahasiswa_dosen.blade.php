@extends('main_dosen')
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
        font-weight: bold;
        margin-top: 50px;
        /* background-color: red; */
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
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
    .judul_pencarian{
        margin-top: 30px;
        font-size: 20px;
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
    .judul_hasil{
        text-decoration: underline;
        margin-top: 15px
    }
    .nama_hasil p{
        color: rgb(0, 0, 0);

        margin-top: 4px;
    }
    .nama_hasil1{
        display: inline-block;
        font-size: 20px;
        text-decoration: none;
        margin-top: 10px;
        color: rgb(0, 0, 0);
    }
    .nama_hasil1:hover{
        text-decoration: underline;
        color: rgb(24, 24, 24);
        font-weight: bold;
        transition: .3s;
    }
    .container_hasil{
        /* background-color: lightblue; */
        height: 500px;
        overflow: auto;
        margin-top: 10px;
        /* padding-left: 10px; */
    }
    .pemisah{
        margin-top: 10px;
        width: 1040px;
    }
    .wadah-hasil{
        margin-top: 20px;
        /* background-color: rgb(117, 117, 208); */
        border: 2px dashed black;
        border-radius: 10px;
        /* width: 600px; */
        text-align: center;
        padding-top: 5px;
        padding-bottom: 15px;
        padding-left: 20px;
    }
    .wadah-hasil:hover{
        transition: .4s;
        background-color: rgb(187, 187, 187);
    }
    .select-semester{
        margin-top: 20px;

    }
    #semester{
        border-radius: 10px;
        padding-top: 5px;
        padding-bottom: 5px;
        text-align: center;
        margin-left: 50px;
        width: 200px;
    }
    .form-input{
        text-align: center;
        margin-top: 50px;
        /* display: flex;
        flex-direction: wrap; */
    }
</style>
@section('main')
<div class="judul_page">
    <h3>Dashboard | Home</h3>
</div>
<div id="judul-profile"><h2>Dashboard Dosen</h2></div>

<div class="cont-jml-mhs">
    <div class="jml_mhs">{{ $jml_mhs }}<br> Mahasiswa</div>
    <div class="jml_mhs">{{ $jml_pkl }}<br> Lulus PKL</div>
    <div class="jml_mhs">{{ $jml_skripsi }}<br> Lulus Skripsi</div>
</div>
<form action="/submit_info_mhs" method="GET">
    <div class="form-input">
        <div class="form-row">
            <input type="text" name="mhs" class="mhs" id="mhs" placeholder="Masukkan NIM or Nama" >
        </div>
        {{-- <div class="select-semester" required>
            <select name="semester" id="semester">
                <option value="">Semester</option>
                <option value="1">Semester 1</option>
                <option value="2">Semester 2</option>
                <option value="3">Semester 3</option>
                <option value="4">Semester 4</option>
                <option value="5">Semester 5</option>
                <option value="6">Semester 6</option>
                <option value="7">Semester 7</option>
                <option value="8">Semester 8</option>
                <option value="9">Semester 9</option>
                <option value="10">Semester 10</option>
                <option value="11">Semester 11</option>
                <option value="12">Semester 12</option>
                <option value="13">Semester 13</option>
                <option value="14">Semester 14</option>
            </select>
        </div> --}}
    </div>
</form>
<div class="container_hasil">
    @foreach ($mhs as $item)
        <div class="wadah-hasil">
            <div class="judul_hasil">
                <h4 class="judul_hasil1">Mahasiswa</h4>
            </div>
            <div class="nama_hasil">
                <a href={{ route('detail_mhs_dosen',['mhs' => urlencode($item->nim)]) }} class="nama_hasil1">{{ $item->nama }}</a>
            </div>
            <div class="nama_hasil">
                <p>{{ $item->nim }}</p>
            </div>
            <hr class="pemisah">
        </div>
    @endforeach
</div>
<script>
    document.getElementById("mhs").addEventListener("keyup", function(event) {
        // Check if the Enter key is pressed (key code 13)
        if (event.keyCode === 13) {
            // Submit the form
            document.querySelector("form").submit();
        }
    });
</script>
@endsection