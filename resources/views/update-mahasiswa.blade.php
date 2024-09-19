<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>SIAP | UPDATE DATA</title>
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Font-->
	<link rel="stylesheet" type="text/css" href="update-mahasiswa/css/montserrat-font.css">
	<link rel="stylesheet" type="text/css" href="update-mahasiswa/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
	<!-- Main Style Css -->
    <link rel="stylesheet" href="update-mahasiswa/css/style.css"/>
    {{-- <link rel="stylesheet" type="text/css" href="login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css"> --}}
	<script>
		function updateKabKota() {
			var selectedProvinsi = document.getElementById("provinsi").value;
			var kotaDropdown = document.getElementById("kota");
			
			// Kosongkan dropdown kabupaten/kota
			kotaDropdown.innerHTML = '<option value="">Kab / Kota</option>';
			
			// Tambahkan pilihan kabupaten/kota yang sesuai dengan provinsi yang dipilih
			@foreach ($kabkot as $item)
				if ("{{ $item->id_prov }}" === selectedProvinsi) {
					var option = document.createElement("option");
					option.value = "{{ $item->id_kab_kot }}";
					option.text = "{{ $item->kab_kot }}";
					kotaDropdown.appendChild(option);
				}
			@endforeach
		}
		</script>
		<style>
			.error{
				color: red;
				font-size: 10px;
				margin-top: 5px;
			}
		</style>
<title>SIAP | DATA MAHASISWA</title>

</head>
<body class="form-v10">
	<div class="page-content">
		<div class="form-v10-content">
			<form class="form-detail" role="form" action="{{ route('confirmDataAwal')}}" method="post" id="myform">
				@csrf
				<div class="form-left">
					<h2>Informasi Mahasiswa</h2>
					<div class="form-row">
						<input type="text" name="nama_lengkap" id="nama_lengkap" class="input-text" value="{{ $mhs->nama }}" >
					</div>
					<div class="form-row">
						<input type="text" name="nim" class="nim" id="nim" value="{{ $mhs->nim }}" disabled>
					</div>
					<div class="form-row">
						<input type="text" name="angkatan" class="angkatan" id="angkatan" value="{{ $mhs->angkatan }}" disabled>
					</div>
					<div class="form-row">
						<select name="jalur_masuk" id="jalur_masuk" required>
						    <option value="">Jalur Masuk</option>
						    <option value="SNMPTN">SNMPTN</option>
						    <option value="SBMPTN">SBMPTN</option>
						    <option value="MANDIRI">MANDIRI</option>
						    <option value="LAINNYA">LAINNYA</option>
						</select>
						<span class="select-btn">
						  	<i class="zmdi zmdi-chevron-down"></i>
						</span>
					</div>
					<div class="form-group">
						<div class="form-row form-row-3">
							<input type="email" name="email" class="email" id="email" value="{{ $mhs->email }}" placeholder="Email" required>
							<div class="error">{{ $error_email }}</div>
						</div>
						<div class="form-row form-row-4">
							<input type="number" name="no_telp" class="no_telp" id="no_telp" placeholder="No telp" value="{{ $mhs->no_hp }}" required>
						</div>
					</div>
                    <div class="form-row">
						<input type="text" name="password" class="password" id="password" placeholder="New Password">
					</div>
                    <div class="form-row">
						<input type="text" name="status" class="status" id="status" value="{{ $mhs->cek_status }}" disabled>
					</div>
				</div>
				<div class="form-right">
					<h2>Informasi Mahasiswa</h2>
					<div class="form-row">
						<input type="text" name="alamat" class="Alamat" id="Alamat" placeholder="Alamat" maxlength="100" value="{{ $mhs->alamat }}" required>
					</div>
					<div class="form-row">
						<select name="provinsi" placeholder="Provinsi" id="provinsi" onchange="updateKabKota()">
							<option value="">Provinsi</option>
							@foreach ($prov as $item)
								<option value="{{ $item->id_prov }}">{{ $item->provinsi }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-row">
						<select name="kota" id="kota" placeholder="Kab / Kota">
							<option value="">Kab / Kota</option>
						</select>
					</div>
					<div class="form-row-last">
						<input type="submit" name="submit" class="submit" value="Submit">
					</div>
				</div>
			</form>
		</div>
	</div>
</body>
</html>