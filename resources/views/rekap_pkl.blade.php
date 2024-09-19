@extends('main_departement')
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="tabel/https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

<link rel="stylesheet" href="tabel/fonts/icomoon/style.css">

<link rel="stylesheet" href="tabel/css/owl.carousel.min.css">

<!-- Bootstrap CSS -->
{{-- <link rel="stylesheet" href="tabel/css/bootstrap.min.css"> --}}

<!-- Style -->
<link rel="stylesheet" href="tabel/css/style.css">
<style>
    .judul_page{
        text-align: center;
    }
    .link-menu{
        text-decoration: none;
        color: rgb(83, 83, 160);
    }
    .link-menu:hover{
      color: rgb(48, 48, 203);
      text-decoration: underline;
      transition: .3s;
    }
    .tr-1 th:hover{
      background-color: rgb(169, 167, 228);
      display: block;
      transition: .3s;
      border-radius: 20px;
    }

    .table-menu-atas{
      overflow: auto;
      margin-top: 30px;
      text-align: center;
      width: 1030px;

    }
    .tr-1{
      border-bottom: 1px solid black;
    }
    .tr-1 th{
        
      padding-top: 10px;
      padding-bottom: 10px;
      border-bottom: 1px solid black;
    }


    .cont_table{
        text-align: center;
    }
    .cont_table h3{
        text-align: left;
        margin-top: 20px;
    }
    /* table{
        display: inline-block;
    } */
    .angkatan th{
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .tahun{
        text-align: center;
    }
    .tahun td{
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .status{
        text-align: center;
    }
    .status td{
        padding: 10px 15px 10px 15px;
    }
    .jml_pkl{
        text-align: center;
    }
    .jml_pkl td{
        padding: 10px;
    }
    .jml_skripsi{
        text-align: center;
    }
    .jml_skripsi td{
        padding: 10px;
    }
    #tabel_pkl{
        margin-top: 20px;
    }
    #tabel_skripsi{
        margin-top: 20px;
    }
    .link_jml:hover{
        background-color: rgb(190, 190, 190);
    }
    .cont_btn{
        text-align: right;
    }
    .btn_rekap{
        cursor: pointer;
        margin-top: 20px;
        padding-top: 5px;
        padding-bottom: 5px;
        border-radius: 20px;
        background-color: rgb(89, 236, 89);
        width: 100px;
        margin-right: 50px;
    }
</style>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var tahunElements = document.querySelectorAll(".tahun");

    tahunElements.forEach(function(tahunElement) {
        var currentYear = new Date().getFullYear();

        for (var j = currentYear - 6; j <= currentYear; j++) {
            var td = document.createElement("td");
            td.textContent = j;
            td.setAttribute("colspan", "2");
            tahunElement.appendChild(td);
        }
    });


    @php
        $currentYear = now()->year; // Assuming you want the current year
    @endphp


    var sessionData = @json([
        'sudahpkl' => [],
        'belumpkl' => [],
        // Add other necessary data here
    ]);

    @foreach(range($currentYear - 6, $currentYear) as $year)
        sessionData['sudahpkl{{$year}}'] = '{{ session("sudahpkl" . $year) }}';
        sessionData['belumpkl{{$year}}'] = '{{ session("belumpkl" . $year) }}';
    @endforeach

    var sessionData1 = @json([
        'sudahskripsi' => [],
        'belumskripsi' => [],
        // Add other necessary data here
    ]);

    @foreach(range($currentYear - 6, $currentYear) as $year)
        sessionData1['sudahskripsi{{$year}}'] = '{{ session("sudahskripsi" . $year) }}';
        sessionData1['belumskripsi{{$year}}'] = '{{ session("belumskripsi" . $year) }}';
    @endforeach


    var jmlpkl = document.querySelectorAll(".jml_pkl");

    jmlpkl.forEach(function (element) {
        var currentYear = new Date().getFullYear();

        for (var j = currentYear - 6; j <= currentYear; j++) {
            var a = document.createElement("a");
            a.style.textDecoration = 'None';
            a.style.color = 'black';

            var angkatan = j;
            if(sessionData['sudahpkl' + j] != "-"){
                a.href = "/lulus/pkl/" + angkatan;
            }else{
                a.href = "";
            }
            var td = document.createElement("td");
            td.setAttribute('class','link_jml');
            a.textContent = sessionData['sudahpkl' + j];
            td.appendChild(a);

            element.appendChild(td);

            var a1 = document.createElement("a");
            a1.style.textDecoration = 'None';
            a1.style.color = 'black';
            if(sessionData['belumpkl' + j] != "-"){
                a1.href = "/belum/pkl/" + angkatan;

            }else{
                a1.href = "";
            }
            var td1 = document.createElement("td");
            td1.setAttribute('class','link_jml');
            a1.textContent = sessionData['belumpkl' + j];
            td1.appendChild(a1);

            
            element.appendChild(td1);
        }
    });

    var jmlskripsi = document.querySelectorAll(".jml_skripsi");

    jmlskripsi.forEach(function (element) {
        var currentYear = new Date().getFullYear();

        for (var j = currentYear - 6; j <= currentYear; j++) {
            var a = document.createElement("a");
            a.style.textDecoration = 'None';
            a.style.color = 'black';

            if(sessionData1['sudahskripsi' + j] != "-"){
                a.href = "/lulus/skripsi/" + j;
            }else{
                a.href = "";
            }
            var td = document.createElement("td");
            td.setAttribute('class','link_jml');
            a.textContent = sessionData1['sudahskripsi' + j];
            td.appendChild(a);

            element.appendChild(td);

            var a1 = document.createElement("a");
            a1.style.textDecoration = 'None';
            a1.style.color = 'black';
            if(sessionData1['belumskripsi' + j] != "-"){
                a1.href = "/belum/skripsi/" + j;

            }else{
                a1.href = "";
            }
            var td1 = document.createElement("td");
            td1.setAttribute('class','link_jml');
            a1.textContent = sessionData1['belumskripsi' + j];
            td1.appendChild(a1);

            
            element.appendChild(td1);
        }
    });

});

</script>
@section('main')
<div class="judul_page">
    <h3>Rekap PKL & Skripsi</h3>
</div>
<div class="menu_nav">
    <div class="container-tabel-menu-atas">
      <table class="table-menu-atas" cellspacing="10">
        <thead>
          <tr class="tr-1">
            <th scope=""><a class="link-menu" href="/data/mahasiswa">Data Mahasiswa</a></th>
            <th scope=""><a class="link-menu" href="/rekap/pkl&skripsi">Rekap PKL & Skripsi</a></th>
          </tr>
        </thead>
      </table>
    </div>
</div>
<div class="cont_table">
    <div class="rekappkl">
        <h3>Rekap PKL</h3>
        <table border="1" id="tabel_pkl">
            <thead class="angkatan">
                <th colspan="14">Angkatan</th>
            </thead>
            <tbody>
                <tr class="tahun">
    
                </tr>
                <tr class="status">
                    <td>Lulus</td>
                    <td>Belum</td>
                    <td>Lulus</td>
                    <td>Belum</td>
                    <td>Lulus</td>
                    <td>Belum</td>
                    <td>Lulus</td>
                    <td>Belum</td>
                    <td>Lulus</td>
                    <td>Belum</td>
                    <td>Lulus</td>
                    <td>Belum</td>
                    <td>Lulus</td>
                    <td>Belum</td>
                </tr>
                <tr class="jml_pkl">
    
                </tr>
            </tbody>
        </table>
    </div>
    <div class="cont_btn">
        <input type="button" class="btn_rekap" id="cetak_pkl" value="Cetak" onclick="cetak('tabel_pkl')">
    </div>
    <div class="rekapskripsi">
        <h3>Rekap Skripsi</h3>
        <table border="" id="tabel_skripsi">
            <thead class="angkatan">
                <th colspan="14">Angkatan</th>
            </thead>
            <tbody>
                <tr class="tahun">
    
                </tr>
                <tr class="status">
                    <td>Lulus</td>
                    <td>Belum</td>
                    <td>Lulus</td>
                    <td>Belum</td>
                    <td>Lulus</td>
                    <td>Belum</td>
                    <td>Lulus</td>
                    <td>Belum</td>
                    <td>Lulus</td>
                    <td>Belum</td>
                    <td>Lulus</td>
                    <td>Belum</td>
                    <td>Lulus</td>
                    <td>Belum</td>
                </tr>
                <tr class="jml_skripsi">
    
                </tr>
            </tbody>
        </table>
    </div>
    <div class="cont_btn">
        <input type="button" class="btn_rekap" id="cetak_skripsi" value="Cetak" onclick="cetak('tabel_skripsi')">
    </div>
</div>
<script>
    function cetak(tabel){
        var cetakdata = document.getElementById(tabel);
        if(cetakdata.id === "tabel_pkl"){
            var newWin = window.open("");
            newWin.document.write('<html><head><title>Cetak</title>');
            newWin.document.write('<style>');
            newWin.document.write('td { text-align: center; padding: 5px 7px;}');
            newWin.document.write('</style>');
            newWin.document.write('</head><body>');
            newWin.document.write('<h3 style="margin-bottom:20px;">Rekap tabel PKL</h3>');
            newWin.document.write(cetakdata.outerHTML);
            newWin.document.write('</body></html>');
            newWin.print();
            newWin.close();
        }else{
            if(cetakdata.id === "tabel_skripsi"){
                newWin.document.write('<html><head><title>Cetak</title>');
                newWin.document.write('<style>');
                newWin.document.write('td { text-align: center; padding: 5px 7px;}');
                newWin.document.write('</style>');
                newWin.document.write('</head><body>');
                newWin.document.write('<h3 style="margin-bottom:20px;">Rekap tabel Skripsi</h3>');
                newWin.document.write(cetakdata.outerHTML);
                newWin.document.write('</body></html>');
                newWin.print();
                newWin.close();
            }
        }
    }
</script>
@endsection


