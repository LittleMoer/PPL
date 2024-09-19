<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="update-mahasiswa/css/montserrat-font.css">
    <link href="tabel/https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="tabel/fonts/icomoon/style.css">
    
    <link rel="stylesheet" href="tabel/css/owl.carousel.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('main/sytle.css') }}"> --}}
    
    <!-- Bootstrap CSS -->
    {{-- <link rel="stylesheet" href="tabel/css/bootstrap.min.css"> --}}
    
    <!-- Style -->
    {{-- <link rel="stylesheet" href="tabel/css/style.css"> --}}

<title>SIAP | DEPT</title>
<style>
    * {
    margin: 0;
    padding: 0;
}
body{
    background-color: rgb(215, 215, 215); 
}
nav {
    position: fixed;
    display: none;
    width: 100%;
    height: 80px;
    /* background-color: rgb(67, 67, 67); */
    background-color: rgba(0, 0, 148);
    color: white;
    filter: blur(.4px);
    /* border-radius: 20px; */
    border: 1px solid black;
    /* margin-left: 7%; */
    /* margin-top: 1%; */
    /* margin-right: 3%; */
    /* margin-bottom: 0; */
}

aside {
    position: fixed;
    display: inline-block;
    width: 50px;
    overflow: hidden;
    height: 100%;
    border-right: 5px solid rgb(84, 84, 84);
    /* background-color: rgb(0, 0, 159); */
    /* background-color: rgb(73, 73, 73); */

    background-color: rgb(42, 42, 184);

}

aside:hover {
    animation: animasi_side .2s ease-in normal forwards ;
}

.nav-side-logo{
    display: inline-block;
    /* text-align: center; */
    margin-top: 50px;
    /* background-color: white; */
    width: 220px;
}
@keyframes animasi_side {
    0% {
        width: 50px;
    }
    100% {
        width: 15%;
    }
}



.nav-side.menu {
    margin-top: 50px;
    /* background-color: rgb(117, 117, 117); */
    /* margin-left: 30px;
    margin-right: 30px;
    border-radius: 25px;
    box-shadow: 0px 5px 15px 0px rgb(139, 139, 139);
    -o-box-shadow: 0px 5px 15px 0px rgb(139, 139, 139);
    -ms-box-shadow: 0px 5px 15px 0px rgb(139, 139, 139);
    -moz-box-shadow: 0px 5px 15px 0px rgb(139, 139, 139);
    -webkit-box-shadow: 0px 5px 15px 0px rgb(139, 139, 139); */
}

.nav-side.logout {
    margin-top: 320px;
    /* background-color: rgb(117, 117, 117); */
    /* margin-left: 30px;
    margin-right: 30px;
    border-radius: 25px;
    box-shadow: 0px 5px 15px 0px rgb(139, 139, 139);
    -o-box-shadow: 0px 5px 15px 0px rgb(139, 139, 139);
    -ms-box-shadow: 0px 5px 15px 0px rgb(139, 139, 139);
    -moz-box-shadow: 0px 5px 15px 0px rgb(139, 139, 139);
    -webkit-box-shadow: 0px 5px 15px 0px rgb(139, 139, 139); */
}

.judul-nav {
    font-weight: bold;
    font-size: 15px;
    text-align: center;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
    background-color: rgb(206, 206, 206);
    padding: 10px;
}

.nav-side ul li {
    padding-left: 10px;
    padding-top: 10px;
    padding-bottom: 10px;
    display: flex;
    align-items: center;
    margin-top: 15px;
    width: 250px;
    /* background-color: white; */

}
.nav-side ul li:hover{
    color: black;
    background-color: rgb(74, 74, 237);
}

.nav-side.menu ul li a {
    display: inline-block;
    color: white;
    font-weight: 300;
    width: 150px;
    text-decoration: none;
    /* font-size: 20px; */
}

.nav-side.logout ul li a {
    text-decoration: none;
    color: white;
    font-weight: 300;
    width: 100px;
    /* font-size: 20px; */
}

.konten {
    display: flex;
    /* flex-direction: row; */
}

.main {
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
    margin-top: 2%;
    margin-bottom: 50px;
    margin-left: 22%;
    width: 1050px;
}


.container-nav {
    text-align: right;
    /* float: right; */
    margin-top: 10px;
}

.container-logo {
    /* align-items: center; */
    text-align: center;
}

.container-profile {
    font-size: 15px;
    align-items: center;
    display: flex;
    flex-direction: row-reverse;
    margin-right: 20px;
}

#foto-profile {
    margin-left: 20px;
    border-radius: 20px;
}

#gambar_logout {
    display: inline-block;
    margin-left: 20px;
    margin-top: 20px;
}

#logo-logout {
    width: 30px;
    height: 30px;
}

.logo {
    width: 25px;
    height: 25px;
    margin-right: 30px;
}
hr{
    margin-top: 5px;
    margin-left: 10px;
    margin-right: 10px;
}
</style>

</head>
<body>
    <nav>
        <div class="container-nav">
            {{-- <div class="kosong"><a id="gambar_logout" href="/"><img id="logo-logout" src="{{ asset('icon-logout.png')}}" alt=""></a></div> --}}
            <div class="container-profile">
                <img src="{{ asset('icon-profile.png') }}" alt="" width="50px" height="50px" id="foto-profile">
                <div class="info-profile">
                    <div class="nama">{{ $data->nama }}</div>
                    <hr>
                    <div class="jabatan">{{ $data->role }}</div>
                </div>
            </div>
        </div>
    </nav>
    <div class="konten">
        <aside>
            <div class="nav-side-logo">
                <div class="container-logo">
                    <img src="{{ asset('logo-undip.jpg') }}" alt="" width="60px" height="60px">
                    <h1 class="siap-undip">Siap Undip</h1>
                </div>
            </div>
            <div class="nav-side menu">
                <ul type='none'>
                    <li><i><img src="{{ asset('icon-profile.png') }}" class="logo" alt=""></i><a href="/profile/departement">Profile</a></li>
                    <li><i><img src="{{ asset('mahasiswa.png') }}" class="logo" alt=""></i><a href="/rekap/pkl&skripsi">Data Mahasiswa</a></li>
                    <li><i><img src="{{ asset('statistik.png') }}" class="logo" alt=""></i><a href="/statistik/mhs">Statistik Mahasiswa</a></li>
                    <hr>
                </ul>
            </div>
            <div class="nav-side logout">
                <ul type='none'>
                    <li><i><img src="{{ asset('icon-logout.png') }}" class="logo" alt=""></i><a href="/">Log Out</a></li>
                </ul>
            </div>
        </aside>
        <main>
            <div class="main">
                @yield('main')
           </div>
           <div class="main1">
                @yield('main1')
           </div>
        </main>
    </div>
</body>
</html>