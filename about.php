<?php
include "koneksi.php";
session_start();
if (empty($_SESSION['user_login'])) {
    header('location: login.php');
}
$queryview = mysqli_query($koneksi, "SELECT * FROM pengaturan LIMIT 1") or die(mysqli_error($koneksi));
$pengaturan = mysqli_fetch_array($queryview);
$acara = $pengaturan['acara'];
$logo = $pengaturan['logo'];
$video = $pengaturan['link_video'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>SOAL DAN MAQRA' MUSABAQAH</title>
        <meta name="description" content="Flat UI Kit Free is a Twitter Bootstrap Framework design and Theme, this responsive framework includes a PSD and HTML version."/>

        <meta name="viewport" content="width=1000, initial-scale=1.0, maximum-scale=1.0">

        <!-- Loading Bootstrap -->
        <link href="dist/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Loading Flat UI -->
        <link href="dist/css/flat-ui.css" rel="stylesheet">
        <link href="docs/assets/css/demo.css" rel="stylesheet">

        <script src="js/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="js/sweetalert.css">

        <link rel="shortcut icon" href="img/favicon.ico">

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
                echo "<script type='text/javascript'>swal({title: 'Login Berhasil!', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            }
        }
        ?>
        <style>
            body {
                padding-bottom: 20px;
                padding-top: 20px;
            }
            .navbar {
                margin-bottom: 20px;
            }
            img{
                margin: auto;
            }
            #inner {
                text-align: center;
                margin: auto;
                width: 95%;
            }
        </style>
        <div class="container">
            <nav class="navbar navbar-inverse navbar-lg navbar-embossed" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-8">
                        <span class="sr-only">Toggle navigation</span>
                    </button>
                    <a class="navbar-brand" style="padding-top: 10px; line-height: 1.15; text-align: center" href="#"><font size=4> SOAL DAN MAQRA'</font><br> MUSABAQAH</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse-8">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Tilawah dan MHQ</a></li>
                        <li ><a href="tafsir.php">Tafsir</a></li>
                        <li ><a href="fahmil.php">MFQ</a></li>
                        <li><a href="linkmushaf.php">Link Mushaf</a></li>
                        <li><a href="acak.php">Acak</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pengaturan <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li class="active"><a href="about.php">Tentang</a></li>
                                <li><a href="help.php">Bantuan</a></li>
                                <li><a href="login.php">Keluar</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>

            <div class="row demo-samples">
                <div class="col-xs-6">
                    <video class="video-js" preload="auto" data-setup="{}">
                        <source src="upload/<?php echo $video;?>" type="video/mp4">
                    </video>
                </div>
                <div id="inner">
                    <h3><?php echo $acara; ?></h3>
                    <img width="430" src="gambar/<?php echo $logo; ?>">
                </div> <!-- /video -->


            </div>
        </div>
        <script src="dist/js/vendor/jquery.min.js"></script>
        <script src="dist/js/vendor/video.js"></script>
        <script src="dist/js/flat-ui.min.js"></script>
        <script src="docs/assets/js/application.js"></script>

        <script>
            videojs.options.flash.swf = "dist/js/vendors/video-js.swf"
        </script>
    </body>
</html>
