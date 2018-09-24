<?php
session_start(); // memulai session
session_destroy();
include "../koneksi.php";
$queryview = mysqli_query($koneksi, "SELECT * FROM pengaturan LIMIT 1") or die(mysqli_error($koneksi));
$pengaturan = mysqli_fetch_array($queryview);
$acara = $pengaturan['acara'];
$acara = str_replace("<petik>", "'", $acara);
$logo = $pengaturan['logo'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>SOAL DAN MAQRA' MUSABAQAH</title>
        <meta name="description" content="Flat UI Kit Free is a Twitter Bootstrap Framework design and Theme, this responsive framework includes a PSD and HTML version."/>

        <meta name="viewport" content="width=1000, initial-scale=1.0, maximum-scale=1.0">

        <!-- Loading Bootstrap -->
        <link href="../dist/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Loading Flat UI -->
        <link href="../dist/css/flat-ui.css" rel="stylesheet">
        <link href="../docs/assets/css/demo.css" rel="stylesheet">

        <script src="../js/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../js/sweetalert.css">

        <link rel="shortcut icon" href="../img/favicon.ico">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
        <!--[if lt IE 9]>
          <script src="dist/js/vendor/html5shiv.js"></script>
          <script src="dist/js/vendor/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>
        <?php
        if (isset($_GET['note'])) {
            $notifikasi = $_GET['note'];
            if ($notifikasi == 1) {
                echo "<script type='text/javascript'>swal({title: 'Login Gagal!', text: 'Username/Password anda salah, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            }
        }
        ?>
        <style>
            body{
                background-color: #1abc9c;
            }
            .container{
                padding: 15%;
            }
        </style>
        <div class="container" style="margin-top: -100px">
            <div class="login-form">
                <div style="text-align: center; padding: 20px"><img style="margin-top: -10px" height="100px" src="../gambar/<?php echo $logo; ?>"></div>
                <div style="margin-bottom: 20px; text-align: center"><b><center><?php echo $acara;?></center></b></div>
                <form action="CekLogin.php" method="POST">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control login-field" value="" placeholder="Username" id="login-name" />
                        <label class="login-field-icon fui-user" for="login-name"></label>
                    </div>

                    <div class="form-group">
                        <input type="password" name="password" class="form-control login-field" value="" placeholder="Password" id="login-pass" />
                        <label class="login-field-icon fui-lock" for="login-pass"></label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg btn-block" href="index.php">Log in Admin</button>
                    <a class="login-link" href="#">Lost your password?</a>
                </form>
            </div>
        </div>
        <script src="../dist/js/vendor/jquery.min.js"></script>
        <script src="../dist/js/vendor/video.js"></script>
        <script src="../dist/js/flat-ui.min.js"></script>
        <script src="../docs/assets/js/application.js"></script>

        <script>
            videojs.options.flash.swf = "dist/js/vendors/video-js.swf"
        </script>
    </body>
</html>
