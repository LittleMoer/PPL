@extends('main_mahasiswa')

<style>
    .select-status{
        margin-top: 50px;
    }
    #status{
        border-radius: 20px;
        padding-top: 5px;
        padding-bottom: 5px;
        text-align: center;
        width: 500px;
    }
    .container-btn{
        text-align: center;
        display: flex;
        justify-content: center;
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
    #nilai_pkl{
        margin-top: 10px;
        margin-left: 10px;
        text-align: center;
        /* border-radius: 10px; */
        border: 0px solid rgb(182, 182, 182);
        border-bottom: 2px solid rgb(182, 182, 182);
        padding: 5px;
        width: 100px;
    }
    #nilai_pkl:focus{
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
    #file-pkl::-webkit-file-upload-button{
        display: none;
    }
    /* #file-pkl::-webkit-file-upload-button:hover{
        transition: .5s;
        color: white;
        background-color: rgb(154, 154, 154);
    }
    #file-pkl::placeholder{
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
    .select-semester{
        margin-top: 20px;

    }
    #semester{
        border-radius: 20px;
        padding-top: 5px;
        padding-bottom: 5px;
        text-align: center;
        width: 500px;
    }
    .error{
		color: red;
		font-size: 15px;
		margin-top: 5px;
	}
</style>
<script>
    // document.addEventListener("DOMContentLoaded", function() {
    //     // Menangkap elemen select dan elemen span
    //     var selectstatus = document.getElementById("status");
    //     var keteranganstatus = document.getElementById("keterangan-status");

    //     // Menambahkan event listener untuk mengamati perubahan pada elemen select
    //     selectstatus.addEventListener("change", function() {
    //         // Mengambil nilai yang dipilih dari elemen select
    //         var selectedValue = selectstatus.value;

    //         // Menentukan teks yang akan ditampilkan berdasarkan nilai yang dipilih
    //         var statusText = selectedValue;

    //         // Memperbarui teks pada elemen span
    //         keteranganstatus.textContent = statusText;
    //     });
    // });
    document.addEventListener("DOMContentLoaded", function() {
        // Menangkap elemen select dan elemen span
        var selectSemester = document.getElementById("semester");
        var keteranganSemester = document.getElementById("keterangan-semester");

        // Menambahkan event listener untuk mengamati perubahan pada elemen select
        selectSemester.addEventListener("change", function() {
            // Mengambil nilai yang dipilih dari elemen select
            var selectedValue = selectSemester.value;

            // Menentukan teks yang akan ditampilkan berdasarkan nilai yang dipilih
            var semesterText = selectedValue;

            // Memperbarui teks pada elemen span
            keteranganSemester.textContent = semesterText;
        });
    });
</script>
<title>INFORMASI | PKL</title>
@section('main')

    <div class="judul_page">
        <h3>INFORMASI AKADEMIK / UPLOAD PKL</h3>
    </div>
    <form action="/input_pkl" method="post" enctype="multipart/form-data">
        @csrf

        {{-- <div class="select-status">
                <select name="status" id="status">
                    <option value="">status</option>
                    <option value="1">belum ambil</option>
                    <option value="2">sedang ambil</option>
                    <option value="3">lulus</option>
                </select>
        </div> --}}
        <div class="select-semester">
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
    </div>
    <div class="form-row">
        <label id="label-semester" for="sks">Semester : </label>
        <span id="keterangan-semester"></span>
    </div>
    <hr class="pemisah-input">
        <div class="form-row">
            <label id="label-status" for="sks">NIM : </label>
            <span id="keterangan-status">{{ session('nim') }}</span>
        </div>
        <hr class="pemisah-input">
        <div class="form-row">
            <label id="label-nilai">Nilai PKL : </label>
            <input type="number" name="nilai_pkl" class="nilai_pkl" id="nilai_pkl" maxlength="2" required>
        </div>
        <hr class="pemisah-input">

        <div class="form-row" id="dokumen-upload">
            <label id="label-file">Document PKL : </label>
            <div class="container-icon">
                <label for="file-pkl"><img src="icon-upload.png" id="icon-upload" alt="" width="20px" height="20px"></label>
                <input type="file" name="file-pkl" class="file-pkl" id="file-pkl" required>
            </div>
        </div>
        @if ($errors->any())
            <div class="error">File harus PDF</div>
        @endif
        <hr class="pemisah-input">
        <div class="container-btn">
            <div class="wadah-btn"><input type="submit" id="btn-submit" class="btn" value="Upload PKL"></div>
        </div>
    </form>
@endsection