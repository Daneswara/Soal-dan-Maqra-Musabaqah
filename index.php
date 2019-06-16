<?php
include "koneksi.php";
session_start();
$queryview = mysqli_query($koneksi, "SELECT * FROM pengaturan LIMIT 1") or die(mysqli_error($koneksi));
$pengaturan = mysqli_fetch_array($queryview);
$acara = $pengaturan['acara'];
$acara = str_replace("<petik>", "'", $acara);
$logo = $pengaturan['logo'];
if (empty($_SESSION['user_login'])) {
    header('location: login.php');
}
if (isset($_GET['paket'])) {
    $psoal = $_GET['paket'];
    $queryview = mysqli_query($koneksi, "SELECT * FROM paket WHERE id = $psoal") or die(mysqli_error($koneksi));
    $paketsoal = mysqli_fetch_array($queryview);
    $paket = $paketsoal['namapaket'];
    $query_mysql = mysqli_query($koneksi, "SELECT * FROM soal WHERE kategori = $psoal ORDER BY id") or die(mysqli_error($koneksi));

    $surat = array();
    $ayat = array();
    $kanan = array();
    $gambar = array();
    $i = 0;
    while ($data = mysqli_fetch_array($query_mysql)) {
        $surat[$i] = $data['surat'];
        $ayat[$i] = $data['ayat'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $namasurat2 = getNamaSurat($data['suratakhir']);
        if ($namasurat2 != "") {
            $namasurat2 = str_replace("'", "petik", $namasurat2);
            $akhirsoal[$i] = "&surahakhir=" . $data['suratakhir'] . "&ayatakhir=" . $data['ayatakhir'] . "&akhirnamasurat=$namasurat2";
        }
        $ig = $i + 1;
        $gambar[$i] = "gambar/kotak$ig.png";
        $i++;
    }
}
if (isset($_GET['soal1']) || isset($_GET['surat1'])) {
    $paket = "<br>Otomatis";
    $queryview = mysqli_query($koneksi, "SELECT * FROM pengaturan LIMIT 1") or die(mysqli_error($koneksi));
    $pengaturan = mysqli_fetch_array($queryview);
    $jumlahsoal = $pengaturan['jumlahsoal'];
    $jumlahsoalmudah = $pengaturan['jumlahsoalmudah'];
    $query_mysql = null;
    if ($jumlahsoal == 6) {
        $soal1 = $_GET['soal1'];
        $soal2 = $_GET['soal2'];
        $soal3 = $_GET['soal3'];
        $soal4 = $_GET['soal4'];
        $soal5 = $_GET['soal5'];
        $soal6 = $_GET['soal6'];
        $query_mysql = mysqli_query($koneksi, "SELECT * FROM mutasyabihat WHERE id = $soal1 OR id = $soal2 OR id = $soal3 OR id = $soal4 OR id = $soal5 OR id = $soal6") or die(mysqli_error($koneksi));
    } else if ($jumlahsoal == 5) {
        $soal1 = $_GET['soal1'];
        $soal2 = $_GET['soal2'];
        $soal3 = $_GET['soal3'];
        $soal4 = $_GET['soal4'];
        $soal5 = $_GET['soal5'];
        $query_mysql = mysqli_query($koneksi, "SELECT * FROM mutasyabihat WHERE id = $soal1 OR id = $soal2 OR id = $soal3 OR id = $soal4 OR id = $soal5") or die(mysqli_error($koneksi));
    } else if ($jumlahsoal == 4) {
        $soal1 = $_GET['soal1'];
        $soal2 = $_GET['soal2'];
        $soal3 = $_GET['soal3'];
        $soal4 = $_GET['soal4'];
        $query_mysql = mysqli_query($koneksi, "SELECT * FROM mutasyabihat WHERE id = $soal1 OR id = $soal2 OR id = $soal3 OR id = $soal4") or die(mysqli_error($koneksi));
    } else if ($jumlahsoal == 3) {
        $soal1 = $_GET['soal1'];
        $soal2 = $_GET['soal2'];
        $soal3 = $_GET['soal3'];
        $query_mysql = mysqli_query($koneksi, "SELECT * FROM mutasyabihat WHERE id = $soal1 OR id = $soal2 OR id = $soal3") or die(mysqli_error($koneksi));
    } else if ($jumlahsoal == 2) {
        $soal1 = $_GET['soal1'];
        $soal2 = $_GET['soal2'];
        $query_mysql = mysqli_query($koneksi, "SELECT * FROM mutasyabihat WHERE id = $soal1 OR id = $soal2") or die(mysqli_error($koneksi));
    } else if ($jumlahsoal == 1) {
        $soal1 = $_GET['soal1'];
        $query_mysql = mysqli_query($koneksi, "SELECT * FROM mutasyabihat WHERE id = $soal1") or die(mysqli_error($koneksi));
    }
    $surat = array();
    $ayat = array();
    $kanan = array();
    $gambar = array();
    $i = 0;

    if ($jumlahsoalmudah == 1) {
        $surat[$i] = $_GET['surat1'];
        $ayat[$i] = $_GET['ayat1'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";
        $i++;
    } else if ($jumlahsoalmudah == 2) {
        $surat[$i] = $_GET['surat1'];
        $ayat[$i] = $_GET['ayat1'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";

        $i++;
        $surat[$i] = $_GET['surat2'];
        $ayat[$i] = $_GET['ayat2'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";
        $i++;
    } else if ($jumlahsoalmudah == 3) {
        $surat[$i] = $_GET['surat1'];
        $ayat[$i] = $_GET['ayat1'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";

        $i++;
        $surat[$i] = $_GET['surat2'];
        $ayat[$i] = $_GET['ayat2'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";

        $i++;
        $surat[$i] = $_GET['surat3'];
        $ayat[$i] = $_GET['ayat3'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";
        $i++;
    } else if ($jumlahsoalmudah == 4) {
        $surat[$i] = $_GET['surat1'];
        $ayat[$i] = $_GET['ayat1'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";

        $i++;
        $surat[$i] = $_GET['surat2'];
        $ayat[$i] = $_GET['ayat2'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";

        $i++;
        $surat[$i] = $_GET['surat3'];
        $ayat[$i] = $_GET['ayat3'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";

        $i++;
        $surat[$i] = $_GET['surat4'];
        $ayat[$i] = $_GET['ayat4'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";
        $i++;
    } else if ($jumlahsoalmudah == 5) {
        $surat[$i] = $_GET['surat1'];
        $ayat[$i] = $_GET['ayat1'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";

        $i++;
        $surat[$i] = $_GET['surat2'];
        $ayat[$i] = $_GET['ayat2'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";

        $i++;
        $surat[$i] = $_GET['surat3'];
        $ayat[$i] = $_GET['ayat3'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";

        $i++;
        $surat[$i] = $_GET['surat4'];
        $ayat[$i] = $_GET['ayat4'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";

        $i++;
        $surat[$i] = $_GET['surat5'];
        $ayat[$i] = $_GET['ayat5'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";
        $i++;
    } else if ($jumlahsoalmudah == 6) {
        $surat[$i] = $_GET['surat1'];
        $ayat[$i] = $_GET['ayat1'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";

        $i++;
        $surat[$i] = $_GET['surat2'];
        $ayat[$i] = $_GET['ayat2'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";

        $i++;
        $surat[$i] = $_GET['surat3'];
        $ayat[$i] = $_GET['ayat3'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";

        $i++;
        $surat[$i] = $_GET['surat4'];
        $ayat[$i] = $_GET['ayat4'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";

        $i++;
        $surat[$i] = $_GET['surat5'];
        $ayat[$i] = $_GET['ayat5'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";

        $i++;
        $surat[$i] = $_GET['surat6'];
        $ayat[$i] = $_GET['ayat6'];
        $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
        $namasurat[$i] = getNamaSurat($surat[$i]);

        $ig = $i + 1;
        $gambar[$i] = "gambar/okotak$ig.png";
        $i++;
    }

    if ($query_mysql != null) {
        while ($data = mysqli_fetch_array($query_mysql)) {
            $nos = $data['nosurat'];
            $noa = $data['ayat'];
            $idnya = $data['id'];
            $acakmanual = mysqli_query($koneksi, "INSERT INTO penjurian VALUES('', $nos, $noa)") or die(mysqli_error($koneksi));
            $deletedata = mysqli_query($koneksi, "DELETE FROM mutasyabihat WHERE id=$idnya") or die(mysqli_error($koneksi));
            $surat[$i] = $nos;
            $ayat[$i] = $noa;
            $kanan[$i] = getHalaman($surat[$i], $ayat[$i]);
            $namasurat[$i] = getNamaSurat($surat[$i]);

            $ig = $i + 1;
            $gambar[$i] = "gambar/kotak$ig.png";
            $i++;
        }
    }
}

// edit tampilan kotak soal
if (isset($_POST['peserta'])) {
    $id = $_POST['peserta'];
    $queryview = mysqli_query($koneksi, "SELECT * FROM peserta WHERE id = $id") or die(mysqli_error($koneksi));
    $peserta = mysqli_fetch_array($queryview);
    $kat = $peserta['kategori'];

    if ($kat == '10 Juz') {
        $querysoal = mysqli_query($koneksi, "SELECT * FROM soal WHERE kategori = '5 Juz' OR kategori = '10 Juz'") or die(mysqli_error($koneksi));
    } else if ($kat == '20 Juz') {
        $querysoal = mysqli_query($koneksi, "SELECT * FROM soal WHERE kategori = '5 Juz' OR kategori = '10 Juz' OR kategori = '20 Juz'") or die(mysqli_error($koneksi));
    } else {
        $querysoal = mysqli_query($koneksi, "SELECT * FROM soal WHERE kategori = '5 Juz'") or die(mysqli_error($koneksi));
    }
    $jumlahsoal = mysqli_num_rows($querysoal);
    $i = 1;
    $random = rand(1, $jumlahsoal);
    $surat = 0;
    $ayat = 0;
    while ($data = mysqli_fetch_array($querysoal)) {
        if ($i == $random) {
            $surat = $data['surat'];
            $ayat = $data['ayat'];
        }
        $i++;
    }

    $querytambah = mysqli_query($koneksi, "INSERT INTO penjurian VALUES(NULL, '$id', '$surat', '$ayat')") or die(mysqli_error($koneksi));
    if ($querytambah) {
        header('location: index.php?surat=' . $surat . '&ayat=' . $ayat);
    } else {
        echo "Gagal dalam menambahkan soal penjurian";
    }
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
            $pilihan = $_GET['pilihan'];
            $notifikasi = $_GET['note'];
            if ($notifikasi == 1) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Paket soal telah diacak', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 12) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Paket soal telah habis, silahkan buat paket soal lagi atau gunakan Acak Otomatis!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
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
                /*padding-top: 20px;*/
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
            <div style="text-align: center; margin-left: -220px; padding: 20px"><b><?php echo $acara;?></b><img style="margin-top: -10px" height="50px" src="gambar/<?php echo $logo; ?>"></div>
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
                        <li class="active"><a href="index.php">Tilawah dan MHQ</a></li>
                        <li ><a href="tafsir.php">Tafsir</a></li>
                        <li ><a href="fahmil.php">AL-HADITS</a></li>
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
            <div class="row">
                
                <form method="GET">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <select name="kategori" class="form-control select select-primary" data-toggle="select" required>
                                <?php
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM kategori WHERE nama != 'Tafsir' ORDER BY urutan") or die(mysqli_error($koneksi));

                                while ($data = mysqli_fetch_array($query_mysql)) {
                                    if ($pilihan == $data['index'] . "_" . $data['id']) {
                                        echo "<option value=" . $data['index'] . "_" . $data['id'] . " selected> " . $data['jenis'] . " " . $data['nama'] . " (Juz " . $data['index'] . ")" . "</option>";
                                    } else {
                                        echo "<option value=" . $data['index'] . "_" . $data['id'] . "> " . $data['jenis'] . " " . $data['nama'] . " (Juz " . $data['index'] . ")" . "</option>";
                                    }
                                }
                                ?>

                            </select></div>
                    </div> <!-- /.col-xs-3 -->
                    <div class="col-xs-3">
                        <button type="submit" formaction="acakpaket.php" class="btn btn-block btn-lg btn-primary">Acak Paket</button>
                    </div> <!-- /.col-xs-3 -->
                    <div class="col-xs-3">
                        <button type="submit" formaction="acakmanual.php" class="btn btn-block btn-lg btn-primary">Acak Otomatis</button>
                    </div> <!-- /.col-xs-3 -->
                </form>
            </div> <!-- /.row -->
            <body>
                <style>
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
                        padding-top: 30%;
                        padding-right: 45px;
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
                        margin-top: -200px;
                        z-index: 10;
                    }
                    img {
                        z-index: 1;
                        position: absolute;
                    }
                </style>


                <div class="row" id="kotak1" name="kotak1" style="padding-left: 25px">
                    <div class="kotak" <?php
                    if (isset($paket)) {
                        echo "onclick='showSoal()'";
                    }
                    ?> >
                        <img src="gambar/kotak.png" class="img-responsive center-block">
                        <!--<dl class="palette palette-alizarin" style="height: 200px">-->
                        <?php
                        if (isset($paket)) {
                            echo '<h5><div class="tengah2" style="padding-top: 50px; padding-left: 25px">Paket ';
                            echo $paket;
                        } else {
                            echo '<h5><div class="tengah2" style="padding-top: 50px; padding-left: 25px">Paket ';
                            echo "?";
                        };
                        ?></div></h5>
                    <!--</dl>-->
                </div>
        </div>
        <br><!-- /.row -->
        <div class="row" id="kotak2" name="kotak2">
            <?php
            if (!isset($surat[1]) && !isset($surat[2]) && !isset($surat[3]) && !isset($surat[4]) && !isset($surat[5])) {
                $margin = "370px";
            } else if (!isset($surat[2]) && !isset($surat[3]) && !isset($surat[4]) && !isset($surat[5])) {
                $margin = "250px";
            } else if (!isset($surat[3]) && !isset($surat[4]) && !isset($surat[5])) {
                $margin = "125px";
            } else if (!isset($surat[4]) && !isset($surat[5])) {
                $margin = "125px";
                $margin1 = "370px";
                $margin2 = "110px";
            } else if (!isset($surat[5])) {
                $margin = "125px";
                $margin1 = "245px";
                $margin2 = "110px";
            } else {
                $margin = "125px";
                $margin1 = "125px";
                $margin2 = "110px";
            }
            if (isset($surat[0])) {
                $namasurat1 = str_replace("'", "petik", $namasurat[0]);
                if (isset($akhirsoal[0])) {
                    echo "<a target='_blank' href='mushaf.php?kanan=$kanan[0]&surah=$surat[0]&ayat=$ayat[0]&namasurat=$namasurat1$akhirsoal[0]'>";
                } else {
                    echo "<a target='_blank' href='mushaf.php?kanan=$kanan[0]&surah=$surat[0]&ayat=$ayat[0]&namasurat=$namasurat1'>";
                }
            }
            ?>
            <div class="col-xs-3 col-md-3" style="margin-left: <?php echo $margin; ?>">
                <img src="<?php echo $gambar[0]; ?>" class="img-responsive center-block">
                <!--                        <dl class="palette palette-alizarin" style="height: 140px">-->
                <dt><div class="tengah2"><?php
                    if (isset($surat[0])) {
                        echo "QS: " . $namasurat[0] . " " . $surat[0] . " : " . $ayat[0];
                    }
                    ?></div></dt>
                <!--</dl>-->
            </div>
            <?php
            if (isset($surat[0])) {
                echo "</a>";
            }
            if (isset($surat[1])) {
                $namasurat1 = str_replace("'", "petik", $namasurat[1]);
                if (isset($akhirsoal[1])) {
                    echo "<a target='_blank' href='mushaf.php?kanan=$kanan[1]&surah=$surat[1]&ayat=$ayat[1]&namasurat=$namasurat1$akhirsoal[1]'>";
                } else {
                    echo "<a target='_blank' href='mushaf.php?kanan=$kanan[1]&surah=$surat[1]&ayat=$ayat[1]&namasurat=$namasurat1'>";
                }
            }
            ?>
            <div class="col-xs-3 col-md-3" <?php
            if (!isset($surat[1])) {
                echo "hidden";
            }
            ?>>
                <img src="<?php echo $gambar[1]; ?>" class="img-responsive center-block">
                <!--<dl class="palette palette-alizarin" style="height: 140px">-->
                <dt><div class="tengah2"><?php
                    if (isset($surat[1])) {
                        echo "QS: " . $namasurat[1] . " " . $surat[1] . " : " . $ayat[1];
                    }
                    ?></div></dt>
                <!--</dl>-->
            </div>

            <?php
            if (isset($surat[1])) {
                echo "</a>";
            }
            if (isset($surat[2])) {
                $namasurat1 = str_replace("'", "petik", $namasurat[2]);
                if (isset($akhirsoal[2])) {
                    echo "<a target='_blank' href='mushaf.php?kanan=$kanan[2]&surah=$surat[2]&ayat=$ayat[2]&namasurat=$namasurat1$akhirsoal[2]'>";
                } else {
                    echo "<a target='_blank' href='mushaf.php?kanan=$kanan[2]&surah=$surat[2]&ayat=$ayat[2]&namasurat=$namasurat1'>";
                }
            }
            ?>
            <div class="col-xs-3 col-md-3" <?php
            if (!isset($surat[2])) {
                echo "hidden";
            }
            ?>>
                <img src="<?php echo $gambar[2]; ?>" class="img-responsive center-block">
                <!--<dl class="palette palette-alizarin" style="height: 140px">-->
                <dt><div class="tengah2"><?php
                    if (isset($surat[2])) {
                        echo "QS: " . $namasurat[2] . " " . $surat[2] . " : " . $ayat[2];
                    }
                    ?></div></dt>
                <!--</dl>-->
            </div>
            <?php
            if (isset($surat[2])) {
                echo "</a>";
            }
            if (isset($surat[3])) {
                $namasurat1 = str_replace("'", "petik", $namasurat[3]);
                if (isset($akhirsoal[3])) {
                    echo "<a target='_blank' href='mushaf.php?kanan=$kanan[3]&surah=$surat[3]&ayat=$ayat[3]&namasurat=$namasurat1$akhirsoal[3]'>";
                } else {
                    echo "<a target='_blank' href='mushaf.php?kanan=$kanan[3]&surah=$surat[3]&ayat=$ayat[3]&namasurat=$namasurat1'>";
                }
            }
            ?>
            <div class="col-xs-3 col-md-3" style="margin-left: <?php echo $margin1; ?>; margin-top: <?php echo $margin2; ?> " <?php
            if (!isset($surat[3])) {
                echo "hidden";
            }
            ?>>
                <img src="<?php echo $gambar[3]; ?>" class="img-responsive center-block">
                <!--<dl class="palette palette-alizarin" style="height: 140px">-->
                <dt><div class="tengah2"><?php
                    if (isset($surat[3])) {
                        echo "QS: " . $namasurat[3] . " " . $surat[3] . " : " . $ayat[3];
                    }
                    ?></div></dt>
                <!--</dl>-->
            </div>
            <?php
            if (isset($surat[3])) {
                echo "</a>";
            }
            if (isset($surat[4])) {
                $namasurat1 = str_replace("'", "petik", $namasurat[4]);
                if (isset($akhirsoal[4])) {
                    echo "<a target='_blank' href='mushaf.php?kanan=$kanan[4]&surah=$surat[4]&ayat=$ayat[4]&namasurat=$namasurat1$akhirsoal[4]'>";
                } else {
                    echo "<a target='_blank' href='mushaf.php?kanan=$kanan[4]&surah=$surat[4]&ayat=$ayat[4]&namasurat=$namasurat1'>";
                }
            }
            ?>
            <div class="col-xs-3 col-md-3" style="margin-top: <?php echo $margin2; ?> "<?php
            if (!isset($surat[4])) {
                echo "hidden";
            }
            ?>>
                <img src="<?php echo $gambar[4]; ?>" class="img-responsive center-block">
                <!--<dl class="palette palette-alizarin" style="height: 140px">-->
                <dt><div class="tengah2"><?php
                    if (isset($surat[4])) {
                        echo "QS: " . $namasurat[4] . " " . $surat[4] . " : " . $ayat[4];
                    }
                    ?></div></dt>
                <!--</dl>-->
            </div>
            <?php
            if (isset($surat[4])) {
                echo "</a>";
            }
            if (isset($surat[5])) {
                $namasurat1 = str_replace("'", "petik", $namasurat[5]);
                if (isset($akhirsoal[5])) {
                    echo "<a target='_blank' href='mushaf.php?kanan=$kanan[5]&surah=$surat[5]&ayat=$ayat[5]&namasurat=$namasurat1$akhirsoal[5]'>";
                } else {
                    echo "<a target='_blank' href='mushaf.php?kanan=$kanan[5]&surah=$surat[5]&ayat=$ayat[5]&namasurat=$namasurat1'>";
                }
            }
            ?>
            <div class="col-xs-3 col-md-3" style="margin-top: <?php echo $margin2; ?> "<?php
            if (!isset($surat[5])) {
                echo "hidden";
            }
            ?>>
                <img src="<?php echo $gambar[5]; ?>" class="img-responsive center-block">
                <!--<dl class="palette palette-alizarin" style="height: 140px">-->
                <dt><div class="tengah2"><?php
                    if (isset($surat[5])) {
                        echo "QS: " . $namasurat[5] . " " . $surat[5] . " : " . $ayat[5];
                    }
                    ?></div></dt>
                <!--</dl>-->
            </div>
            <?php
            if (isset($surat[5])) {
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
