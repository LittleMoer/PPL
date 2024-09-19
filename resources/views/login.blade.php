<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="logo-undip.png">
  <link rel="icon" type="image/png" href="logo-undip-login.png">
  <link rel="stylesheet" href="style.css">
  <title>

    {{-- Sesuaikan nama title --}}

    ASIAP | Sign In
  </title>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body class="">
  <main class="main-content mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-8 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center" style="background-image: url('../undip.jpg'); background-size: cover;">
              </div>
            </div>
            <div class="col-xl-3 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
              <div class="card card-plain">
                <div class="text-center">
                  <img src="logo-undip.jpg" style="max-width: 100%; max-height: 200px;">
                </div>
                <br><br>
                <div class="card-header">
                  <h4 class="font-weight-bolder">Sign In</h4>
                  <p class="mb-0">Enter your email and password to sign in</p>
                </div>
                <div class="card-body">

                    {{-- Tambahkan action pada tag form --}}

                  <form role="form" method="POST" action="/confirmLog">

                    {{-- Tambahkan csrf --}}

                    @csrf
                    <div class="input-group input-group-outline mb-3">
                      <input type="text" class="form-control" placeholder="Email" name="email" value="<?php if(isset($email)) echo $email;?>">
                    </div>
                    {{-- <div class="error">{{ $error_email }}</div> --}}
                    <div class="input-group input-group-outline mb-3">
                      <input type="password" class="form-control" placeholder="Password" name="password">
                    </div>
                    <div class="text-danger text-center mb-2">{{ session('error_akun')}}</div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg" style="background-color: rgb(61, 61, 143); color: white; width: 100%;">Sign In</button>
                    </div>
                    {{-- <div class="error text-center">{{ $error }}</div> --}}
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="../assets/js/material-dashboard.min.js?v=3.1.0"></script>
</body>

</html>