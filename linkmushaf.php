<?php
include "koneksi.php";
session_start();
if (empty($_SESSION['user_login'])) {
    header('location: login.php');
}
$queryview = mysqli_query($koneksi, "SELECT * FROM pengaturan LIMIT 1") or die(mysqli_error($koneksi));
$pengaturan = mysqli_fetch_array($queryview);
$acara = $pengaturan['acara'];
$acara = str_replace("<petik>", "'", $acara);
$logo = $pengaturan['logo'];
if(isset($_GET["surat1"]) && isset($_GET["ayat1"])){
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
                background-image: url("gambar/bg.jpg");
                background-repeat: repeat;
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
            <div style="text-align: center; padding: 20px"><b><?php echo $acara;?></b><img style="margin-top: -10px" height="50px" src="gambar/<?php echo $logo; ?>"></div>
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
                        <li ><a href="fahmil.php">Al-Hadits</a></li>
                        <li class="active"><a href="linkmushaf.php">Link Mushaf</a></li>
                        <li><a href="acak.php">Acak</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pengaturan <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="about.php">Bantuan</a></li>
                                <li><a href="login.php">Keluar</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
            <div class="row">
                <form method="GET" action="linkmushaf.php">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <select name="surat1" id="surat1" class="form-control select select-primary" data-toggle="select" required>
                                <?php
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah ORDER BY nosurat") or die(mysqli_error($koneksi));
                                $temp = "";
                                while ($data = mysqli_fetch_array($query_mysql)) {
                                    if ($data['nama'] == $temp) {

                                    } else if ($tempsurat == $data['nosurat']) {
                                        echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    } else {
                                        echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    }
                                    $temp = $data['nama'];
                                }
                                ?>

                            </select></div>
                    </div> <!-- /.col-xs-3 -->
                    <div class="col-xs-4">
                        <div class="form-group">
                            <select name="ayat1" id="ayat1" class="form-control select select-primary" data-toggle="select" required>

                                <?php
                                if (isset($tempayat)) {
                                    $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE nosurat = $tempsurat ORDER BY nosurat") or die(mysqli_error($koneksi));
                                    echo "edit surat" . $where;
                                    while ($data = mysqli_fetch_array($query_mysql)) {

                                        for ($a = $data['awal']; $a <= $data['akhir']; $a++) {
                                            if ($tempayat == $a) {
                                                echo "<option value=" . $a . " selected>" . $a . "</option>";
                                            } else {
                                                echo "<option value=" . $a . ">" . $a . "</option>";
                                            }
                                        }
                                    }
                                }
                                ?>

                            </select></div>
                    </div> <!-- /.col-xs-3 -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-block btn-lg btn-primary">Link Mushaf</button>
                    </div> <!-- /.col-xs-3 -->
                </form>
            </div> <!-- /.row -->

        </div>


        <script type="text/javascript">
            $(document).ready(function () {
                $("#surat1").change(function () {
                    $.post("ajax/ayatgoto.php", {surah: $("#surat1").val()})
                            .success(function (data) {
                                $("#ayat1").html(data);
                                $("#ayat1").change();
                            });
                });
                if ($("#ayat1").val() == "" || $("#ayat1").val() == "0" || $("#ayat1").val() == null) {
                    $.post("ajax/ayatgoto.php", {surah: $("#surat1").val()})
                            .success(function (data) {
                                $("#ayat1").html(data);
                                $("#ayat1").change();
                            });
                }
            });
        </script>
        <script src="dist/js/vendor/jquery.min.js"></script>
        <script src="dist/js/vendor/video.js"></script>
        <script src="dist/js/flat-ui.min.js"></script>
        <script src="docs/assets/js/application.js"></script>
    </body>
</html>
