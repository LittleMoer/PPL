@extends('main_operator')
<title>ENTRY | MAHASISWA BARU</title>
<meta charset="utf-8">
<!-- Mobile Specific Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!-- Font-->
<link rel="stylesheet" type="text/css" href="entry-mahasiswa/css/montserrat-font.css">
<link rel="stylesheet" type="text/css" href="entry-mahasiswa/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
	<!-- Main Style Css -->
<link rel="stylesheet" href="entry-mahasiswa/css/style.css"/>
<link rel="stylesheet" type="text/css" href="update-mahasiswa/css/montserrat-font.css">
@section('main1')
	<style>
		.main1 {
			background-color: rgb(239, 239, 239);
			padding: 20px 50px 20px 50px;
			/* position: fixed; */
			border-radius: 20px;
			box-shadow: 0px 2px 6px 0px black;
			-o-box-shadow: 0px 2px 6px 0px black;
			-ms-box-shadow: 0px 2px 6px 0px black;
			-moz-box-shadow: 0px 2px 6px 0px black;
			-webkit-box-shadow: 0px 2px 6px 0px black;
			overflow: auto;
			margin-top: 5%;
			margin-bottom: 50px;
			margin-left: 22%;
			width: 1050px;
		}
		.cont_judul{
			text-align: center;
		}
		.cont_judul h4{
			margin-top: 50px;
		}

		#label_file_mhs{
			text-align: center;
			margin-top: 30px;
			display: inline-block;
			width: 100%;
			border: 2px dashed black;
			margin-bottom: 20px;
			height: 100px;
		}
		#label_file_mhs img{
			margin-top: 15px;
		}
		#file_mhs::-webkit-file-upload-button{
        	display: none;
    	}
		.cont_file_mhs{
			display: block;
			margin-top: 10px;
		}
		#file_mhs{
			margin-left: 170px;
		}
		.cont_cat li:first-child{
			list-style-type: none;
			font-weight: bold;
			color: red;
		}
		#btn-submit{
			padding-bottom: 5px;
			padding-top: 5px;
		}
		.cont_sukses{
			text-align: center;
		}
		.success{
			color: green;
		}
	</style>
	<div class="cont_judul">
		<h3>
			Upload Batch Mahasiswa
		</h3>
	</div>
		<form action="/upload_batch_mhs" method="POST" enctype="multipart/form-data">
			@csrf
			<label for="file_mhs" id="label_file_mhs">
				<img src="{{ asset('icon-upload.png') }}" alt="" width="50px" height="50px">
				<div class="cont_file_mhs">
					<input type="file" id="file_mhs" name="file_mhs" required>
				</div>
			</label>
			<div id="submit"><input type="submit" id="btn-submit" value="Send"></div>
		</form>
	@if($errors->has('file_mhs'))
    	<div class="error" id="error_format">File Harus .xlsx</div>
		<script>
			var flashElement = document.getElementById("error_format");
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
	@if( session('error_file') )
		<div class="error" id="error_format">{{ session('error_file') }}</div>
		{{-- <script>
			var flashElement = document.getElementById("error_format");
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
		</script> --}}
	@endif
	@if( session('sukses') )
		<div class="cont_sukses"><div class="success" id="success">{{ session('sukses') }}</div></div>
		<script>
			var flashElement = document.getElementById("success");
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

			setTimeout(hilangkanFlash, 4000); 
		</script>
	@endif
	<div class="cont_cat">
		<ul>
			<li>*</li>
			<li>Format file harus .xlsx (excel)</li>
			<li style="margin-top: 10px;">Format Penulisan : <br><b>Kolom 1</b> = Nama , <b>Kolom 2</b> = NIM , <b>Kolom 3</b> = Angkatan , <b>Kolom 4</b> = Kode Dosen Wali</li>
			<li style="margin-top: 10px;">Contoh : <br><img src="{{ asset('format_penulisan_batch_mhs.png') }}" alt="format" width="500px" height="150px"></li>
		</ul>
	</div>


@endsection
@section('main')



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
    // const passwordDisplay = document.getElementById("password");
    // const generateButton = document.getElementById("generate-password");

    // generateButton.addEventListener("click", function() {
    //     const password = generatePassword(12); // Ganti 12 dengan panjang yang Anda inginkan
    //     passwordDisplay.value = password;
    // });
    
    // function generatePassword(length) {
    //     const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+";
    //     let password = "";

    //     for (let i = 0; i < length; i++) {
    //         const randomIndex = Math.floor(Math.random() * charset.length);
    //         password += charset.charAt(randomIndex);
    //     }

    //     return password;
    // }
});

</script>
<style>
	.error{
		text-align: center;
		color: red;

		margin-bottom: 20px;
	}
</style>
<body class="form-v10">
	<div class="page-content">
		<div class="form-v10-content">
			<form class="form-detail" action="/updateAdd" method="get" id="myform">
				<div class="form-left">
					<h2 id="judul-form">Informasi Mahasiswa</h2>
					<div class="form-row">
						<input type="text" name="nama_lengkap" id="nama_lengkap" class="input-text" placeholder="Nama Lengkap" required>
					</div>
					<div class="form-row">
						<input type="text" name="nim" class="nim" id="nim" placeholder="Nim" maxlength="14" required>
					</div>
					<div class="form-row">
						<select name="angkatan" id="angkatan">
						    <option value="">Angkatan</option>
						</select>
						<span class="select-btn">
						  	<i class="zmdi zmdi-chevron-down"></i>
						</span>
					</div>
					<div class="form-group">
						<div class="form-row form-row-3">
							<select name="dosen-wali">
								<option value="">Dosen Wali</option>
								@foreach ($dataDosen as $dosen)
									<option value="{{ $dosen->nip }}">{{ $dosen->nama }}</option>
								@endforeach
							</select>
							<span class="select-btn">
								  <i class="zmdi zmdi-chevron-down"></i>
							</span>
						</div>
					</div>
					{{-- <div class="form-row" id="form-pw">
						<input type="text" name="password" class="password" id="password" placeholder="Password" required>
						<div class="container-generate"><button id="generate-password">Generate</button></div>
					</div> --}}
					<div class="error">{{ session('error_mhs') }}</div>
					<div id="submit"><input type="submit" id="btn-submit"></div>
				</div>
			</form>
		</div>
	</div>
</body>
@endsection