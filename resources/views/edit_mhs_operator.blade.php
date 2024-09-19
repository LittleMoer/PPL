@extends('main_operator')
<title>EDIT | MAHASISWA</title>

@section('main')
    <style>
        #angkatan{
            border-radius: 10px;
            padding-top: 5px;
            padding-bottom: 5px;
            text-align: center;
            margin-left: 30px;
            width: 300px;
        }
        #status{
            border-radius: 10px;
            margin-left: 50px;
            padding-top: 5px;
            padding-bottom: 5px;
            text-align: center;
            width: 300px;
        }
        #dosen_wali{
            border-radius: 10px;
            margin-left: 20px;
            padding-top: 5px;
            padding-bottom: 5px;
            text-align: center;
            width: 300px;
        }
        /* .container-irs{
            border-radius: 10px;
            overflow: auto;
            margin-top: 20px;
            height: 350px;
            background-color: rgb(205, 205, 205);
        } */
        .container-btn{
            display: flex;
        }
        .btn{
            text-align: center;
            border-radius: 15px;
            padding: 10px;
            margin-top: 50px;
            display: inline-block;
            width: 250px;
            background-color: rgb(192, 192, 192);
            text-decoration: none;
            color: black;
        }
        #btn-2{
            margin-left: 20px;
        }
        .form-row{
            /* display: flex; */
            margin-top: 50px;
            /* align-items: center; */
        }
        #nim{
            margin-top: 10px;
            margin-left: 65px;
            text-align: center;
            /* border-radius: 10px; */
            border: 0px solid rgb(182, 182, 182);
            border-bottom: 2px solid rgb(182, 182, 182);
            padding: 5px;
            width: 300px;
        }
        #nim:focus{
            outline: none;
            box-shadow: 0px 2px 0px 0px black;
            
        }
        #nama{
            margin-top: 10px;
            margin-left: 60px;
            text-align: center;
            /* border-radius: 10px; */
            border: 0px solid rgb(182, 182, 182);
            border-bottom: 2px solid rgb(182, 182, 182);
            padding: 5px;
            width: 300px;
        }
        #nama:focus{
            outline: none;
            box-shadow: 0px 2px 0px 0px black;
        }
        .pemisah-input{
            margin-top: 15px;
            width: 550px;
        }
        #btn-submit:hover {
        color: white;
        background-color: rgb(86, 86, 86);
        transition: .5s;
        }
        #gambar-download{
            cursor: pointer;
        }
        .btn-action2{
            background-color: rgb(244, 70, 70);
            text-align: center;
            display: inline-block;
            width: 100px;
            margin-top: 50px;
            margin-left: 50px;
            color: black;
            border-radius: 10px;
            text-decoration: none;
            padding: 10px;
        }
        .btn-action2:hover{
            background-color: rgb(255, 7, 7);
            color: white;
            transition: .7s;
        }

    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var select = document.getElementById("angkatan");
            var currentYear = new Date().getFullYear();
            for (var i = currentYear - 7; i <= currentYear + 7; i++) {
                var option = document.createElement("option");
                option.value = i;
                option.text = i;
                select.appendChild(option);
            }
        });
    </script>
    <div class="judul_page">
        <h3><a href="/data/mhs" style="text-decoration: none;">DATA MAHASISWA</a> / EDIT</h3>
    </div>
    <form action="/confirmEditMhs" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <label id="label-nama" for="nama">Nama : </label>
            <input type="text" name="nama" class="nama" id="nama"  value="{{ $mhs->nama }}" disabled>
        </div>
        <div class="form-row">
            <label id="label-nim" for="nim">NIM : </label>
            <input type="number" name="nim" class="nim" id="nim"  value="{{ $mhs->nim }}" readonly>
        </div>
        <div class="form-row">
            <label id="label-angkatan" for="angkatan">Angkatan : </label>
            <select name="angkatan" id="angkatan" required>
                <option value="">Angkatan</option>
            </select>
        </div>
        <div class="form-row">
            <label id="label-dosen_wali" for="dosen_wali">Dosen Wali : </label>
            <select name="dosen_wali" id="dosen_wali" required>
                <option value="">Dosen Wali</option>
                @foreach ($doswal as $item)
                    <option value="{{ $item->nip }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-row">
            <label id="label-status" for="status">Status : </label>
            <select name="status" id="status" required>
                <option value="">status</option>
                <option value="1">Aktif</option>
                <option value="2">Cuti</option>
                <option value="3">Mangkir</option>
                <option value="4">DO</option>
                <option value="5">Mengundurkan Diri</option>
                <option value="6">Lulus</option>
                <option value="7">Meninggal</option>
            </select>
        </div>
        <div class="container-btn">
            <div class="wadah-btn"><input type="submit" id="btn-submit" class="btn" value="Edit"></div>
        </div>
    </form>
@endsection