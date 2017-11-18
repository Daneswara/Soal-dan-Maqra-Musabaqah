<?php
include "koneksi.php";
session_start();
if (empty($_SESSION['user_login'])) {
    header('location: login.php');
}

if (isset($_GET['acak'])) {
    $psoal = $_GET['acak'];
}


function getHalaman($surat, $ayat) {
    include "koneksi.php";
    $queryview = mysqli_query($koneksi, "SELECT * FROM `halaman` WHERE nosurat = $surat and ayatawal <= $ayat ORDER BY no_halaman DESC LIMIT 1") or die(mysqli_error($koneksi));
    $halaman = mysqli_fetch_array($queryview);
    $kanan = $halaman['no_halaman'];
    if (mysqli_num_rows($queryview) == 0) {
        $surat = $surat - 1;
        $queryview = mysqli_query($koneksi, "SELECT * FROM `halaman` WHERE nosurat = $surat ORDER BY no_halaman DESC LIMIT 1") or die(mysqli_error($koneksi));
        $halaman = mysqli_fetch_array($queryview);
        $kanan = $halaman['no_halaman'];
    }
    return $kanan;
}

function getNamaSurat($surat) {
    include "koneksi.php";
    $queryview = mysqli_query($koneksi, "SELECT * FROM `daftarsurah` WHERE nosurat = $surat LIMIT 1") or die(mysqli_error($koneksi));
    $surah = mysqli_fetch_array($queryview);
    $namasurat = $surah['nama'];
    return $namasurat;
}
?>
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
        if (isset($_GET['not'])) {
            $notifikasi = $_GET['not'];
            if ($notifikasi == 1) {
                echo "<script type='text/javascript'>swal({title: 'Login Berhasil!', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            }
        }
        if (isset($_GET['note'])) {
            $notifikasi = $_GET['note'];
            if ($notifikasi == 1) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Paket soal telah diacak', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 12) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Paket soal telah habis, silahkan buat paket soal lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 2) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Acak otomatis telah dilakukan', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 21) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Acak otomatis tidak dapat dilakukan, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 22) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Soal otomatis telah habis, silahkan lakukan reset Perlombaan untuk mengembalikan soal.', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
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
            .bigtext {
                font-size: 1400%;
                text-align: center;
            }
            .img-center {margin:0 auto;}
        </style>

        <div class="container">
            <nav class="navbar navbar-inverse navbar-lg navbar-embossed" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-8">
                        <span class="sr-only">Toggle navigation</span>
                    </button>
                    <a class="navbar-brand" style="padding-top: 15px; line-height: 1.15; text-align: center" href="#"><font size=4> SOAL DAN MAQRA'</font><br> MUSABAQAH</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse-8">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Penjurian</a></li>
                        <li><a href="tafsir.php">Tafsir</a></li>
                        <li class="active"><a href="fahmil.php">MFQ</a></li>
                        <li><a href="linkmushaf.php">Link Mushaf</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pengaturan <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="about.php">Tentang</a></li>
                                <li><a href="help.php">Bantuan</a></li>
                                <li><a href="login.php">Keluar</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
            <div class="row">
            <div class="col-xs-3">
            </div>
                    <div class="col-xs-6">
                        <a href="acakpaket_fahmil.php" class="btn btn-block btn-lg btn-primary">Acak Soal MFQ</a>
                    </div> <!-- /.col-xs-3 -->
            </div> <!-- /.row -->
            <body>
                <style>
                    body {
                        padding-bottom: 20px;
                        padding-top: 20px;
                    }
                    .navbar {
                        margin-bottom: 20px;
                    }
                    /* Jendela Pop Up */
                    #popup {
                        width: 100%;
                        height: 100%;
                        position: fixed;
                        background: rgba(0,0,0,.7);
                        top: 0;
                        left: 0;
                        z-index: 9999;
                        visibility: hidden;
                    }
                    /* Button Close */
                    .close-button {
                        width: 35px;
                        height: 35px;
                        background: #000;
                        border-radius: 50%;
                        border: 3px solid #fff;
                        display: block;
                        text-align: center;
                        color: #fff;
                        text-decoration: none;
                        position: absolute;
                        top: -10px;
                        right: -10px;	
                    }
                    .window {
                        width: 500px;
                        height: 400px;
                        background: #fff;
                        border-radius: 10px;
                        position: relative;
                        padding: 20px;
                        text-align: center;
                        margin: 6% auto;
                    }

                    /* Memunculkan Jendela Pop Up*/
                    #popup:target {
                        visibility: visible;
                    }
                    .tengah {
                        padding-top: 20%;
                        text-align: center;
                    }
                    .tengah2 {
                        z-index: 1000;
                        padding-left: 9%;
                        padding-top: 25%;
                        padding-right: 10px;
                        text-align: center;
                        position: relative;
                        color: white;
                    }
                    .kotak {
                        margin-top: 100px;
                        margin-left: 360px;
                        margin-right: 360px;
                        cursor: hand;
                    }
                    #kotak2{
                        margin-top: -125px;
                        z-index: 10;
                    }
                    img {
                        z-index: 1;
                        position: absolute;
                    }
                </style>


                <div class="row" id="kotak1" name="kotak1" style="padding-left: 25px">
                    <div class="kotak" <?php
                    if (isset($psoal)) {
                        echo "onclick='showSoal()'";
                    }
                    ?> >
                        <img src="gambar/kotak.png" class="img-responsive center-block">
                        <!--<dl class="palette palette-alizarin" style="height: 200px">-->
                        <?php
                        if (isset($psoal)) {
                            echo '<h5><div class="tengah2" style="padding-top: 50px; padding-left: 0px">Paket MFQ';
                        } else {
                            echo '<h5><div class="tengah2" style="padding-top: 50px; padding-left: 0px">Paket ';
                            echo "?";
                        };
                        ?></div></h5></div>
                    <!--</dl>-->
                </div>
        </div>
        <br><!-- /.row -->
        <div class="row" id="kotak2" name="kotak2">
            <?php
            $margin = "470px";
            if (isset($psoal)) {
                echo "<a target='_blank' href='hasilsoaljawabfahmil.php?acak=1'>";
            }
            ?>
            <div class="col-md-2" style="margin-left: <?php echo $margin; ?>">
                <img src="gambar/kotak.png" class="img-responsive center-block">
                <!--                        <dl class="palette palette-alizarin" style="height: 140px">-->
                <dt><div class="tengah2"><?php
                    if (isset($psoal)) {
                        echo "Soal & Jawaban <br> MFQ";
                    }
                    ?></div></dt>
                <!--</dl>-->
            </div>
            <?php
            if ($psoal) {
                echo "</a>";
            }
            if ($psoal) {
                echo "<a target='_blank' href='hasilsoalfahmil.php?acak=1'>";
            }
            ?>
            <div class="col-md-2">
                <img src="gambar/kotak.png" class="img-responsive center-block">
                <!--<dl class="palette palette-alizarin" style="height: 140px">-->
                <dt><div class="tengah2"><?php
                    if (isset($psoal)) {
                        echo "Soal <br>MFQ";
                    }
                    ?></div></dt>
                <!--</dl>-->
            </div>

            <?php
            if (isset($psoal)) {
                echo "</a>";
            }
            ?>
        </div>


        <br>
        <br>
        <br>
        <br>

        <script>
            document.getElementById('kotak2').style.visibility = 'hidden';
            function showSoal() {
                document.getElementById('kotak1').style.visibility = 'hidden';
                document.getElementById('kotak2').style.visibility = 'visible';
            }

        </script>

        <script src="dist/js/vendor/jquery.min.js"></script>
        <script src="dist/js/vendor/video.js"></script>
        <script src="dist/js/flat-ui.min.js"></script>
        <script src="docs/assets/js/application.js"></script>

    </body>