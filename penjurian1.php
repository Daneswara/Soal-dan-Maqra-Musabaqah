<?php
include "koneksi.php";
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
        header('location: penjurian.php?surat=' . $surat . '&ayat=' . $ayat);
    } else {
        echo "Gagal dalam menambahkan soal penjurian";
    }
}
if (isset($_GET['surat']) && isset($_GET['ayat'])) {
    $surat = $_GET['surat'];
    $ayat = $_GET['ayat'];
    $queryview = mysqli_query($koneksi, "SELECT * FROM `halaman` WHERE nosurat = $surat and ayatawal <= $ayat ORDER BY ayatawal DESC LIMIT 1") or die(mysqli_error($koneksi));
    $halaman = mysqli_fetch_array($queryview);
    $kanan = 1;
    if ($halaman['no_halaman'] % 2 == 1) {
        $kanan = $halaman['no_halaman'];
    } else {
        $kanan = $halaman['no_halaman'] - 1;
    }
}
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Flat UI - Free Bootstrap Framework and Theme</title>
        <meta name="description" content="Flat UI Kit Free is a Twitter Bootstrap Framework design and Theme, this responsive framework includes a PSD and HTML version."/>

        <meta name="viewport" content="width=1000, initial-scale=1.0, maximum-scale=1.0">

        <!-- Loading Bootstrap -->
        <link href="dist/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Loading Flat UI -->
        <link href="dist/css/flat-ui.css" rel="stylesheet">
        <link href="docs/assets/css/demo.css" rel="stylesheet">

        <link rel="shortcut icon" href="img/favicon.ico">

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
        </style>

        <div class="container">
            <nav class="navbar navbar-inverse navbar-lg navbar-embossed" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-8">
                        <span class="sr-only">Toggle navigation</span>
                    </button>
                    <a class="navbar-brand" href="#">Hifzhil Qur'an</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse-8">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Home</a></li>
                        <li class="active"><a href="penjurian.php">Penjurian</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pengaturan <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Bantuan</a></li>
                                <li><a href="login.php">Keluar</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
            <div class="row">
                <form action="" method="POST">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <select name="peserta" class="form-control select select-primary" data-toggle="select" required>
                                <option value="" selected="">Pilih Peserta</option>
                                <?php
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM peserta") or die(mysqli_error($koneksi));
                                if (mysqli_num_rows($query_mysql) == 0) {
                                    echo "<option value=''>Tidak Ada Peserta</option>";
                                } else {
                                    while ($data = mysqli_fetch_array($query_mysql)) {
                                        echo "<option value='" . $data['id'] . "'>" . $data['nama'] . " (" . $data['kategori'] . ")</option>";
                                    }
                                }
                                ?>
                            </select></div>
                    </div> <!-- /.col-xs-3 -->
                    <div class="col-xs-3">
                        <button class="btn btn-block btn-lg btn-primary">Acak Soal</button>
                    </div> <!-- /.col-xs-3 -->
                    <div class="col-xs-3">
                        <a href="mushaf.php?kanan=<?php echo $kanan; ?>&surah=<?php if (isset($_GET['surat'])) echo sprintf('%03u', $_GET['surat']) ?>&ayat=<?php if (isset($_GET['ayat'])) echo sprintf('%03u', $_GET['ayat']) ?>" class="btn btn-block btn-lg btn-primary">Lihat Mushaf</a>
                    </div> <!-- /.col-xs-3 -->
                </form>
            </div> <!-- /.row -->
            <div class="bigtext"><?php
                if (isset($_GET['surat'])) {
                    echo $_GET['surat'] . ":";
                } else {
                    echo "0:";
                }
                if (isset($_GET['ayat'])) {
                    echo $_GET['ayat'];
                } else {
                    echo "0";
                }
                ?></div>
        </div>

        <script src="dist/js/vendor/jquery.min.js"></script>
        <script src="dist/js/vendor/video.js"></script>
        <script src="dist/js/flat-ui.min.js"></script>
        <script src="docs/assets/js/application.js"></script>

    </body>