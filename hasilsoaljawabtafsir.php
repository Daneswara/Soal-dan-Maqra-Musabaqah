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
function getNamaSurat($surat) {
    include "koneksi.php";
    $queryview = mysqli_query($koneksi, "SELECT * FROM `daftarsurah` WHERE nosurat = $surat LIMIT 1") or die(mysqli_error($koneksi));
    $surah = mysqli_fetch_array($queryview);
    $namasurat = $surah['nama'];
    return $namasurat;
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

$id_paket = 0;
if (isset($_GET['nopaket'])) {
    $id_paket = $_GET['nopaket'];
    $soalke = $_GET['soalke'];
    $dbsoal = array();
    $dbjawab = array();
    $dbsoalke = array();
    $query_view = mysqli_query($koneksi, "SELECT * FROM soal_tafsir WHERE paket = '$id_paket' ORDER BY soalke") or die(mysqli_error($koneksi));
    $i = 0;
    while ($data = mysqli_fetch_array($query_view)) {
        $dbsoal[$i] = $data['soal'];
        $dbjawab[$i] = $data['jawaban'];
        $dbsoalke[$i] = $data['soalke'];
        $i++;
    }
} else {
    header('location: index.php');
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
        <script src="js/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="js/sweetalert.css">
        <!-- Loading Flat UI -->
        <link href="dist/css/flat-ui.css" rel="stylesheet">
        <link href="docs/assets/css/demo.css" rel="stylesheet">
        <script src="js/jquery-1.10.2.js"></script>
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
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: '1 Data Juri telah ditambahkan', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 12) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Data Juri tidak dapat ditambahkan, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 2) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Data Juri telah diedit', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 21) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Data Juri tidak dapat diedit, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 3) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Data Juri telah dihapus', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 31) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Data Juri tidak dapat dihapus, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            }
        }
        ?>
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
        </style>

        <div class="container">
            <div style="text-align: center; padding: 20px"><b><?php echo $acara;?></b><img style="margin-top: -10px" width="220px" src="gambar/<?php echo $logo; ?>"></div>
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
                        <li class="active"><a href="tafsir.php">Tafsir</a></li>
                        <li><a href="fahmil.php">MFQ</a></li>
                        <li><a href="linkmushaf.php">Link Mushaf</a></li>
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
            <div class="col-xs-2">
                <div class="form-group">
                    <button class="btn btn-block btn-lg btn-primary" onclick="window.close();"> Kembali</button>
                </div>
            </div>
            <div class="col-xs-10">
                <div class="form-group">
                    <button class="btn btn-block btn-lg btn-danger" onclick="#"> Paket Soal - <?php echo $id_paket; ?></button>
                </div>
            </div>


            <?php
            $i = $soalke;
            if ($i == 1) {
                $soalnya = $dbsoal[$i - 1];
                $datasoal1 = explode("-", $soalnya);
//                    $namasurat = getNamaSurat($datasoal1[0]);
                // batas
                $surat = $datasoal1[0];
                $ayat = $datasoal1[1];
                $hal = getHalaman($surat, $ayat);
                $namasurat = getNamaSurat($surat);
                $namasurat = str_replace("'", "petik", $namasurat);
                $link = "mushaf.php?kanan=$hal&surah=$surat&ayat=$ayat&namasurat=$namasurat";
                // batas link
                echo '<div class="col-xs-12"><div class="col-xs-2">
                        <div class="form-group">
                            Soal ke-' . $i . '
                        </div></div>
                    <div class="col-xs-10"><div class="form-group">
                    <a href="' . $link . '" class="btn btn-block btn-lg btn-primary" target="_black"> ' . getNamaSurat($datasoal1[0]) . ' : ' . $datasoal1[1] . ' </a>
                    </div></div></div>';
            } else {

                if (isset($dbsoalke[$i - 1])) {
                    if ($dbsoalke[($i - 1)] == $i) {
                        echo '<div class="col-xs-12"><div class="col-xs-2">
                        <div class="form-group">
                            Soal ke-' . $i . '
                        </div></div>
                    <div class="col-xs-10">
                        <div class="form-group">';
                        echo '<textarea style="height: 200px" type="text" id="soal' . $i . '" name="soal' . $i . '" placeholder="Isikan soal nomer ' . $i . '" class="form-control">' . $dbsoal[($i - 1)] . '</textarea>';
                        echo '</div>
                    </div> <!-- /.col-xs-3 -->
                    <div class="col-xs-2">
                        <div class="form-group">
                            Jawaban ke-' . $i . '
                        </div></div>
                    <div class="col-xs-10">
                    <button id="bukajawaban" class="btn btn-block btn-lg btn-danger" onclick="showJawaban()" style="margin-bottom:20px">Lihat Jawaban</button>
                        <div class="form-group" id="jawaban">';
                        echo '<textarea style="height: 200px" type="text" id="jawaban' . $i . '" name="jawaban' . $i . '" placeholder="Isikan jawaban nomer ' . $i . '" class="form-control">' . $dbjawab[($i - 1)] . '</textarea>';
                    }
                }
                echo '</div>
                    </div></div>';
            }
            ?>
            <!-- /.col-xs-3 -->


            <!-- /.col-xs-3 -->

        </div></form>
    <script type="text/javascript">
        document.getElementById('jawaban').style.visibility = 'hidden';
                function showJawaban() {
                    document.getElementById('jawaban').style.visibility = 'visible';
                }
        $(document).ready(function () {
            for (i = 1; i <= 15; i++) {
                document.getElementById("soal" + i).addEventListener('keyup', function () {
                    this.style.overflow = 'hidden';
                    this.style.height = this.scrollHeight + 'px';
                }, false);
                document.getElementById("jawaban" + i).addEventListener('keyup', function () {
                    this.style.overflow = 'hidden';
                    this.style.height = this.scrollHeight + 'px';
                }, false);
            }
        });
    </script>
    <script src="dist/js/vendor/jquery.min.js"></script>
    <script src="dist/js/vendor/video.js"></script>
    <script src="dist/js/flat-ui.min.js"></script>
    <script src="docs/assets/js/application.js"></script>

</body>
