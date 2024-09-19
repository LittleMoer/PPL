@extends('main_dosen')
<title>EDIT | IRS</title>

@section('main')
    <style>
        .select-semester{
            margin-top: 20px;

        }
        #semester{
            border-radius: 10px;
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
            margin-left: 10px;
            text-align: center;
            /* border-radius: 10px; */
            border: 0px solid rgb(182, 182, 182);
            border-bottom: 2px solid rgb(182, 182, 182);
            padding: 5px;
            width: 100px;
        }
        #nim:focus{
            outline: none;
            box-shadow: 0px 2px 0px 0px black;
        }
        #sks{
            margin-top: 10px;
            margin-left: 10px;
            text-align: center;
            /* border-radius: 10px; */
            border: 0px solid rgb(182, 182, 182);
            border-bottom: 2px solid rgb(182, 182, 182);
            padding: 5px;
            width: 100px;
        }
        #sks:focus{
            outline: none;
            box-shadow: 0px 2px 0px 0px black;
        }
        .pemisah-input{
            margin-top: 15px;
            width: 550px;
        }
        #label-file{
            display: block;
        }
        #file_irs::-webkit-file-upload-button{
            display: none;
        }
        /* #file_irs::-webkit-file-upload-button:hover{
            transition: .5s;
            color: white;
            background-color: rgb(154, 154, 154);
        }
        #file_irs::placeholder{
            color: white;
        } */
        #dokumen-upload{
            align-items: center;
            /* justify-content: space-between; */
            display: flex;
        }
        #icon-upload{
            margin-left: 20px;
            margin-top: 10px;
            margin-bottom: 15px;
            cursor: pointer;
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

    <div class="judul_page">
        <h3>INFORMASI PERWALIAN /PENYETUJUAN IRS / EDIT IRS</h3>
    </div>
    <form action="/confirmEditIRS" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <label id="label-nim" for="nim">NIM : </label>
            <input type="number" name="nim" class="nim" id="nim" maxlength="2" value="{{ $dataEdit->nim }}" disabled>
        </div>
        <div class="form-row">
            <label id="label-semester" for="semester">Semester : </label>
            <input type="number" name="semester" class="semester" id="semester" maxlength="2" value="{{ $dataEdit->smt }}" required>
        </div>
        <hr class="pemisah-input">
        <div class="form-row">
            <label id="label-sks" for="sks">SKS : </label>
            <input type="number" name="sks" class="sks" id="sks" maxlength="2" value="{{ $dataEdit->sks }}" required>
        </div>
        <hr class="pemisah-input">

        <div class="form-row" id="dokumen-upload">
            <label id="label-file">Document IRS : </label>
            <div class="container-icon">
                <a  href="{{ asset('dokumen_ppl_projek/irs/'. $dataEdit->scan_irs)}}" id="link_document" target="_blank"><img id="gambar-download" src="{{ asset('gambar/icon-download.png') }}" width="30px" height="30px" alt="download"></a>
            </div>
        </div>
        <hr class="pemisah-input">
        <div class="container-irs">
        </div>
        <div class="container-btn">
            <div class="wadah-btn"><input type="submit" id="btn-submit" class="btn" value="Edit IRS"></div>
            <a id="delete" href={{ route('delete_irs', ['nim' => urlencode($dataEdit->nim),'smt' => urlencode($dataEdit->smt)]) }} class="btn-action2" >Delete</a>
        </div>
    </form>
@endsection