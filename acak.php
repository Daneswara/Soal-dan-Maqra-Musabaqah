<?php
include "koneksi.php";
session_start();
if (empty($_SESSION['user_login'])) {
    header('location: login.php');
}
if (isset($_GET["surat1"]) && isset($_GET["ayat1"])) {
    $tempsurat = $_GET["surat1"];
    $tempayat = $_GET["ayat1"];

    $hal = getHalaman($tempsurat, $tempayat);
    $namasurat = getNamaSurat($tempsurat);
    $namasurat = str_replace("'", "petik", $namasurat);
    echo "<script type=\"text/javascript\">  window.open('mushaf.php?kanan=$hal&surah=$tempsurat&ayat=$tempayat&namasurat=$namasurat')</script>";
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
        <script src="js/jquery-1.10.2.js"></script>

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
        <!--[if lt IE 9]>
          <script src="dist/js/vendor/html5shiv.js"></script>
          <script src="dist/js/vendor/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>

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
                        <li><a href="index.php">Tilawah dan MHQ</a></li>
                        <li ><a href="tafsir.php">Tafsir</a></li>
                        <li ><a href="fahmil.php">MFQ</a></li>
                        <li ><a href="linkmushaf.php">Link Mushaf</a></li>
                        <li class="active"><a href="acak.php">Acak</a></li>
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
                    <div class="col-xs-12">
                        <h3>Acak Kalimat</h3>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <textarea type="text" name="kalimat" id="kalimat" placeholder="Isikan kalimat yang akan diacak, pisahkan dengan Enter" class="form-control"></textarea>

                            <button  style="margin-top: 20px" id="acakkalimat" class="btn btn-block btn-lg btn-primary">Acak</button></div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <textarea type="text" style="height: 150px" name="hasilkalimat" id="hasilkalimat" placeholder="Hasil acak kalimat" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <h3>Acak Angka</h3>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <input type="text" name="angkaawal" id="angkaawal" placeholder="Isikan angka awal yang akan diacak" class="form-control">
                            <input type="text" name="angkaakhir" id="angkaakhir" placeholder="Isikan angka akhir yang akan diacak" style="margin-top: 10px"class="form-control">

                            <button style="margin-top: 10px" id="acakangka" class="btn btn-block btn-lg btn-primary">Acak</button></div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <textarea type="text" style="height: 150px" name="hasilangka" id="hasilangka" placeholder="Hasil acak angka" class="form-control"></textarea>
                        </div>
                    </div>
            </div> <!-- /.col-xs-3 -->
        </div> <!-- /.row -->

    </div>


    <script type="text/javascript">
        $(document).ready(function () {
            document.getElementById("kalimat").addEventListener('keyup', function () {
                this.style.overflow = 'hidden';
                this.style.height = 85;
                this.style.height = this.scrollHeight + 'px';
            }, false);
            
            
            document.getElementById("acakkalimat").addEventListener('click', function (){
                var x = document.getElementById("kalimat").value;
                var res = x.split("\n");
                var acak = Math.floor((Math.random() * res.length));
                document.getElementById("hasilkalimat").value = res[acak];
            }, false);
            
            document.getElementById("acakangka").addEventListener('click', function (){
                var x = document.getElementById("angkaawal").value;
                var y = document.getElementById("angkaakhir").value;
                var acak = Math.floor((Math.random() * (y-x+1)) + parseInt(x));
                document.getElementById("hasilangka").value = acak;
            }, false);
        });
    </script>
    <script src="dist/js/vendor/jquery.min.js"></script>
    <script src="dist/js/vendor/video.js"></script>
    <script src="dist/js/flat-ui.min.js"></script>
    <script src="docs/assets/js/application.js"></script>
</body>
</html>