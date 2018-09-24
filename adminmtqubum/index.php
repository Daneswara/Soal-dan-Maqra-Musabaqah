<?php
include "../koneksi.php";
session_start();
if (empty($_SESSION['admin_login'])) {
    header('location: login.php');
}
$queryview = mysqli_query($koneksi, "SELECT * FROM pengaturan LIMIT 1") or die(mysqli_error($koneksi));
$pengaturan = mysqli_fetch_array($queryview);
$acara = $pengaturan['acara'];
$acara = str_replace("<petik>", "'", $acara);
$logo = $pengaturan['logo'];
if (isset($_POST['optionsRadios'])) {
    $radio = $_POST['optionsRadios'];
    $arraykategori = explode("_", $radio);
    $kategori = $arraykategori[1];
    $tipe = $arraykategori[0];
    $index = "";
    $id = 0;
    if ($kategori == "1") {
        $id = 1;
        $index = $kategori . "";
        $kategori = "1 Juz";
    } else if ($kategori == "30") {
        $id = 2;
        $index = $kategori . "";
        $kategori = "1 Juz";
    } else if ($kategori == "5 Juz") {
        $id = 3;
        $index = "1-5";
    } else if ($kategori == "10 Juz") {
        $id = 4;
        $index = "1-10";
    } else if ($kategori == "15 Juz") {
        $id = 5;
        $index = "1-15";
    } else if ($kategori == "20 Juz") {
        $id = 6;
        $index = "1-20";
    } else if ($kategori == "30 Juz") {
        $id = 7;
        $index = "1-30";
    } else if ($kategori == "Tafsir") {
        $id = 8;
        $index = "1-30";
    } else if ($kategori == "Surat") {
        $id = 10;
        $input = $_POST['kategorisurat'];
        $index = $input;
    } else {
        $input = $_POST['custom'];
        $id = 9;
        $kategori = "custom";
        $tipe = "custom";
        $index = $input;
    }
    $query_mysql = mysqli_query($koneksi, "SELECT * FROM `kategori` WHERE `index` = '$index' AND `jenis` = '$tipe'") or die(mysqli_error($koneksi));
    $cek = mysqli_num_rows($query_mysql);
    if ($cek == 0) {
        $querytambah = mysqli_query($koneksi, "INSERT INTO kategori VALUES(NULL, '$id','$kategori', '$tipe','$index')") or die(mysqli_error($koneksi));
        if ($querytambah) {
            header('location: index.php?note=1');
        } else {
            header('location: index.php?note=12');
        }
    } else {
        header('location: index.php?note=12');
    }
}
if (isset($_GET['deletekategori'])) {
    $id = $_GET['deletekategori'];

//    $queryview = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id = $id") or die(mysqli_error($koneksi));
//    $kategori = mysqli_fetch_array($queryview);
//    $indexkategori = $kategori['index'];
    $querydel = mysqli_query($koneksi, "SELECT * FROM paket WHERE `id_kategori` = $id;") or die(mysqli_error($koneksi));
    $idpaket = mysqli_fetch_array($querydel);
    $paket = $idpaket['id'];

    $querycek = mysqli_query($koneksi, "SELECT * FROM kategori WHERE `id` = $id;") or die(mysqli_error($koneksi));
    $idkat = mysqli_fetch_array($querycek);
    $namakat = $idkat['nama'];
    if ($namakat == "Tafsir") {
        $queryhapus = mysqli_query($koneksi, "DELETE FROM soal_tafsir WHERE paket = $paket;");
    } else {
        $queryhapus = mysqli_query($koneksi, "DELETE FROM soal WHERE kategori = $paket;");
    }

    $queryhapus = mysqli_query($koneksi, "DELETE FROM paket WHERE id_kategori = $id;");
    $queryhapus = mysqli_query($koneksi, "DELETE FROM kategori WHERE id = $id;");

    if ($queryhapus) {
        header('location: index.php?note=2');
    } else {
        header('location: index.php?note=21');
    }
}
if (isset($_GET['deletepaket'])) {
    $id = $_GET['deletepaket'];
    $queryhapus = mysqli_query($koneksi, "DELETE FROM soal WHERE kategori = $id;");
    $queryhapus = mysqli_query($koneksi, "DELETE FROM paket WHERE id = $id;");
    if ($queryhapus) {
        header('location: index.php?note=5');
    } else {
        header('location: index.php?note=51');
    }
}

if (isset($_GET["kategori"])) {
    $kategori = $_GET["kategori"];

    $where = "";

    if (strpos($kategori, "-") != false) {
        $kat = explode("-", $kategori);
        $where = "kategori >= $kat[0] AND kategori <= $kat[1]";
    } else if (strpos($kategori, ",")) {
        $kat = explode(",", $kategori);
        $where = "";
        for ($i = 0; $i < count($kat); $i++) {
            if ($i == count($kat) - 1) {
                $where .= "kategori = $kat[$i]";
            } else {
                $where .= "kategori = $kat[$i] OR ";
            }
        }
    } else {
        $where = "kategori = $kategori";
    }
}
if (isset($_GET["nopaket"])) {
    $nopaket = $_GET["nopaket"];
}
if (isset($_GET['editpaket'])) {
    $idpaket = $_GET['editpaket'];
    $surat1 = $_POST['surat1'];
    $ayat1 = $_POST['ayat1'];
    $suratakhir1 = $_POST['surat6'];
    $ayatakhir1 = $_POST['ayat6'];
    $queryupdate = mysqli_query($koneksi, "UPDATE soal SET surat = '$surat1', ayat = '$ayat1' , suratakhir = '$suratakhir1', ayatakhir = '$ayatakhir1' WHERE kategori = $idpaket AND soal = 1;") or die(mysqli_error($koneksi));

    if ($_POST['surat2'] != "0") {
        $surat2 = $_POST['surat2'];
        $ayat2 = $_POST['ayat2'];
        $suratakhir2 = $_POST['surat7'];
        $ayatakhir2 = $_POST['ayat7'];
        $queryupdate = mysqli_query($koneksi, "UPDATE soal SET surat = '$surat2', ayat = '$ayat2' , suratakhir = '$suratakhir2', ayatakhir = '$ayatakhir2' WHERE kategori = $idpaket AND soal = 2;") or die(mysqli_error($koneksi));
    }
    if ($_POST['surat3'] != "0") {
        $surat3 = $_POST['surat3'];
        $ayat3 = $_POST['ayat3'];
        $suratakhir3 = $_POST['surat8'];
        $ayatakhir3 = $_POST['ayat8'];
        $queryupdate = mysqli_query($koneksi, "UPDATE soal SET surat = '$surat3', ayat = '$ayat3' , suratakhir = '$suratakhir3', ayatakhir = '$ayatakhir3' WHERE kategori = $idpaket AND soal = 3;") or die(mysqli_error($koneksi));
    }
    if ($_POST['surat4'] != "0") {
        $surat4 = $_POST['surat4'];
        $ayat4 = $_POST['ayat4'];
        $suratakhir4 = $_POST['surat9'];
        $ayatakhir4 = $_POST['ayat9'];
        $queryupdate = mysqli_query($koneksi, "UPDATE soal SET surat = '$surat4', ayat = '$ayat4' , suratakhir = '$suratakhir4', ayatakhir = '$ayatakhir4' WHERE kategori = $idpaket AND soal = 4;") or die(mysqli_error($koneksi));
    }
    if ($_POST['surat5'] != "0") {
        $surat5 = $_POST['surat5'];
        $ayat5 = $_POST['ayat5'];
        $suratakhir5 = $_POST['surat10'];
        $ayatakhir5 = $_POST['ayat10'];
        $queryupdate = mysqli_query($koneksi, "UPDATE soal SET surat = '$surat5', ayat = '$ayat5' , suratakhir = '$suratakhir5', ayatakhir = '$ayatakhir5' WHERE kategori = $idpaket AND soal = 5;") or die(mysqli_error($koneksi));
    }
    if ($_POST['surat66'] != "0") {
        $surat6 = $_POST['surat66'];
        $ayat6 = $_POST['ayat66'];
        $suratakhir6 = $_POST['surat11'];
        $ayatakhir6 = $_POST['ayat11'];
        $queryupdate = mysqli_query($koneksi, "UPDATE soal SET surat = '$surat6', ayat = '$ayat6' , suratakhir = '$suratakhir6', ayatakhir = '$ayatakhir6' WHERE kategori = $idpaket AND soal = 6;") or die(mysqli_error($koneksi));
    }

    if ($queryupdate) {
        header('location: index.php?note=4');
    } else {
        header('location: index.php?note=41');
    }
} else if (isset($_POST['surat1'])) {
    $id = $_GET["id"];

    // tambah paket
    $cekisipaket = mysqli_query($koneksi, "SELECT * FROM paket WHERE id_kategori=$id") or die(mysqli_error($koneksi));
    $cek = mysqli_num_rows($cekisipaket);
    $cek = $cek + 1;

//    $cekisikategori = mysqli_query($koneksi, "SELECT * FROM kategori WHERE `index`='$kategori'") or die(mysqli_error($koneksi));
//    $isikategori = mysqli_fetch_array($cekisikategori);
//    $urutankat = $isikategori['id'];

    $querytambah = mysqli_query($koneksi, "INSERT INTO paket VALUES(NULL, '$id', '$kategori', '$id-$cek')") or die(mysqli_error($koneksi));
    $queryview = mysqli_query($koneksi, "SELECT * FROM paket ORDER BY id DESC LIMIT 1") or die(mysqli_error($koneksi));
    $paket = mysqli_fetch_array($queryview);
    $idpaket = $paket['id'];
    // tambah soal
    $surat1 = $_POST['surat1'];
    $ayat1 = $_POST['ayat1'];
    $suratakhir1 = $_POST['surat6'];
    $ayatakhir1 = $_POST['ayat6'];
    $querytambah = mysqli_query($koneksi, "INSERT INTO soal VALUES(NULL, '$idpaket','1','$surat1','$ayat1','$suratakhir1','$ayatakhir1');") or die(mysqli_error($koneksi));

    if ($_POST['surat2'] != "0") {
        $surat2 = $_POST['surat2'];
        $ayat2 = $_POST['ayat2'];
        $suratakhir2 = $_POST['surat7'];
        $ayatakhir2 = $_POST['ayat7'];
        $querytambah = mysqli_query($koneksi, "INSERT INTO soal VALUES(NULL, '$idpaket','2','$surat2','$ayat2','$suratakhir2','$ayatakhir2');") or die(mysqli_error($koneksi));
    }
    if ($_POST['surat3'] != "0") {
        $surat3 = $_POST['surat3'];
        $ayat3 = $_POST['ayat3'];
        $suratakhir3 = $_POST['surat8'];
        $ayatakhir3 = $_POST['ayat8'];
        $querytambah = mysqli_query($koneksi, "INSERT INTO soal VALUES(NULL, '$idpaket','3','$surat3','$ayat3','$suratakhir3','$ayatakhir3');") or die(mysqli_error($koneksi));
    }
    if ($_POST['surat4'] != "0") {
        $surat4 = $_POST['surat4'];
        $ayat4 = $_POST['ayat4'];
        $suratakhir4 = $_POST['surat9'];
        $ayatakhir4 = $_POST['ayat9'];
        $querytambah = mysqli_query($koneksi, "INSERT INTO soal VALUES(NULL, '$idpaket','4','$surat4','$ayat4','$suratakhir4','$ayatakhir4');") or die(mysqli_error($koneksi));
    }
    if ($_POST['surat5'] != "0") {
        $surat5 = $_POST['surat5'];
        $ayat5 = $_POST['ayat5'];
        $suratakhir5 = $_POST['surat10'];
        $ayatakhir5 = $_POST['ayat10'];
        $querytambah = mysqli_query($koneksi, "INSERT INTO soal VALUES(NULL, '$idpaket','5','$surat5','$ayat5','$suratakhir5','$ayatakhir5');") or die(mysqli_error($koneksi));
    }
    if ($_POST['surat66'] != "0") {
        $surat6 = $_POST['surat66'];
        $ayat6 = $_POST['ayat66'];
        $suratakhir6 = $_POST['surat11'];
        $ayatakhir6 = $_POST['ayat11'];
        $querytambah = mysqli_query($koneksi, "INSERT INTO soal VALUES(NULL, '$idpaket','6','$surat6','$ayat6','$suratakhir6','$ayatakhir6');") or die(mysqli_error($koneksi));
    }

    if ($querytambah) {
        header('location: index.php?note=3');
    } else {
        header('location: index.php?note=31');
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

        <!-- Loading Flat UI -->
        <link href="../dist/css/flat-ui.css" rel="stylesheet">
        <link href="../docs/assets/css/demo.css" rel="stylesheet">

        <script src="../js/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../js/sweetalert.css">

        <link rel="shortcut icon" href="../img/favicon.ico">
        <script src="../js/jquery-1.10.2.js"></script>

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
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: '1 Kategori telah ditambahkan', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 12) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Kategori tidak dapat ditambahkan, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 2) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Kategori berhasil dihapus', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 21) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Ketegori tidak dapat dihapus, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 3) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Data Paket telah ditambahkan', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 31) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Data Paket tidak dapat ditambahkan, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 4) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Data Paket telah diedit', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 41) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Data Paket tidak dapat diedit, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 5) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Paket berhasil dihapus', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 51) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Paket tidak dapat dihapus, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            }
        }
        ?>
        <script type='text/javascript'>
            function hapusKategori(id) {
                swal({title: 'Apakah anda yakin ingin mengapus kategori?',
                    text: 'anda tidak akan dapat mengembalikan kategori beserta isi paket soal yang telah dihapus!',
                    confirmButtonColor: '#DD6B55',
                    closeOnConfirm: false,
                    confirmButtonText: 'Iya hapus!', cancelButtonText: 'Batal',
                    showCancelButton: true,
                    type: 'warning'},
                function () {
                    window.location = "index.php?deletekategori=" + id;
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
            #popup1 {
                width: 100%;
                height: 100%;
                position: fixed;
                background: rgba(0,0,0,.7);
                top: 0;
                left: 0;
                z-index: 9999;
                visibility: hidden;
            }
            #popup2 {
                width: 100%;
                height: 100%;
                position: fixed;
                background: rgba(0,0,0,.7);
                top: 0;
                left: 0;
                z-index: 9999;
                visibility: hidden;
            }
            #popup3 {
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
                width: 560px;
                height: 510px;
                background: #fff;
                border-radius: 10px;
                position: relative;
                padding: 20px;
                margin: 6% auto;
            }

            .window2 {
                width: 1050px;
                height: 590px;
                text-align: center;
                background: #fff;
                border-radius: 10px;
                position: relative;
                padding: 20px;
                margin: 3% auto;
            }
            .window3 {
                width: 700px;
                height: 580px;
                text-align: center;
                background: #fff;
                border-radius: 10px;
                position: relative;
                padding: 20px;
                margin: 3% auto;
            }

            /* Memunculkan Jendela Pop Up*/
            #popup1:target {
                visibility: visible;
            }
            #popup2:target {
                visibility: visible;
            }
            #popup3:target {
                visibility: visible;
            }
            .tengah {
                height: 100px;
                line-height: 120px;
                text-align: center;
                position: relative;
                color: white;
                z-index: 1000;
                padding-left: 25px;
            }
            .tengah2 {
                height: 40px;
                line-height: 40px;
                text-align: center;
            }
            img {
                z-index: 1;
                position: absolute;
            }
        </style>

        <div class="container">
            <div style="text-align: center; padding: 20px; margin-left: -220px"><b><?php echo $acara;?></b><img style="margin-top: -10px" height="50px" src="../gambar/<?php echo $logo; ?>"></div>
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
                        <li class="active"><a href="index.php">Bank Soal</a></li>
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
            <div class="row">
                <div class="col-xs-12" style="margin-bottom: 10px">
                    <a href="#popup1" class="btn btn-block btn-lg btn-primary">Tambah Kategori</a>
                </div>
            </div>
            <?php
            $query_mysql = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY urutan") or die(mysqli_error($koneksi));

            while ($data = mysqli_fetch_array($query_mysql)) {
                echo "<div class='row'><h6 style='padding-left: 20px'>" . $data['jenis'] . " " . $data['nama'] . " (Juz " . $data['index'] . ")";
                echo '<a href="?kategori=' . $data['id'] . '#popup3" class="btn btn-warning btn-xs" style="margin-left: 8px">Setting Acak</a>';
                echo "<button onclick='hapusKategori(" . $data['id'] . ");' class='btn btn-danger btn-xs' style='margin-left: 8px'>Delete Kategori</button></h6>";
                $index = $data['index'];
                $nama = $data['nama'];
                $jenis = $data['jenis'];
                $id_kategori = $data['id']; //lanjutkan buat paket dan edit paket tambah id kategori
                $query_mysql2 = mysqli_query($koneksi, "SELECT * FROM paket WHERE id_kategori = '$id_kategori' ORDER BY id") or die(mysqli_error($koneksi));
                while ($data2 = mysqli_fetch_array($query_mysql2)) {
                    $idpaketnya = $data2['id'];
                    $query_mysql3 = mysqli_query($koneksi, "SELECT * FROM penjurianpaket WHERE id_paket = '$idpaketnya';") or die(mysqli_error($koneksi));
                    $cek = mysqli_num_rows($query_mysql3);
                    if ($cek > 0) {
                        if ($nama == "Tafsir") {
                            echo '<div class="col-xs-2 col-md-2" style="margin-bottom: 70px;  margin-top: 10px; margin-right:30px">
                    <a href="input_soal_tasfir.php?id=' . $id_kategori . '&jenis=' . $jenis . '&namapaket=' . $data2['namapaket'] . '&nopaket=' . $data2['id'] . '">
                        <img src="../gambar/kotakmerah.png" class="img-responsive center-block">
                            <dt><div class="tengah">Paket ' . $data2['namapaket'] . '</div></dt></img>

                    </a>
                </div>';
                        } else {
                            echo '<div class="col-xs-2 col-md-2" style="margin-bottom: 70px;  margin-top: 10px; margin-right:30px">
                    <a href="?kategori=' . $index . '&id=' . $id_kategori . '&namapaket=' . $data2['namapaket'] . '&nopaket=' . $data2['id'] . '#popup2">
                        <img src="../gambar/kotakmerah.png" class="img-responsive center-block">
                            <dt><div class="tengah">Paket ' . $data2['namapaket'] . '</div></dt></img>

                    </a>
                </div>';
                        }
                    } else {
                        if ($nama == "Tafsir") {
                            echo '<div class="col-xs-2 col-md-2" style="margin-bottom: 70px;  margin-top: 10px; margin-right:30px">
                    <a href="input_soal_tasfir.php?id=' . $id_kategori . '&jenis=' . $jenis . '&namapaket=' . $data2['namapaket'] . '&nopaket=' . $data2['id'] . '">
                        <img src="../gambar/kotak.png" class="img-responsive center-block">
                            <dt><div class="tengah">Paket ' . $data2['namapaket'] . '</div></dt></img>

                    </a>
                </div>';
                        } else {
                            echo '<div class="col-xs-2 col-md-2" style="margin-bottom: 70px;  margin-top: 10px; margin-right:30px">
                    <a href="?kategori=' . $index . '&id=' . $id_kategori . '&namapaket=' . $data2['namapaket'] . '&nopaket=' . $data2['id'] . '#popup2">
                        <img src="../gambar/kotak.png" class="img-responsive center-block">
                            <dt><div class="tengah">Paket ' . $data2['namapaket'] . '</div></dt></img>

                    </a>
                </div>';
                        }
                    }
                }
                echo "<div class='col-xs-2 col-md-2' style='margin-bottom: 70px; margin-top: 10px; margin-right:30px'>";
                if ($nama == "Tafsir") {
                    echo '<a href="input_soal_tasfir.php?id=' . $id_kategori . '&jenis=' . $jenis . '">';
                    echo "<img src='../gambar/tambah.png' class='img-responsive center-block'>
                        <dt><div class='tengah'>Tambah</div></dt>

                    </a>
                </div></div>";
                } else {
                    echo '<a href="?kategori=' . $index . '&id=' . $id_kategori . '#popup2">';
                    echo "<img src='../gambar/tambah.png' class='img-responsive center-block'>
                        <dt><div class='tengah'>Tambah</div></dt>

                    </a>
                </div></div>";
                }
            }
            ?>
        </div>
        <div id="popup1">
            <div class="window">
                <a href="#" class="close-button" title="Close">X</a>
                <h2 style="text-align: center">Tambah Kategori</h2>
                <form action="index.php" method="POST">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="radio">
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="MHQ_1" data-toggle="radio" checked="true">
                                    MHQ 1 Juz (Juz 1)
                                </label>
                                <label class="radio">
                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="MHQ_30" data-toggle="radio">
                                    MHQ 1 Juz (Juz 30)
                                </label>
                                <label class="radio">
                                    <input type="radio" name="optionsRadios" id="optionsRadios3" value="MHQ_5 Juz" data-toggle="radio">
                                    MHQ 5 Juz (Juz 1-5)
                                </label>
                                <label class="radio">
                                    <input type="radio" name="optionsRadios" id="optionsRadios4" value="MHQ_10 Juz" data-toggle="radio">
                                    MHQ 10 Juz (Juz 1-10)
                                </label>
                                <label class="radio">
                                    <input type="radio" name="optionsRadios" id="optionsRadios5" value="MHQ_15 Juz" data-toggle="radio">
                                    MHQ 15 Juz (Juz 1-15)
                                </label>
                                <label class="radio">
                                    <input type="radio" name="optionsRadios" id="optionsRadios6" value="MHQ_20 Juz" data-toggle="radio">
                                    MHQ 20 Juz (Juz 1-20)
                                </label>
                                <label class="radio">
                                    <input type="radio" name="optionsRadios" id="optionsRadios7" value="MHQ_30 Juz" data-toggle="radio">
                                    MHQ 30 Juz (Juz 1-30)
                                </label>
                                <label class="radio">
                                    <input type="radio" name="optionsRadios" id="optionsRadios7" value="Tartil_10 Juz" data-toggle="radio">
                                    Tartil (Juz 1-10)
                                </label>
                                
                                <label class="radio">
                                    <input type="radio" name="optionsRadios" id="optionsRadios7" value="Tilawah Anak-anak_10 Juz" data-toggle="radio">
                                    Tilawah Anak-anak (Juz 1-10)
                                </label>
                            </div>

                            <div class="col-xs-6">

                                <label class="radio">
                                    <input type="radio" name="optionsRadios" id="optionsRadios7" value="Tilawah Remaja_20 Juz" data-toggle="radio">
                                    Tilawah Remaja (Juz 1-20)
                                </label>
                                <label class="radio">
                                    <input type="radio" name="optionsRadios" id="optionsRadios7" value="Tilawah Dewasa_30 Juz" data-toggle="radio">
                                    Tilawah Dewasa (Juz 1-30)
                                </label>
                                <label class="radio">
                                    <input type="radio" name="optionsRadios" id="optionsRadios7" value="Tafsir Bahasa Indonesia_Tafsir" data-toggle="radio">
                                    Tafsir Bahasa Indonesia (Juz 1-30)
                                </label>
                                <label class="radio">
                                    <input type="radio" name="optionsRadios" id="optionsRadios7" value="Tafsir Bahasa Arab_Tafsir" data-toggle="radio">
                                    Tafsir Bahasa Arab (Juz 1-30)
                                </label>
                                <label class="radio">
                                    <input type="radio" name="optionsRadios" id="optionsRadios7" value="Tafsir Bahasa Inggris_Tafsir" data-toggle="radio">
                                    Tafsir Bahasa Inggris (Juz 1-30)
                                </label>
                                
                                <label class="radio">
                                    <input type="radio" name="optionsRadios" id="optionsRadios7" value="MHQ_Surat" data-toggle="radio">
                                    <select id="kategorisurat" name="kategorisurat" style="min-width:206px" class="form-control select select-primary" data-toggle="select" required>
                                        <option value="0">Pilih Surah</option>
                                        <?php
                                            $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah ORDER BY nosurat") or die(mysqli_error($koneksi));
                                            $temp = "";
                                            while ($data = mysqli_fetch_array($query_mysql)) {
                                                if ($data['nama'] == $temp) {

                                                } else if ($editsurat[0] == $data['nosurat']) {
                                                    echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                                } else {
                                                    echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                                }
                                                $temp = $data['nama'];
                                            }
                                        ?>
                                    </select>
                                </label>
                                <label class="radio">
                                    <input type="radio" name="optionsRadios" id="optionsRadios8" value="" data-toggle="radio">
                                    <div class="tagsinput-primary">
                                        <input type="text" name="custom" value="" class="tagsinput" data-role="tagsinput" class="form-control" placeholder="Contoh Juz 1 dan Juz 3 = 1,3"/>
                                    </div>
                                </label>
                            </div>
                        </div>

                    </div>
                    <button class="btn btn-block btn-lg btn-primary">Tambah Kategori</button>

            </div></form>
    </div>
    <div id="popup2">
        <div class="window2">
            <a href="#" class="close-button" title="Close">X</a>
            <?php
            if (isset($_GET["namapaket"])) {
                $namapaket = $_GET["namapaket"];
            }
            if (isset($nopaket)) {
                echo "<h3>Edit Soal Paket " . $namapaket . "</h3>";
                $query_mysql = mysqli_query($koneksi, "SELECT * FROM soal WHERE kategori = $nopaket ORDER BY soal") or die(mysqli_error($koneksi));
                $editsurat = array();
                $editayat = array();
                $i = 0;
                while ($data = mysqli_fetch_array($query_mysql)) {
                    $editsurat[$i] = $data['surat'];
                    $editayat[$i] = $data['ayat'];
                    $editsuratakhir[$i] = $data['suratakhir'];
                    $editayatakhir[$i] = $data['ayatakhir'];
                    $i++;
                }
                echo "<form action = 'index.php?editpaket=$nopaket' method = 'POST'>";
            } else {
                $idkat = $_GET["id"];
                echo "<h3>Tambah Paket Soal Juz $kategori</h3>";
                echo "<form action = 'index.php?kategori=$kategori&id=$idkat' method = 'POST'>";
            }
            ?>


            <div class="row">
                <div class="form-group">
                    <div class="col-xs-1">
                        <div class="tengah2"></div>
                    </div>
                    <div class="col-xs-2" style="margin-left: 40px"">
                        <div class="tengah2">Surah Awal</div>
                    </div>
                    <div class="col-xs-2" style="margin-left: 60px"">
                        <div class="tengah2">Ayat Awal</div>
                    </div>
                    <div class="col-xs-2" style="margin-left: 60px"">
                        <div class="tengah2">Surah Akhir</div>
                    </div>
                    <div class="col-xs-2" style="margin-left: 60px"">
                        <div class="tengah2">Ayat Akhir</div>
                    </div>
                    <div class="col-xs-1" style="padding-bottom: 20px">
                        <div class="tengah2">Soal 1</div>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px">
                        <select id="surat1" name="surat1" class="form-control select select-default" data-toggle="select" required>
                            <option value="0">Pilih Surah</option>
                            <?php
                            if (isset($where)) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where ORDER BY nosurat") or die(mysqli_error($koneksi));
                                $temp = "";
                                while ($data = mysqli_fetch_array($query_mysql)) {
                                    if ($data['nama'] == $temp) {

                                    } else if ($editsurat[0] == $data['nosurat']) {
                                        echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    } else {
                                        echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    }
                                    $temp = $data['nama'];
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left: 60px">
                        <select id="ayat1" name="ayat1" class="form-control select select-default" data-toggle="select" required>
                            <option value="">Pilih Ayat</option>
                            <?php
                            if (isset($nopaket) && isset($editayat[0])) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE ($where) and nosurat = $editsurat[0] ORDER BY nosurat") or die(mysqli_error($koneksi));
                                echo "edit surat" . $where;
                                while ($data = mysqli_fetch_array($query_mysql)) {

                                    for ($a = $data['awal']; $a <= $data['akhir']; $a++) {
                                        if ($editayat[0] == $a) {
                                            echo "<option value=" . $a . " selected>" . $a . "</option>";
                                        } else {
                                            echo "<option value=" . $a . ">" . $a . "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left: 60px">
                        <select id="surat6" name="surat6" class="form-control select select-default" data-toggle="select">
                            <option value="0">Pilih Surah</option>
                            <?php
                            if (isset($where)) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where ORDER BY nosurat") or die(mysqli_error($koneksi));
                                $temp = "";
                                while ($data = mysqli_fetch_array($query_mysql)) {
                                    if ($data['nama'] == $temp) {

                                    } else if ($editsuratakhir[0] == $data['nosurat']) {
                                        echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    } else {
                                        echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    }
                                    $temp = $data['nama'];
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left: 60px">
                        <select id="ayat6" name="ayat6" class="form-control select select-default" data-toggle="select">
                            <option value="">Pilih Ayat</option>
                            <?php
                            if (isset($nopaket) && isset($editayatakhir[0])) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE ($where) and nosurat = $editsuratakhir[0] ORDER BY nosurat") or die(mysqli_error($koneksi));
                                echo "edit surat" . $where;
                                while ($data = mysqli_fetch_array($query_mysql)) {

                                    for ($a = $data['awal']; $a <= $data['akhir']; $a++) {
                                        if ($editayatakhir[0] == $a) {
                                            echo "<option value=" . $a . " selected>" . $a . "</option>";
                                        } else {
                                            echo "<option value=" . $a . ">" . $a . "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-1" style="padding-bottom: 20px">
                        <div class="tengah2">Soal 2</div>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px">
                        <select id="surat2" name="surat2" class="form-control select select-default" data-toggle="select">
                            <option value="0">Pilih Surah</option>
                            <?php
                            if (isset($where)) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where ORDER BY nosurat") or die(mysqli_error($koneksi));
                                $temp = "";
                                while ($data = mysqli_fetch_array($query_mysql)) {
                                    if ($data['nama'] == $temp) {

                                    } else if ($editsurat[1] == $data['nosurat']) {
                                        echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    } else {
                                        echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    }
                                    $temp = $data['nama'];
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left: 60px">
                        <select id="ayat2" name="ayat2" class="form-control select select-default" data-toggle="select">
                            <option value="">Pilih Ayat</option>
                            <?php
                            if (isset($nopaket) && isset($editayat[1])) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE ($where) and nosurat = $editsurat[1] ORDER BY nosurat") or die(mysqli_error($koneksi));

                                while ($data = mysqli_fetch_array($query_mysql)) {

                                    for ($a = $data['awal']; $a <= $data['akhir']; $a++) {
                                        if ($editayat[1] == $a) {
                                            echo "<option value=" . $a . " selected>" . $a . "</option>";
                                        } else {
                                            echo "<option value=" . $a . ">" . $a . "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left: 60px">
                        <select id="surat7" name="surat7" class="form-control select select-default" data-toggle="select">
                            <option value="0">Pilih Surah</option>
                            <?php
                            if (isset($where)) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where ORDER BY nosurat") or die(mysqli_error($koneksi));
                                $temp = "";
                                while ($data = mysqli_fetch_array($query_mysql)) {
                                    if ($data['nama'] == $temp) {

                                    } else if ($editsuratakhir[1] == $data['nosurat']) {
                                        echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    } else {
                                        echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    }
                                    $temp = $data['nama'];
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left: 60px">
                        <select id="ayat7" name="ayat7" class="form-control select select-default" data-toggle="select">
                            <option value="">Pilih Ayat</option>
                            <?php
                            if (isset($nopaket) && isset($editayatakhir[1])) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE ($where) and nosurat = $editsuratakhir[1] ORDER BY nosurat") or die(mysqli_error($koneksi));
                                echo "edit surat" . $where;
                                while ($data = mysqli_fetch_array($query_mysql)) {

                                    for ($a = $data['awal']; $a <= $data['akhir']; $a++) {
                                        if ($editayatakhir[1] == $a) {
                                            echo "<option value=" . $a . " selected>" . $a . "</option>";
                                        } else {
                                            echo "<option value=" . $a . ">" . $a . "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-1" style="padding-bottom: 20px">
                        <div class="tengah2">Soal 3</div>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px">
                        <select id="surat3" name="surat3" class="form-control select select-default" data-toggle="select">
                            <option value="0">Pilih Surah</option>
                            <?php
                            if (isset($where)) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where ORDER BY nosurat") or die(mysqli_error($koneksi));
                                $temp = "";
                                while ($data = mysqli_fetch_array($query_mysql)) {
                                    if ($data['nama'] == $temp) {

                                    } else if ($editsurat[2] == $data['nosurat']) {
                                        echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    } else {
                                        echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    }
                                    $temp = $data['nama'];
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left: 60px">
                        <select id="ayat3" name="ayat3" class="form-control select select-default" data-toggle="select">
                            <option value="">Pilih Ayat</option>
                            <?php
                            if (isset($nopaket) && isset($editayat[2])) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE ($where) and nosurat = $editsurat[2] ORDER BY nosurat") or die(mysqli_error($koneksi));

                                while ($data = mysqli_fetch_array($query_mysql)) {

                                    for ($a = $data['awal']; $a <= $data['akhir']; $a++) {
                                        if ($editayat[2] == $a) {
                                            echo "<option value=" . $a . " selected>" . $a . "</option>";
                                        } else {
                                            echo "<option value=" . $a . ">" . $a . "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left: 60px">
                        <select id="surat8" name="surat8" class="form-control select select-default" data-toggle="select">
                            <option value="0">Pilih Surah</option>
                            <?php
                            if (isset($where)) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where ORDER BY nosurat") or die(mysqli_error($koneksi));
                                $temp = "";
                                while ($data = mysqli_fetch_array($query_mysql)) {
                                    if ($data['nama'] == $temp) {

                                    } else if ($editsuratakhir[2] == $data['nosurat']) {
                                        echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    } else {
                                        echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    }
                                    $temp = $data['nama'];
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left: 60px">
                        <select id="ayat8" name="ayat8" class="form-control select select-default" data-toggle="select">
                            <option value="">Pilih Ayat</option>
                            <?php
                            if (isset($nopaket) && isset($editayatakhir[2])) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE ($where) and nosurat = $editsuratakhir[2] ORDER BY nosurat") or die(mysqli_error($koneksi));
                                echo "edit surat" . $where;
                                while ($data = mysqli_fetch_array($query_mysql)) {

                                    for ($a = $data['awal']; $a <= $data['akhir']; $a++) {
                                        if ($editayatakhir[2] == $a) {
                                            echo "<option value=" . $a . " selected>" . $a . "</option>";
                                        } else {
                                            echo "<option value=" . $a . ">" . $a . "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-1" style="padding-bottom: 20px">
                        <div class="tengah2">Soal 4</div>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px">
                        <select id="surat4" name="surat4" class="form-control select select-default" data-toggle="select">
                            <option value="0">Pilih Surah</option>
                            <?php
                            if (isset($where)) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where ORDER BY nosurat") or die(mysqli_error($koneksi));
                                $temp = "";
                                while ($data = mysqli_fetch_array($query_mysql)) {
                                    if ($data['nama'] == $temp) {

                                    } else if ($editsurat[3] == $data['nosurat']) {
                                        echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    } else {
                                        echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    }
                                    $temp = $data['nama'];
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left: 60px">
                        <select id="ayat4" name="ayat4" class="form-control select select-default" data-toggle="select">
                            <option value="">Pilih Ayat</option>
                            <?php
                            if (isset($nopaket) && isset($editayat[3])) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE ($where) and nosurat = $editsurat[3] ORDER BY nosurat") or die(mysqli_error($koneksi));

                                while ($data = mysqli_fetch_array($query_mysql)) {

                                    for ($a = $data['awal']; $a <= $data['akhir']; $a++) {
                                        if ($editayat[3] == $a) {
                                            echo "<option value=" . $a . " selected>" . $a . "</option>";
                                        } else {
                                            echo "<option value=" . $a . ">" . $a . "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left: 60px">
                        <select id="surat9" name="surat9" class="form-control select select-default" data-toggle="select">
                            <option value="0">Pilih Surah</option>
                            <?php
                            if (isset($where)) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where ORDER BY nosurat") or die(mysqli_error($koneksi));
                                $temp = "";
                                while ($data = mysqli_fetch_array($query_mysql)) {
                                    if ($data['nama'] == $temp) {

                                    } else if ($editsuratakhir[3] == $data['nosurat']) {
                                        echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    } else {
                                        echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    }
                                    $temp = $data['nama'];
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left: 60px">
                        <select id="ayat9" name="ayat9" class="form-control select select-default" data-toggle="select">
                            <option value="">Pilih Ayat</option>
                            <?php
                            if (isset($nopaket) && isset($editayatakhir[3])) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE ($where) and nosurat = $editsuratakhir[3] ORDER BY nosurat") or die(mysqli_error($koneksi));
                                echo "edit surat" . $where;
                                while ($data = mysqli_fetch_array($query_mysql)) {

                                    for ($a = $data['awal']; $a <= $data['akhir']; $a++) {
                                        if ($editayatakhir[3] == $a) {
                                            echo "<option value=" . $a . " selected>" . $a . "</option>";
                                        } else {
                                            echo "<option value=" . $a . ">" . $a . "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-1" style="padding-bottom: 20px">
                        <div class="tengah2">Soal 5</div>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px">
                        <select id="surat5" name="surat5" class="form-control select select-default" data-toggle="select">
                            <option value="0">Pilih Surah</option>
                            <?php
                            if (isset($where)) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where ORDER BY nosurat") or die(mysqli_error($koneksi));
                                $temp = "";
                                while ($data = mysqli_fetch_array($query_mysql)) {
                                    if ($data['nama'] == $temp) {

                                    } else if ($editsurat[4] == $data['nosurat']) {
                                        echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    } else {
                                        echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    }
                                    $temp = $data['nama'];
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left: 60px">
                        <select id="ayat5" name="ayat5" class="form-control select select-default" data-toggle="select">
                            <option value="">Pilih Ayat</option>
                            <?php
                            if (isset($nopaket) && isset($editayat[4])) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE ($where) and nosurat = $editsurat[4] ORDER BY nosurat") or die(mysqli_error($koneksi));

                                while ($data = mysqli_fetch_array($query_mysql)) {

                                    for ($a = $data['awal']; $a <= $data['akhir']; $a++) {
                                        if ($editayat[4] == $a) {
                                            echo "<option value=" . $a . " selected>" . $a . "</option>";
                                        } else {
                                            echo "<option value=" . $a . ">" . $a . "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left: 60px">
                        <select id="surat10" name="surat10" class="form-control select select-default" data-toggle="select">
                            <option value="0">Pilih Surah</option>
                            <?php
                            if (isset($where)) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where ORDER BY nosurat") or die(mysqli_error($koneksi));
                                $temp = "";
                                while ($data = mysqli_fetch_array($query_mysql)) {
                                    if ($data['nama'] == $temp) {

                                    } else if ($editsuratakhir[4] == $data['nosurat']) {
                                        echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    } else {
                                        echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    }
                                    $temp = $data['nama'];
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left: 60px">
                        <select id="ayat10" name="ayat10" class="form-control select select-default" data-toggle="select">
                            <option value="">Pilih Ayat</option>
                            <?php
                            if (isset($nopaket) && isset($editayatakhir[4])) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE ($where) and nosurat = $editsuratakhir[4] ORDER BY nosurat") or die(mysqli_error($koneksi));
                                echo "edit surat" . $where;
                                while ($data = mysqli_fetch_array($query_mysql)) {

                                    for ($a = $data['awal']; $a <= $data['akhir']; $a++) {
                                        if ($editayatakhir[4] == $a) {
                                            echo "<option value=" . $a . " selected>" . $a . "</option>";
                                        } else {
                                            echo "<option value=" . $a . ">" . $a . "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-1" style="padding-bottom: 20px">
                        <div class="tengah2">Soal 6</div>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px">
                        <select id="surat66" name="surat66" class="form-control select select-default" data-toggle="select">
                            <option value="0">Pilih Surah</option>
                            <?php
                            if (isset($where)) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where ORDER BY nosurat") or die(mysqli_error($koneksi));
                                $temp = "";
                                while ($data = mysqli_fetch_array($query_mysql)) {
                                    if ($data['nama'] == $temp) {

                                    } else if ($editsurat[5] == $data['nosurat']) {
                                        echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    } else {
                                        echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    }
                                    $temp = $data['nama'];
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left: 60px">
                        <select id="ayat66" name="ayat66" class="form-control select select-default" data-toggle="select">
                            <option value="">Pilih Ayat</option>
                            <?php
                            if (isset($nopaket) && isset($editayat[5])) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE ($where) and nosurat = $editsurat[5] ORDER BY nosurat") or die(mysqli_error($koneksi));

                                while ($data = mysqli_fetch_array($query_mysql)) {

                                    for ($a = $data['awal']; $a <= $data['akhir']; $a++) {
                                        if ($editayat[5] == $a) {
                                            echo "<option value=" . $a . " selected>" . $a . "</option>";
                                        } else {
                                            echo "<option value=" . $a . ">" . $a . "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left: 60px">
                        <select id="surat11" name="surat11" class="form-control select select-default" data-toggle="select">
                            <option value="0">Pilih Surah</option>
                            <?php
                            if (isset($where)) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where ORDER BY nosurat") or die(mysqli_error($koneksi));
                                $temp = "";
                                while ($data = mysqli_fetch_array($query_mysql)) {
                                    if ($data['nama'] == $temp) {

                                    } else if ($editsuratakhir[5] == $data['nosurat']) {
                                        echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    } else {
                                        echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    }
                                    $temp = $data['nama'];
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left: 60px">
                        <select id="ayat11" name="ayat11" class="form-control select select-default" data-toggle="select">
                            <option value="">Pilih Ayat</option>
                            <?php
                            if (isset($nopaket) && isset($editayatakhir[5])) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE ($where) and nosurat = $editsuratakhir[5] ORDER BY nosurat") or die(mysqli_error($koneksi));
                                echo "edit surat" . $where;
                                while ($data = mysqli_fetch_array($query_mysql)) {

                                    for ($a = $data['awal']; $a <= $data['akhir']; $a++) {
                                        if ($editayatakhir[5] == $a) {
                                            echo "<option value=" . $a . " selected>" . $a . "</option>";
                                        } else {
                                            echo "<option value=" . $a . ">" . $a . "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <?php
                if (isset($nopaket)) {
                    echo "<div class='col-xs-6'><div onclick='hapusPaket($nopaket);' class='btn btn-block btn-lg btn-danger'>Hapus Paket Soal</div></div>";
                    echo "<div class='col-xs-6'><button class='btn btn-block btn-lg btn-primary'>Edit Soal</button></div>";
                } else {
                    echo "<div class='col-xs-1'></div><div class='col-xs-11'><button class='btn btn-block btn-lg btn-primary'>Tambah Soal</button></div>";
                }
                ?>
            </div>
            </form>
        </div>
    </div>
    <div id="popup3">
        <div class="window3">
            <a href="#" class="close-button" title="Close">X</a>
            <?php
            if (isset($_GET["namapaket"])) {
                $namapaket = $_GET["namapaket"];
            }
            if (isset($nopaket)) {
                echo "<h3>Setting Acak Otomatis Kategori " . $namapaket . "</h3>";
                $query_mysql = mysqli_query($koneksi, "SELECT * FROM soal WHERE kategori = $nopaket ORDER BY soal") or die(mysqli_error($koneksi));
                $editsurat = array();
                $editayat = array();
                $i = 0;
                while ($data = mysqli_fetch_array($query_mysql)) {
                    $editsurat[$i] = $data['surat'];
                    $editayat[$i] = $data['ayat'];
                    $editsuratakhir[$i] = $data['suratakhir'];
                    $editayatakhir[$i] = $data['ayatakhir'];
                    $i++;
                }
                echo "<form action = 'index.php?editpaket=$nopaket' method = 'POST'>";
            } else {
                $idkat = $_GET["id"];
                echo "<h3>Setting Acak Otomatis Kategori $kategori</h3>";
                echo "<form action = 'index.php?kategori=$kategori&id=$idkat' method = 'POST'>";
            }
            ?>


            <div class="row">
                <div class="form-group">
                    <div class="col-xs-2">
                        <div class="tengah2"></div>
                    </div>
                    <div class="col-xs-4" style="margin-left: 20px">
                        <div class="tengah2">Juz Awal</div>
                    </div>
                    <div class="col-xs-4" style="margin-left: 60px">
                        <div class="tengah2">Juz Akhir</div>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left:20px">
                        <div class="tengah2">Soal 1</div>
                    </div>
                    <div class="col-xs-4" style="padding-bottom: 20px">
                        <select id="surat1" name="surat1" class="form-control select select-default" data-toggle="select" required>
                            <option value="0">Pilih Surah</option>
                            <?php
                            if (isset($where)) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where ORDER BY nosurat") or die(mysqli_error($koneksi));
                                $temp = "";
                                while ($data = mysqli_fetch_array($query_mysql)) {
                                    if ($data['nama'] == $temp) {

                                    } else if ($editsurat[0] == $data['nosurat']) {
                                        echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    } else {
                                        echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    }
                                    $temp = $data['nama'];
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-4" style="padding-bottom: 20px; margin-left: 35px">
                        <select id="ayat1" name="ayat1" class="form-control select select-default" data-toggle="select" required>
                            <option value="">Pilih Ayat</option>
                            <?php
                            if (isset($nopaket) && isset($editayat[0])) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE ($where) and nosurat = $editsurat[0] ORDER BY nosurat") or die(mysqli_error($koneksi));
                                echo "edit surat" . $where;
                                while ($data = mysqli_fetch_array($query_mysql)) {

                                    for ($a = $data['awal']; $a <= $data['akhir']; $a++) {
                                        if ($editayat[0] == $a) {
                                            echo "<option value=" . $a . " selected>" . $a . "</option>";
                                        } else {
                                            echo "<option value=" . $a . ">" . $a . "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left:20px">
                        <div class="tengah2">Soal 2</div>
                    </div>
                    <div class="col-xs-4" style="padding-bottom: 20px">
                        <select id="surat2" name="surat2" class="form-control select select-default" data-toggle="select">
                            <option value="0">Pilih Surah</option>
                            <?php
                            if (isset($where)) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where ORDER BY nosurat") or die(mysqli_error($koneksi));
                                $temp = "";
                                while ($data = mysqli_fetch_array($query_mysql)) {
                                    if ($data['nama'] == $temp) {

                                    } else if ($editsurat[1] == $data['nosurat']) {
                                        echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    } else {
                                        echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    }
                                    $temp = $data['nama'];
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-4" style="padding-bottom: 20px; margin-left: 35px">
                        <select id="ayat2" name="ayat2" class="form-control select select-default" data-toggle="select">
                            <option value="">Pilih Ayat</option>
                            <?php
                            if (isset($nopaket) && isset($editayat[1])) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE ($where) and nosurat = $editsurat[1] ORDER BY nosurat") or die(mysqli_error($koneksi));

                                while ($data = mysqli_fetch_array($query_mysql)) {

                                    for ($a = $data['awal']; $a <= $data['akhir']; $a++) {
                                        if ($editayat[1] == $a) {
                                            echo "<option value=" . $a . " selected>" . $a . "</option>";
                                        } else {
                                            echo "<option value=" . $a . ">" . $a . "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left:20px">
                        <div class="tengah2">Soal 3</div>
                    </div>
                    <div class="col-xs-4" style="padding-bottom: 20px">
                        <select id="surat3" name="surat3" class="form-control select select-default" data-toggle="select">
                            <option value="0">Pilih Surah</option>
                            <?php
                            if (isset($where)) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where ORDER BY nosurat") or die(mysqli_error($koneksi));
                                $temp = "";
                                while ($data = mysqli_fetch_array($query_mysql)) {
                                    if ($data['nama'] == $temp) {

                                    } else if ($editsurat[2] == $data['nosurat']) {
                                        echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    } else {
                                        echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    }
                                    $temp = $data['nama'];
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-4" style="padding-bottom: 20px; margin-left: 35px">
                        <select id="ayat3" name="ayat3" class="form-control select select-default" data-toggle="select">
                            <option value="">Pilih Ayat</option>
                            <?php
                            if (isset($nopaket) && isset($editayat[2])) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE ($where) and nosurat = $editsurat[2] ORDER BY nosurat") or die(mysqli_error($koneksi));

                                while ($data = mysqli_fetch_array($query_mysql)) {

                                    for ($a = $data['awal']; $a <= $data['akhir']; $a++) {
                                        if ($editayat[2] == $a) {
                                            echo "<option value=" . $a . " selected>" . $a . "</option>";
                                        } else {
                                            echo "<option value=" . $a . ">" . $a . "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left:20px">
                        <div class="tengah2">Soal 4</div>
                    </div>
                    <div class="col-xs-4" style="padding-bottom: 20px">
                        <select id="surat4" name="surat4" class="form-control select select-default" data-toggle="select">
                            <option value="0">Pilih Surah</option>
                            <?php
                            if (isset($where)) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where ORDER BY nosurat") or die(mysqli_error($koneksi));
                                $temp = "";
                                while ($data = mysqli_fetch_array($query_mysql)) {
                                    if ($data['nama'] == $temp) {

                                    } else if ($editsurat[3] == $data['nosurat']) {
                                        echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    } else {
                                        echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    }
                                    $temp = $data['nama'];
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-4" style="padding-bottom: 20px; margin-left: 35px">
                        <select id="ayat4" name="ayat4" class="form-control select select-default" data-toggle="select">
                            <option value="">Pilih Ayat</option>
                            <?php
                            if (isset($nopaket) && isset($editayat[3])) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE ($where) and nosurat = $editsurat[3] ORDER BY nosurat") or die(mysqli_error($koneksi));

                                while ($data = mysqli_fetch_array($query_mysql)) {

                                    for ($a = $data['awal']; $a <= $data['akhir']; $a++) {
                                        if ($editayat[3] == $a) {
                                            echo "<option value=" . $a . " selected>" . $a . "</option>";
                                        } else {
                                            echo "<option value=" . $a . ">" . $a . "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left:20px">
                        <div class="tengah2">Soal 5</div>
                    </div>
                    <div class="col-xs-4" style="padding-bottom: 20px">
                        <select id="surat5" name="surat5" class="form-control select select-default" data-toggle="select">
                            <option value="0">Pilih Surah</option>
                            <?php
                            if (isset($where)) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where ORDER BY nosurat") or die(mysqli_error($koneksi));
                                $temp = "";
                                while ($data = mysqli_fetch_array($query_mysql)) {
                                    if ($data['nama'] == $temp) {

                                    } else if ($editsurat[4] == $data['nosurat']) {
                                        echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    } else {
                                        echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    }
                                    $temp = $data['nama'];
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-4" style="padding-bottom: 20px; margin-left: 35px">
                        <select id="ayat5" name="ayat5" class="form-control select select-default" data-toggle="select">
                            <option value="">Pilih Ayat</option>
                            <?php
                            if (isset($nopaket) && isset($editayat[4])) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE ($where) and nosurat = $editsurat[4] ORDER BY nosurat") or die(mysqli_error($koneksi));

                                while ($data = mysqli_fetch_array($query_mysql)) {

                                    for ($a = $data['awal']; $a <= $data['akhir']; $a++) {
                                        if ($editayat[4] == $a) {
                                            echo "<option value=" . $a . " selected>" . $a . "</option>";
                                        } else {
                                            echo "<option value=" . $a . ">" . $a . "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2" style="padding-bottom: 20px; margin-left:20px">
                        <div class="tengah2">Soal 6</div>
                    </div>
                    <div class="col-xs-4" style="padding-bottom: 20px">
                        <select id="surat66" name="surat66" class="form-control select select-default" data-toggle="select">
                            <option value="0">Pilih Surah</option>
                            <?php
                            if (isset($where)) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where ORDER BY nosurat") or die(mysqli_error($koneksi));
                                $temp = "";
                                while ($data = mysqli_fetch_array($query_mysql)) {
                                    if ($data['nama'] == $temp) {

                                    } else if ($editsurat[5] == $data['nosurat']) {
                                        echo "<option value=" . $data['nosurat'] . " selected>" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    } else {
                                        echo "<option value=" . $data['nosurat'] . ">" . $data['nosurat'] . ". " . $data['nama'] . "</option>";
                                    }
                                    $temp = $data['nama'];
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-4" style="padding-bottom: 20px; margin-left: 35px">
                        <select id="ayat66" name="ayat66" class="form-control select select-default" data-toggle="select">
                            <option value="">Pilih Ayat</option>
                            <?php
                            if (isset($nopaket) && isset($editayat[5])) {
                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE ($where) and nosurat = $editsurat[5] ORDER BY nosurat") or die(mysqli_error($koneksi));

                                while ($data = mysqli_fetch_array($query_mysql)) {

                                    for ($a = $data['awal']; $a <= $data['akhir']; $a++) {
                                        if ($editayat[5] == $a) {
                                            echo "<option value=" . $a . " selected>" . $a . "</option>";
                                        } else {
                                            echo "<option value=" . $a . ">" . $a . "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <?php
                if (isset($nopaket)) {
                    echo "<div class='col-xs-6'><div onclick='hapusPaket($nopaket);' class='btn btn-block btn-lg btn-danger'>Hapus Paket Soal</div></div>";
                    echo "<div class='col-xs-6'><button class='btn btn-block btn-lg btn-primary'>Edit Soal</button></div>";
                } else {
                    echo "<div class='col-xs-2' style='margin-left:20px'></div><div class='col-xs-9'><button class='btn btn-block btn-lg btn-primary'>Tambah Soal</button></div>";
                }
                ?>
            </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            $("#surat1").change(function () {
                $.post("../ajax/ayat.php", {surah: $("#surat1").val(), kategori: <?php echo "'" . $where . "'" ?>})
                        .success(function (data) {
                            $("#ayat1").html(data);
                            $("#ayat1").change();
                        });
            });
            $("#surat2").change(function () {
                $.post("../ajax/ayat.php", {surah: $("#surat2").val(), kategori: <?php echo "'" . $where . "'" ?>})
                        .success(function (data) {
                            $("#ayat2").html(data);
                            $("#ayat2").change();
                        });
            });
            $("#surat3").change(function () {
                $.post("../ajax/ayat.php", {surah: $("#surat3").val(), kategori: <?php echo "'" . $where . "'" ?>})
                        .success(function (data) {
                            $("#ayat3").html(data);
                            $("#ayat3").change();
                        });
            });
            $("#surat4").change(function () {
                $.post("../ajax/ayat.php", {surah: $("#surat4").val(), kategori: <?php echo "'" . $where . "'" ?>})
                        .success(function (data) {
                            $("#ayat4").html(data);
                            $("#ayat4").change();
                        });
            });
            $("#surat5").change(function () {
                $.post("../ajax/ayat.php", {surah: $("#surat5").val(), kategori: <?php echo "'" . $where . "'" ?>})
                        .success(function (data) {
                            $("#ayat5").html(data);
                            $("#ayat5").change();
                        });
            });
            $("#surat6").change(function () {
                $.post("../ajax/ayat.php", {surah: $("#surat6").val(), kategori: <?php echo "'" . $where . "'" ?>})
                        .success(function (data) {
                            $("#ayat6").html(data);
                            $("#ayat6").change();
                        });
            });
            $("#surat7").change(function () {
                $.post("../ajax/ayat.php", {surah: $("#surat7").val(), kategori: <?php echo "'" . $where . "'" ?>})
                        .success(function (data) {
                            $("#ayat7").html(data);
                            $("#ayat7").change();
                        });
            });
            $("#surat8").change(function () {
                $.post("../ajax/ayat.php", {surah: $("#surat8").val(), kategori: <?php echo "'" . $where . "'" ?>})
                        .success(function (data) {
                            $("#ayat8").html(data);
                            $("#ayat8").change();
                        });
            });
            $("#surat9").change(function () {
                $.post("../ajax/ayat.php", {surah: $("#surat9").val(), kategori: <?php echo "'" . $where . "'" ?>})
                        .success(function (data) {
                            $("#ayat9").html(data);
                            $("#ayat9").change();
                        });
            });
            $("#surat10").change(function () {
                $.post("../ajax/ayat.php", {surah: $("#surat10").val(), kategori: <?php echo "'" . $where . "'" ?>})
                        .success(function (data) {
                            $("#ayat10").html(data);
                            $("#ayat10").change();
                        });
            });
            $("#surat66").change(function () {
                $.post("../ajax/ayat.php", {surah: $("#surat66").val(), kategori: <?php echo "'" . $where . "'" ?>})
                        .success(function (data) {
                            $("#ayat66").html(data);
                            $("#ayat66").change();
                        });
            });
            $("#surat11").change(function () {
                $.post("../ajax/ayat.php", {surah: $("#surat11").val(), kategori: <?php echo "'" . $where . "'" ?>})
                        .success(function (data) {
                            $("#ayat11").html(data);
                            $("#ayat11").change();
                        });
            });
        });
    </script>
    <script src="../dist/js/vendor/jquery.min.js"></script>
    <script src="../dist/js/vendor/video.js"></script>
    <script src="../dist/js/flat-ui.min.js"></script>
    <script src="../docs/assets/js/application.js"></script>

</body>
