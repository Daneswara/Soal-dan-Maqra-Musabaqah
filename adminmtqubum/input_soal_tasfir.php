<?php
include "../koneksi.php";
session_start();
if (empty($_SESSION['admin_login'])) {
    header('location: login.php');
}
if (isset($_GET['jenis'])) {
    $jenis = $_GET['jenis'];
    $id_paket = $_GET['id'];
}
$queryview = mysqli_query($koneksi, "SELECT * FROM pengaturan LIMIT 1") or die(mysqli_error($koneksi));
$pengaturan = mysqli_fetch_array($queryview);
$acara = $pengaturan['acara'];
$acara = str_replace("<petik>", "'", $acara);
$logo = $pengaturan['logo'];
if (isset($_GET['tambah']) && isset($_POST['surat1']) && isset($_POST['ayat1'])) {
    $surat = $_POST["surat1"];
    $ayat = $_POST["ayat1"];
    $jenis = $_GET['jenis'];
    $id_kategori = $_GET['id'];
    $hal = getHalaman($surat, $ayat);
    $namasurat = getNamaSurat($surat);
    $namasurat = str_replace("'", "petik", $namasurat);
    $link = "mushaf.php?kanan=$hal&surah=$surat&ayat=$ayat&namasurat=$namasurat";

    // tambah paket
    $cekisipaket = mysqli_query($koneksi, "SELECT * FROM paket WHERE id_kategori=$id_kategori") or die(mysqli_error($koneksi));
    $cek = mysqli_num_rows($cekisipaket);
    $cek = $cek + 1;
    $querypaket = mysqli_query($koneksi, "INSERT INTO paket VALUES(NULL, $id_kategori, '1-30', '$id_kategori-$cek');") or die(mysqli_error($koneksi));
    if ($querypaket) {
        //header('location: index.php?note=3');
    } else {
        header('location: index.php?note=31');
    }
    // tambah soal
    $queryview = mysqli_query($koneksi, "SELECT * FROM paket ORDER BY id DESC LIMIT 1") or die(mysqli_error($koneksi));
    $paket = mysqli_fetch_array($queryview);
    $id_paket = $paket['id'];
    $querytambah = mysqli_query($koneksi, "INSERT INTO soal_tafsir VALUES(NULL, $id_paket, 1, '$surat-$ayat', '$link');") or die(mysqli_error($koneksi));
    if ($querytambah) {
        //header('location: index.php?note=3');
    } else {
        header('location: index.php?note=31');
    }
    $i = 2;
    while (isset($_POST["soal$i"]) && isset($_POST["jawaban$i"]) && $_POST["soal$i"] != "" && $_POST["jawaban$i"] != "") {
        $tempsoal = $_POST["soal$i"];
        $tempjawaban = $_POST["jawaban$i"];
        $querytambah = mysqli_query($koneksi, "INSERT INTO soal_tafsir VALUES(NULL, $id_paket, '$i', '$tempsoal', '$tempjawaban');") or die(mysqli_error($koneksi));
        if ($querytambah) {
            //header('location: index.php?note=3');
        } else {
            header('location: index.php?note=31');
        }
        $i++;
    }
    header('location: index.php?note=3');
}
if (isset($_GET['update'])) {
    $jenis = $_GET['jenis'];
    $id_paket = $_GET['id'];
    if (isset($_POST["surat1"]) && isset($_POST["ayat1"])) {
        $surat = $_POST["surat1"];
        $ayat = $_POST["ayat1"];
        $hal = getHalaman($surat, $ayat);
        $namasurat = getNamaSurat($surat);
        $namasurat = str_replace("'", "petik", $namasurat);
        $link = "mushaf.php?kanan=$hal&surah=$surat&ayat=$ayat&namasurat=$namasurat";

        // edit soal
        $querytambah = mysqli_query($koneksi, "UPDATE soal_tafsir SET soal = '$surat-$ayat', jawaban = '$link' WHERE paket = $id_paket AND soalke = 1;") or die(mysqli_error($koneksi));
        if ($querytambah) {
            //header('location: index.php?note=3');
        } else {
            header('location: index.php?note=41');
        }
    }
    $i = 2;
    while (isset($_POST["soal$i"]) || isset($_POST["jawaban$i"]) && $_POST["soal$i"] != "" || $_POST["jawaban$i"] != "") {
        $tempsoal = $_POST["soal$i"];
        $tempjawaban = $_POST["jawaban$i"];
        $querytambah = mysqli_query($koneksi, "UPDATE soal_tafsir SET soal = '$tempsoal', jawaban = '$tempjawaban' WHERE paket = $id_paket AND soalke = $i;") or die(mysqli_error($koneksi));
        if ($querytambah) {
            //header('location: index.php?note=3');
        } else {
            header('location: index.php?note=41');
        }
        $i++;
    }
    header('location: index.php?note=4');
}

function getNamaSurat($surat) {
    include "../koneksi.php";
    $queryview = mysqli_query($koneksi, "SELECT * FROM `daftarsurah` WHERE nosurat = $surat LIMIT 1") or die(mysqli_error($koneksi));
    $surah = mysqli_fetch_array($queryview);
    $namasurat = $surah['nama'];
    return $namasurat;
}

function getHalaman($surat, $ayat) {
    include "../koneksi.php";
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

if (isset($_GET['deletepaket'])) {
    $id = $_GET['deletepaket'];
    $queryhapus = mysqli_query($koneksi, "DELETE FROM `soal_tafsir` WHERE `paket` = $id;");
    if ($queryhapus) {
        $queryhapus2 = mysqli_query($koneksi, "DELETE FROM paket WHERE id = $id;");
        if ($queryhapus2) {
            header('location: index.php?note=5');
        } else {
            header('location: index.php?note=51');
        }
    } else {
        header('location: index.php?note=51');
    }
}
if (isset($_GET['namapaket']) && isset($_GET['nopaket'])) {
    $jenis = $_GET['namapaket'];
    $id_paket = $_GET['nopaket'];
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
}
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>SOAL DAN MAQRA' MUSABAQAH</title>
        <meta name="description" content="Flat UI Kit Free is a Twitter Bootstrap Framework design and Theme, this responsive framework includes a PSD and HTML version."/>

        <meta name="viewport" content="width=1000, initial-scale=1.0, maximum-scale=1.0">

        <!-- Loading Bootstrap -->
        <link href="../dist/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="../js/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../js/sweetalert.css">
        <!-- Loading Flat UI -->
        <link href="../dist/css/flat-ui.css" rel="stylesheet">
        <link href="../docs/assets/css/demo.css" rel="stylesheet">
        <script src="../js/jquery-1.10.2.js"></script>
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
        <script type='text/javascript'>
            function konfirmasi(id) {
                swal({title: 'Apakah anda yakin ingin mengapus?',
                    text: 'anda tidak akan dapat mengembalikan data yang telah dihapus!',
                    confirmButtonColor: '#DD6B55',
                    closeOnConfirm: false,
                    confirmButtonText: 'Iya hapus!', cancelButtonText: 'Batal',
                    showCancelButton: true,
                    type: 'warning'},
                function () {
                    window.location = "juri.php?delete=" + id;
                });
            }
            function hapusPaket(id) {
                swal({title: 'Apakah anda yakin ingin mengapus paket?',
                    text: 'anda tidak akan dapat mengembalikan paket soal yang telah dihapus!',
                    confirmButtonColor: '#DD6B55',
                    closeOnConfirm: false,
                    confirmButtonText: 'Iya hapus!', cancelButtonText: 'Batal',
                    showCancelButton: true,
                    type: 'warning'},
                function () {
                    window.location = "index.php?deletepaket=" + id;
                });
            }
        </script>
        <style>
            body {
                padding-bottom: 20px;
                padding-top: 20px;
                background-image: url("../gambar/bg.jpg");
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
            <div style="text-align: center; padding: 20px"><b><?php echo $acara;?></b><img style="margin-top: -10px" height="50px" src="../gambar/<?php echo $logo; ?>"></div>
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
                        <li><a href="index.php">Bank Soal</a></li>
                        <li><a href="fahmil.php">Bank Soal MFQ</a></li>
                        <li><a href="juri.php">Daftar Petugas</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pengaturan <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="about.php">Tentang</a></li>
                                <li><a href="pengaturan.php">Pengaturan</a></li>
                                <li><a href="login.php">Keluar</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
            <div class="col-xs-12">
                <div class="form-group">
                    <button class="btn btn-block btn-lg btn-danger" onclick="#">Tambah Paket Soal - <?php echo $jenis; ?></button>
                </div>
            </div>


            <?php
            if (isset($_GET['nopaket'])) {
                $id_paket = $_GET['nopaket'];
                echo "<form action='input_soal_tasfir.php?update=1&id=$id_paket&jenis=$jenis' method='POST'>
                <div class='row'>";
            } else {
                echo "<form action='input_soal_tasfir.php?tambah=1&id=$id_paket&jenis=$jenis' method='POST'>
                <div class='row'>";
            }
            $jumlahsoal = 15;
            for ($i = 1; $i <= $jumlahsoal; $i++) {
                if ($i == 1) {
                    echo '<div class="col-xs-12"><div class="col-xs-2">
                        <div class="form-group">
                            Soal ke-' . $i . '
                        </div></div>
                    <div class="col-xs-5"><div class="form-group"><select name="surat1" id="surat1" class="form-control select select-primary" data-toggle="select" required>';

                    $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah ORDER BY nosurat") or die(mysqli_error($koneksi));
                    $temp = "";
                    if (isset($dbsoal[0])) {
                        $soalpertama = explode("-", $dbsoal[0]);
                    }
                    while ($data = mysqli_fetch_array($query_mysql)) {
                        if (isset($dbsoal[0])) {
                            $soalpertama = explode("-", $dbsoal[0]);
                            if ($data['nama'] == $temp) {

                            } else if ($soalpertama[0] == $data['nosurat']) {
                                echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                            }
                        } else {
                            if ($data['nama'] == $temp) {

                            } else {
                                echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                            }
                        }
                        $temp = $data['nama'];
                    }

                    echo '</select></div></div> <!-- /.col-xs-3 -->
                    <div class="col-xs-5">
                        <div class="form-group">
                            <select name="ayat1" id="ayat1" class="form-control select select-primary" data-toggle="select" required>';

                    if (isset($soalpertama[0])) {
                        $tempsurat = $soalpertama[0];
                        $tempayat = $soalpertama[1];
                        $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE nosurat = $tempsurat ORDER BY nosurat") or die(mysqli_error($koneksi));
                        //echo "edit surat" . $where;
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
                    echo '</select></div>
                    </div></div>';
                } else {
                    echo '<div class="col-xs-12"><div class="col-xs-2">
                        <div class="form-group">
                            Soal ke-' . $i . '
                        </div></div>
                    <div class="col-xs-5">
                        <div class="form-group">';
                    if (isset($dbsoalke[$i - 1])) {
                        if ($dbsoalke[($i - 1)] == $i) {
                            echo '<textarea id="soal' . $i . '" type="text" spellcheck="false" name="soal' . $i . '" placeholder="Isikan soal nomer ' . $i . '" class="form-control">' . $dbsoal[($i - 1)] . '</textarea>';
                        } else {
                            echo '<textarea id="soal' . $i . '" type="text" spellcheck="false" name="soal' . $i . '" placeholder="Isikan soal nomer ' . $i . '" class="form-control" disabled></textarea>';
                        }
                    } elseif (isset($_GET['nopaket'])) {
                        echo '<textarea id="soal' . $i . '" type="text" spellcheck="false" name="soal' . $i . '" placeholder="Isikan soal nomer ' . $i . '" class="form-control" disabled></textarea>';
                    } else {
                        echo '<textarea id="soal' . $i . '" type="text" spellcheck="false" name="soal' . $i . '" placeholder="Isikan soal nomer ' . $i . '" class="form-control"></textarea>';
                    }

                    echo '</div>
                    </div> <!-- /.col-xs-3 -->
                    <div class="col-xs-5">
                        <div class="form-group">';
                    if (isset($dbsoalke[$i - 1])) {
                        if ($dbsoalke[($i - 1)] == $i) {
                            echo '<textarea id="jawaban' . $i . '" type="text" spellcheck="false" name="jawaban' . $i . '" placeholder="Isikan jawaban nomer ' . $i . '" class="form-control">' . $dbjawab[($i - 1)] . '</textarea>';
                        } else {
                            echo '<textarea id="jawaban' . $i . '" type="text" spellcheck="false" name="jawaban' . $i . '" placeholder="Isikan jawaban nomer ' . $i . '" class="form-control" disabled></textarea>';
                        }
                    } elseif (isset($_GET['nopaket'])) {
                        echo '<textarea id="jawaban' . $i . '" type="text" spellcheck="false" name="jawaban' . $i . '" placeholder="Isikan jawaban nomer ' . $i . '" class="form-control" disabled></textarea>';
                    } else {
                        echo '<textarea id="jawaban' . $i . '" type="text" spellcheck="false" name="jawaban' . $i . '" placeholder="Isikan jawaban nomer ' . $i . '" class="form-control"></textarea>';
                    }

                    echo '</div>
                    </div></div>';
                }
            }
            ?>
            <!-- /.col-xs-3 -->

            <?php
            if (isset($_GET['nopaket'])) {
                echo '<div class="col-xs-offset-2 col-xs-5">';
                echo "<div class='btn btn-block btn-lg btn-danger' onclick='hapusPaket(" . $_GET['nopaket'] . ");'>Delete Paket Soal</div></div>";
                echo '<div class="col-xs-5">';
                echo "<button type='submit' class='btn btn-block btn-lg btn-primary'>Edit Paket Soal</button></div>";
            } else {
                echo '<div class="col-xs-offset-2 col-xs-10">';
                echo '<button class="btn btn-block btn-lg btn-primary">Tambah Paket Soal Tafsir</button></div>';
            }
            ?>

            <!-- /.col-xs-3 -->

        </div></form>

    <div id="popup">
        <div class="window">
            <?php
            $id = $_GET['edit'];

            $query = mysqli_query($koneksi, "SELECT * FROM user WHERE id = $id");
            $res = mysqli_fetch_array($query);
            ?>
            <a href="#" class="close-button" title="Close">X</a>
            <h2>Edit</h2>
            <form action="juri.php?update=<?php echo $id; ?>" method="POST">
                <div class="row">

                    <div class="col-xs-12">
                        <div class="form-group">
                            <input type="text" name="namabaru" placeholder="Nama" value="<?php echo $res['nama'] ?>" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <input type="text" name="usernamebaru" placeholder="Username" value="<?php echo $res['username'] ?>" class="form-control" required/>
                        </div>


                        <div class="form-group">
                            <input type="password" name="passwordbaru" placeholder="Password Baru" class="form-control" required/>
                        </div>

                        <button class="btn btn-block btn-lg btn-primary">Edit Juri</button>
                    </div>

                </div></form>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#surat1").change(function () {
                $.post("../ajax/ayatgoto.php", {surah: $("#surat1").val()})
                        .success(function (data) {
                            $("#ayat1").html(data);
                            $("#ayat1").change();
                        });
            });
            if ($("#ayat1").val() == "" || $("#ayat1").val() == "0" || $("#ayat1").val() == null) {
                $.post("../ajax/ayatgoto.php", {surah: $("#surat1").val()})
                        .success(function (data) {
                            $("#ayat1").html(data);
                            $("#ayat1").change();
                        });
            }
            for (i = 2; i <= 15; i++) {
                document.getElementById("soal"+i).addEventListener('keyup', function () {
                    this.style.overflow = 'hidden';
                    this.style.height = 85;
                    this.style.height = this.scrollHeight + 'px';
                }, false);
                document.getElementById("jawaban"+i).addEventListener('keyup', function () {
                    this.style.overflow = 'hidden';
                    this.style.height = 85;
                    this.style.height = this.scrollHeight + 'px';
                }, false);
            }
        });
    </script>
    <script src="../dist/js/vendor/jquery.min.js"></script>
    <script src="../dist/js/vendor/video.js"></script>
    <script src="../dist/js/flat-ui.min.js"></script>
    <script src="../docs/assets/js/application.js"></script>

</body>
