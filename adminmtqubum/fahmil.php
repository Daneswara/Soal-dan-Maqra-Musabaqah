<?php
include "../koneksi.php";
session_start();
if (empty($_SESSION['admin_login'])) {
    header('location: login.php');
}
$admin = $_SESSION['admin_login'];

$queryview = mysqli_query($koneksi, "SELECT * FROM pengaturan LIMIT 1") or die(mysqli_error($koneksi));
$pengaturan = mysqli_fetch_array($queryview);
$acara = $pengaturan['acara'];
$acara = str_replace("<petik>", "'", $acara);
$logo = $pengaturan['logo'];

if (isset($_GET['uploadExcelFahmil'])) {
    $allowedExts = array("xls");
    $cek = 0;
    include "../koneksi.php";
    include './PHPExcel/IOFactory.php';
    for ($index = 1; $index <= 15; $index++) {
        $extension = pathinfo($_FILES['file' . $index]['name'], PATHINFO_EXTENSION);
        if (($_FILES["file". $index]["type"] == "application/vnd.ms-excel") || in_array($extension, $allowedExts)) {
            if ($_FILES["file". $index]["error"] <= 0) {
                move_uploaded_file($_FILES["file". $index]["tmp_name"], "ExcelTafsir/" . $_FILES["file". $index]["name"]);
                $inputFileName = './ExcelTafsir/' . $_FILES["file". $index]["name"];
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                } catch (Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                }
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
                $data = [];
                for ($row = 2; $row <= $highestRow; $row++) {
                    for ($col = 0; $col <= $colNumber; $col++) {
                        $data[$row - 2][$col] = addslashes($sheet->getCellByColumnAndRow($col, $row, true));
                    }
                }

                if ($data[0][0] != null) {
                    $queryoperasi = mysqli_query($koneksi, "delete from soal_fahmil where id_kategori = $index");
                    $temp = "";
                    $temp2 = "";
                    for ($row = 0; $row < count($data); $row++) {
                        if ($data[$row][0] != "" && $data[$row][1] != "") {
                            $querytambah = mysqli_query($koneksi, "INSERT INTO soal_fahmil VALUES(null, $index , '" . $data[$row][0] . "', '" . $data[$row][1] . "', 0);") or die(mysqli_error($koneksi));
                            $temp2 = $data[$row][0];
                        }
                    }
                }
            }
        } else {
            $cek++;
        }
    }
    if ($cek == 15) {
        header('location: fahmil.php?note=63');
    } else {
        if ($querytambah) {
            header('location: fahmil.php?note=8');
        } else {
            header('location: fahmil.php?note=81');
        }
    }
}
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
        <script src="js/jquery.min.js"></script>

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
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Pengaturan perlombaan telah diubah', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 12) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Pengaturan perlombaan tidak dapat diubah, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 2) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Pengaturan website telah diubah', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 21) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Gagal mengupload gambar, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 22) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Ukuran gambar terlalu besar, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 23) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Format file yang diperbolehkan hanya .jpg dan .png, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 3) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Data Bank Soal telah direset', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 31) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Data Bank Soal gagal direset, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 4) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Data Perlombaan telah direset', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 41) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Data Perlombaan tidak dapat direset, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 5) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Akun telah diedit', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 51) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Akun tidak dapat diedit, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 6) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Import Bank Soal baru berhasil disimpan', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 61) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Import Bank Soal gagal disimpan, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 62) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Excel dengan nama sama sudah ada, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 63) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Upload file dengan tipe xls, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 7) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Video berhasil terupload', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 71) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Video dengan nama sama sudah ada, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 72) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Upload file dengan ekstensi mp4. silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 8) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Import Soal MFQ berhasil disimpan', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 81) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Import Soal MFQ gagal disimpan, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 9) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Import Soal Tafsir berhasil disimpan', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 91) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Import Soal Tafsir gagal disimpan, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            }
        }
        ?>
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
            video{
                height: auto;
            }
        </style>
        <div class="container">
            <div style="text-align: center; padding: 20px"><b><?php echo $acara; ?></b><img style="margin-top: -10px" height="50px" src="../gambar/<?php echo $logo; ?>"></div>
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
                        <li><a href="index.php">Bank Soal</a></li>
                        <li class="active"><a href="fahmil.php">Bank Soal MFQ</a></li>
                        <li><a href="juri.php">Daftar Petugas</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pengaturan <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="about.php">Tentang</a></li>
                                <li ><a href="pengaturan.php">Pengaturan</a></li>
                                <li><a href="login.php">Keluar</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>

            <div class="row demo-samples">
                <div class="form-group">

                    <div class="col-xs-12">
                        <form action="fahmil.php?uploadExcelFahmil=1" method="POST" enctype="multipart/form-data">
                            <h5 style="text-align: center">Export & Import Soal Fahmil </h5>
                            <?php for ($i = 1; $i <= 15; $i++) { ?>
                                <table width="100%">
                                    <tr>
                                        <td width="20%">
                                            <h6>Kategori <?php echo $i; ?></h6>
                                        </td>
                                        <td width="60%">
                                            <input id="file<?php echo $i; ?>" name="file<?php echo $i; ?>" type="file" class="form-control">
                                        </td>
                                        <td width="20%">
                                            <a href="exportSoalFahmil.php?kategori=<?php echo $i; ?>" style="margin-left: 20px" target="_blank" class="btn btn-lg btn-inverse">Export Kategori <?php echo $i; ?></a>
                                        </td>
                                    </tr>
                                </table>
                            <?php } ?>


                            <button type="submit" style="margin-top: 10px" class="btn btn-block btn-lg btn-primary">Import Soal MFQ (xls)</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <script src="../dist/js/vendor/jquery.min.js"></script>
        <script src="../dist/js/vendor/video.js"></script>
        <script src="../dist/js/flat-ui.min.js"></script>
        <script src="../docs/assets/js/application.js"></script>

        <script>
            videojs.options.flash.swf = "../dist/js/vendors/video-js.swf"
        </script>
    </body>
</html>
