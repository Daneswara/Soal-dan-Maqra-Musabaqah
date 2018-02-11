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
if (isset($_GET['operasi'])) {
    $operasi = $_GET['operasi'];

    if ($operasi == "resetBank") {
        $queryoperasi = mysqli_query($koneksi, "TRUNCATE kategori");
        $queryoperasi = mysqli_query($koneksi, "TRUNCATE paket");
        $queryoperasi = mysqli_query($koneksi, "TRUNCATE soal");
        if ($queryoperasi) {
            header('location: pengaturan.php?note=3');
        } else {
            header('location: pengaturan.php?note=31');
        }
    } else if ($operasi == "resetPerlombaan") {
        $queryoperasi = mysqli_query($koneksi, "TRUNCATE penjurian;");
        $queryoperasi = mysqli_query($koneksi, "TRUNCATE penjurianpaket;");

        $queryoperasi = mysqli_query($koneksi, "TRUNCATE mutasyabihat;");
        $table_name = "mutasyabihat";
        $path = realpath(dirname(__FILE__));
        $path = str_replace("\\", "/", $path);
        $backup_file = $path . "/database/mutasyabihat.sql";
        $sql = "LOAD DATA INFILE '$backup_file' INTO TABLE $table_name";

        $query_mysql = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

        $update = mysqli_query($koneksi, "UPDATE soal_fahmil SET `status` = 0 WHERE status = 1;") or die(mysqli_error($koneksi));

        if ($queryoperasi) {
            header('location: pengaturan.php?note=4');
        } else if ($query_mysql) {
            header('location: pengaturan.php?note=4');
        } else {
            header('location: pengaturan.php?note=41');
        }
    }
}
if (isset($_GET['editpengaturan'])) {
    $qori = $_POST['qori'];
    $jumlahsoal = $_POST['jumlahsoal'];
    $jumlahsoalmudah = $_POST['jumlahsoalmudah'];
    $queryupdate = mysqli_query($koneksi, "UPDATE pengaturan SET qori = '$qori', jumlahsoal = '$jumlahsoal', jumlahsoalmudah = '$jumlahsoalmudah' WHERE id = 1") or die(mysqli_error($koneksi));
    if ($queryupdate) {
        header('location: pengaturan.php?note=1');
    } else {
        header('location: pengaturan.php?note=12');
    }
}
if (isset($_GET['editakun'])) {
    $usernameakun = $_POST['username'];
    $passwordakun = md5($_POST['password']);
    $queryupdate = mysqli_query($koneksi, "UPDATE admin SET username = '$usernameakun', password = '$passwordakun' WHERE username = '$admin'") or die(mysqli_error($koneksi));
    if ($queryupdate) {
        $_SESSION['admin_login'] = $usernameakun;
        header('location: pengaturan.php?note=5');
    } else {
        header('location: pengaturan.php?note=51');
    }
}
if (isset($_GET['uploadLogo'])) {
    $ekstensi_diperbolehkan = array('png', 'jpg');
    $namaacara = $_POST['acara'];
    $namaacara = str_replace("'", "<petik>", $namaacara);
    $nama = $_FILES['filelogo']['name'];
    $x = explode('.', $nama);
    $ekstensi = strtolower(end($x));
    $ukuran = $_FILES['filelogo']['size'];
    $file_tmp = $_FILES['filelogo']['tmp_name'];
    if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
        if ($ukuran < 5044070) {
            move_uploaded_file($file_tmp, '../gambar/' . $nama);
            $query = mysqli_query($koneksi, "UPDATE pengaturan SET acara = '$namaacara', logo = '$nama' LIMIT 1");
            if ($query) {
                header('location: pengaturan.php?note=2');
            } else {
                header('location: pengaturan.php?note=21');
            }
        } else {
            header('location: pengaturan.php?note=22');
        }
    } else {
        header('location: pengaturan.php?note=23');
    }
}
if (isset($_GET['uploadVideo'])) {
    $allowedExts = array("mp4");
    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
//    echo 'echo ' . $_FILES["file"]["type"];
    if (($_FILES["file"]["type"] == "video/mp4") && in_array($extension, $allowedExts)) {
        if ($_FILES["file"]["error"] > 0) {
//            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
        } else {
//            echo "Upload: " . $_FILES["file"]["name"] . "<br />";
//            echo "Type: " . $_FILES["file"]["type"] . "<br />";
//            echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
//            echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

            if (file_exists("../upload/" . $_FILES["file"]["name"])) {
                header('location: pengaturan.php?note=71');
//                echo $_FILES["file"]["name"] . " already exists. ";
            } else {
                move_uploaded_file($_FILES["file"]["tmp_name"], "../upload/" . $_FILES["file"]["name"]);
                $query = mysqli_query($koneksi, "UPDATE pengaturan SET link_video = '" . $_FILES["file"]["name"] . "' LIMIT 1");
//                echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
                header('location: pengaturan.php?note=7');
            }
        }
    } else {
        header('location: pengaturan.php?note=72');
    }
}
if (isset($_GET['uploadExcel'])) {
    $allowedExts = array("xls");
    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
//    echo 'echo ' . $_FILES["file"]["type"];
    if (($_FILES["file"]["type"] == "application/vnd.ms-excel") && in_array($extension, $allowedExts)) {
        if ($_FILES["file"]["error"] > 0) {
//            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
        } else {
//            echo "Upload: " . $_FILES["file"]["name"] . "<br />";
//            echo "Type: " . $_FILES["file"]["type"] . "<br />";
//            echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
//            echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
            //if (file_exists("Excel/".$_FILES["file"]["name"])) {
            //  echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Excel dengan nama sama sudah ada, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
//              //  echo $_FILES["file"]["name"] . " already exists. ";
            //header('location: pengaturan.php?note=62');
            //} else {
            move_uploaded_file($_FILES["file"]["tmp_name"], "Excel/" . $_FILES["file"]["name"]);
//                $query = mysqli_query($koneksi, "UPDATE pengaturan SET link_video = '".$_FILES["file"]["name"]."' LIMIT 1");
//                echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
            echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Excel berhasil terupload', confirmButtonColor: '#1abc9c', type: 'success'})</script>";

            // simpan isi file excel ke database
            include "../koneksi.php";
//  Include PHPExcel_IOFactory\
            include './PHPExcel/IOFactory.php';

            $inputFileName = './Excel/' . $_FILES["file"]["name"];

//  Read your Excel workbook
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }

//  Get worksheet dimensions
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $data = [];
//  Loop through each row of the worksheet in turn
            for ($row = 2; $row <= $highestRow; $row++) {
                //  Read a row of data into an array
                for ($col = 0; $col <= $colNumber; $col++) {
                    $data[$row - 2][$col] = $sheet->getCellByColumnAndRow($col, $row, true);
                    //echo $data[$row - 2][$col] . ' ';
                }
                // '<br>';
                //  Insert row data array into your database of choice here
            }

            if ($data[0][0] != null) {
                $queryoperasi = mysqli_query($koneksi, "TRUNCATE kategori");
                $queryoperasi = mysqli_query($koneksi, "TRUNCATE paket");
                $queryoperasi = mysqli_query($koneksi, "TRUNCATE soal");
                $temp = "";
                $temp2 = "";
                for ($row = 0; $row < count($data); $row++) {
                    //$idpaket = explode("-", $data[$row][5]); // id urutan nama jenis index
                    if ($temp != $data[$row][0]) {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO kategori VALUES(" . $data[$row][0] . ", " . $data[$row][3] . ",'" . $data[$row][2] . "','" . $data[$row][1] . "','" . $data[$row][4] . "');") or die(mysqli_error($koneksi));
                        $temp = $data[$row][0];
                    }
                    if ($temp2 != $data[$row][5] && $data[$row][5] != null && $data[$row][5] != "") {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO paket VALUES(" . $data[$row][5] . ", '" . $data[$row][0] . "', '" . $data[$row][4] . "', '" . $data[$row][6] . "');") or die(mysqli_error($koneksi));
                        $temp2 = $data[$row][5];
                    }
                    if ($data[$row][8] != null && $data[$row][8] != "") {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO soal VALUES(NULL, " . $data[$row][5] . "," . $data[$row][7] . "," . $data[$row][8] . "," . $data[$row][9] . "," . $data[$row][10] . "," . $data[$row][11] . ");") or die(mysqli_error($koneksi));
                    }
                }


                if ($querytambah) {
                    header('location: pengaturan.php?note=6');
                } else {
                    header('location: pengaturan.php?note=61');
                }
            }
            //}
        }
    } else {
        header('location: pengaturan.php?note=63');
    }
}
if (isset($_GET['uploadExcelTafsir'])) {
    $allowedExts = array("xls");
    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
//    echo 'echo ' . $_FILES["file"]["type"];
    if (($_FILES["file"]["type"] == "application/vnd.ms-excel") && in_array($extension, $allowedExts)) {
        if ($_FILES["file"]["error"] > 0) {

        } else {
            move_uploaded_file($_FILES["file"]["tmp_name"], "ExcelTafsir/" . $_FILES["file"]["name"]);
//                $query = mysqli_query($koneksi, "UPDATE pengaturan SET link_video = '".$_FILES["file"]["name"]."' LIMIT 1");
//                echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
            echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Excel berhasil terupload', confirmButtonColor: '#1abc9c', type: 'success'})</script>";

            // simpan isi file excel ke database
            include "../koneksi.php";
//  Include PHPExcel_IOFactory\
            include './PHPExcel/IOFactory.php';

            $inputFileName = './ExcelTafsir/' . $_FILES["file"]["name"];

//  Read your Excel workbook
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }

//  Get worksheet dimensions
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $data = [];
//  Loop through each row of the worksheet in turn
            for ($row = 2; $row <= $highestRow; $row++) {
                //  Read a row of data into an array
                for ($col = 0; $col <= $colNumber; $col++) {
                    $data[$row - 2][$col] = $sheet->getCellByColumnAndRow($col, $row, true);
                    //echo $data[$row - 2][$col] . ' ';
                }
                // '<br>';
                //  Insert row data array into your database of choice here
            }

            if ($data[0][0] != null) {
                // buat operasi database updatenya
                //$queryoperasi = mysqli_query($koneksi, "TRUNCATE kategori_fahmil");
                $sql = "SELECT kategori.id as kategori, paket.id as paket "
                        . "FROM soal_tafsir left join paket on soal_tafsir.paket = paket.id left join kategori on paket.id_kategori = kategori.id;";
                $setRec = mysqli_query($koneksi, $sql);
                $temp = "";
                $temp2 = "";
                while ($datatafsir = mysqli_fetch_array($setRec)) {
                    if($datatafsir['kategori'] != $temp){
                        $temp = $datatafsir['kategori'];
                        $queryoperasi = mysqli_query($koneksi, "DELETE FROM kategori where id = $temp;");
                    }
                    if($datatafsir['paket'] != $temp2){
                        $temp2 = $datatafsir['paket'];
                        $queryoperasi = mysqli_query($koneksi, "DELETE FROM paket where id = $temp2;");
                    }
                }

                $queryoperasi = mysqli_query($koneksi, "TRUNCATE soal_tafsir;");
                $temp = "";
                $temp2 = "";
                $temp3 = "";
                for ($row = 0; $row < count($data); $row++) {
                    //$idpaket = explode("-", $data[$row][5]); // id urutan nama jenis index
                    if ($temp != $data[$row][1]) {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO kategori VALUES(" . $data[$row][1] . ", 8, 'Tafsir', '" . $data[$row][2] . "', '1-30');") or die(mysqli_error($koneksi));
                        $temp = $data[$row][1];
                    }
                    if ($temp3 != $data[$row][3]) {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO paket VALUES(" . $data[$row][3] . "," . $data[$row][1] . ", '1-30', '" . $data[$row][4] . "');") or die(mysqli_error($koneksi));
                        $temp3 = $data[$row][3];
                    }
                    if ($temp2 != $data[$row][0]) {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO soal_tafsir VALUES(" . $data[$row][0] . ", " . $data[$row][3] . ", " . $data[$row][5] . ", '" . $data[$row][6] . "', '" . $data[$row][7] . "');") or die(mysqli_error($koneksi));
                        $temp2 = $data[$row][0];
                    }
                }


                if ($querytambah) {
                    header('location: pengaturan.php?note=9');
                } else {
                    header('location: pengaturan.php?note=91');
                }
            }
            //}
        }
    } else {
        header('location: pengaturan.php?note=63');
    }
}
$queryview = mysqli_query($koneksi, "SELECT * FROM pengaturan LIMIT 1") or die(mysqli_error($koneksi));
$pengaturan = mysqli_fetch_array($queryview);
$qori = $pengaturan['qori'];
$jumlahsoal = $pengaturan['jumlahsoal'];
$jumlahsoalmudah = $pengaturan['jumlahsoalmudah'];
$acara = $pengaturan['acara'];
$acara = str_replace("<petik>", "'", $acara);
$logo = $pengaturan['logo'];
$datadmin = mysqli_query($koneksi, "SELECT * FROM admin WHERE username = '$admin'") or die(mysqli_error($koneksi));
$user = mysqli_fetch_array($datadmin);
$username = $user['username'];
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
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Import Soal Fahmil berhasil disimpan', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 81) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Import Soal Fahmil gagal disimpan, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 9) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Import Soal Tafsir berhasil disimpan', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 91) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Import Soal Tafsir gagal disimpan, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            }
        }
        ?>
        <script type='text/javascript'>
            function resetBank() {
                swal({title: 'Apakah anda yakin ingin mereset Bank Soal?',
                    text: 'anda tidak akan dapat mengembalikan seluruh kategori beserta isi paket soal yang telah dihapus!',
                    confirmButtonColor: '#DD6B55',
                    closeOnConfirm: false,
                    confirmButtonText: 'Iya hapus!', cancelButtonText: 'Batal',
                    showCancelButton: true,
                    type: 'warning'},
                function () {
                    window.location = "pengaturan.php?operasi=resetBank";
                });
            }
            function resetPerlombaan() {
                swal({title: 'Apakah anda yakin ingin mereset Perlombaan?',
                    text: 'anda tidak akan dapat mengembalikan seluruh riwayat perlombaan yang telah dihapus!',
                    confirmButtonColor: '#DD6B55',
                    closeOnConfirm: false,
                    confirmButtonText: 'Iya hapus!', cancelButtonText: 'Batal',
                    showCancelButton: true,
                    type: 'warning'},
                function () {
                    window.location = "pengaturan.php?operasi=resetPerlombaan";
                });
            }
            $(document).ready(function () {
                $("#jumlahsoal").change(function () {
                    var val = $(this).val();
                    if (val == "0") {
                        $("#jumlahsoalmudah").html("<option value='0'>0 Soal</option><option value='1'>1 Soal</option><option value='2'>2 Soal</option><option value='3'>3 Soal</option><option value='4'>4 Soal</option><option value='5'>5 Soal</option><option value='6'>6 Soal</option>");
                    } else if (val == "1") {
                        $("#jumlahsoalmudah").html("<option value='0'>0 Soal</option><option value='1'>1 Soal</option><option value='2'>2 Soal</option><option value='3'>3 Soal</option><option value='4'>4 Soal</option><option value='5'>5 Soal</option>");
                    } else if (val == "2") {
                        $("#jumlahsoalmudah").html("<option value='0'>0 Soal</option><option value='1'>1 Soal</option><option value='2'>2 Soal</option><option value='3'>3 Soal</option><option value='4'>4 Soal</option>");
                    } else if (val == "3") {
                        $("#jumlahsoalmudah").html("<option value='0'>0 Soal</option><option value='1'>1 Soal</option><option value='2'>2 Soal</option><option value='3'>3 Soal</option>");
                    } else if (val == "4") {
                        $("#jumlahsoalmudah").html("<option value='0'>0 Soal</option><option value='1'>1 Soal</option><option value='2'>2 Soal</option>");
                    } else if (val == "5") {
                        $("#jumlahsoalmudah").html("<option value='0'>0 Soal</option><option value='1'>1 Soal</option>");
                    } else if (val == "6") {
                        $("#jumlahsoalmudah").html("<option value='0'>0 Soal</option>");
                    }
                });
            });
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
            video{
                height: auto;
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
                    <a class="navbar-brand" style="padding-top: 10px; line-height: 1.15; text-align: center" href="#"><font size=4> SOAL DAN MAQRA'</font><br> MUSABAQAH</a>
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
                                <li class="active"><a href="pengaturan.php">Pengaturan</a></li>
                                <li><a href="login.php">Keluar</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>

            <div class="row demo-samples">
                <div class="form-group">
                    <div class="col-xs-12">
                        <form action="pengaturan.php?editpengaturan=1" method="POST">
                            <h5>Pengaturan Perlombaan</h5>
                            <table width="100%">
                                <tr>
                                    <td width="50%">
                                        <h6>Qori</h6>
                                    </td>
                                    <td width="50%">
                                        <select id="qori" name="qori" class="form-control select select-primary" data-toggle="select">
                                            <option value="husari" <?php if ($qori == "husari") echo 'selected'; ?>>Al-Husari</option>
                                            <option value="mishari" <?php if ($qori == "mishari") echo 'selected'; ?>>Mishari Al-efasi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%">
                                        <h6>Jumlah Soal Acak Otomatis <font color="red">(Sulit) </font></h6>
                                    </td>
                                    <td width="50%">
                                        <select id="jumlahsoal" name="jumlahsoal" class="form-control select select-primary" data-toggle="select">
                                            <option value="0" <?php if ($jumlahsoal == 0) echo 'selected'; ?>>0 Soal</option>
                                            <option value="1" <?php if ($jumlahsoal == 1) echo 'selected'; ?>>1 Soal</option>
                                            <option value="2" <?php if ($jumlahsoal == 2) echo 'selected'; ?>>2 Soal</option>
                                            <option value="3" <?php if ($jumlahsoal == 3) echo 'selected'; ?>>3 Soal</option>
                                            <option value="4" <?php if ($jumlahsoal == 4) echo 'selected'; ?>>4 Soal</option>
                                            <option value="5" <?php if ($jumlahsoal == 5) echo 'selected'; ?>>5 Soal</option>
                                            <option value="6" <?php if ($jumlahsoal == 6) echo 'selected'; ?>>6 Soal</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%">
                                        <h6>Jumlah Soal Acak Otomatis <font color="red">(Mudah) </font> </h6>
                                    </td>
                                    <td width="50%">
                                        <select id="jumlahsoalmudah" name="jumlahsoalmudah" class="form-control select select-primary" data-toggle="select">
                                            <?php echo "<option value='$jumlahsoalmudah' selected>$jumlahsoalmudah Soal</option>"; ?>


                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <button type="submit" style="margin-top: 10px" class="btn btn-block btn-lg btn-primary">Simpan</button>
                                    </td>
                                </tr>
                            </table>

                        </form>
                    </div>
                    <div class="col-xs-12">
                        <form action="pengaturan.php?uploadLogo=1" method="POST" enctype="multipart/form-data">
                            <h5 style="margin-top: 25px">Pengaturan Website</h5>
                            <table width="100%">
                                <tr>
                                    <td width="50%">
                                        <h6>Nama Acara</h6>
                                    </td>
                                    <td width="50%">
                                        <input id="acara" name="acara" required="" type="text" value="<?php echo $acara; ?>" placeholder="Masukkan Nama Acara" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%">
                                        <h6>Logo Penyelenggara </h6>
                                    </td>
                                    <td width="50%">
                                        <input id="filelogo" name="filelogo" type="file" class="form-control"></input>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <button type="submit" style="margin-top: 10px" class="btn btn-block btn-lg btn-primary">Simpan</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <br>
                        <form action="pengaturan.php?uploadVideo=1" method="POST" enctype="multipart/form-data">

                            <table width="100%">
                                <tr>
                                    <td width="50%">
                                        <h6>Video Penyelenggara </h6>
                                    </td>
                                    <td width="50%">
                                        <input id="file" name="file" type="file" class="form-control"></input>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <button type="submit" style="margin-top: 10px" class="btn btn-block btn-lg btn-primary">Upload Video (mp4)</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div class="col-xs-12">
                        <form action="pengaturan.php?editakun=1" method="POST">
                            <h5 style="margin-top: 25px">Pengaturan Akun</h5>
                            <table width="100%">
                                <tr>
                                    <td width="50%">
                                        <h6>Username</h6>
                                    </td>
                                    <td width="50%">
                                        <input id="username" name="username" type="text" value="<?php echo $username; ?>" required="" placeholder="Masukkan Username Baru" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%">
                                        <h6>Password </h6>
                                    </td>
                                    <td width="50%">
                                        <input type="password" id="password" name="password" required="" value="" placeholder="Masukkan Password Baru" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <button type="submit" style="margin-top: 10px" class="btn btn-block btn-lg btn-primary">Simpan</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <br>

                    <div class="col-xs-12" style="margin-top: 25px">
                        <form action="pengaturan.php?uploadExcel=1" method="POST" enctype="multipart/form-data">

                            <table width="100%">
                                <tr>
                                    <td width="50%">
                                        <h5>Pengaturan Bank Soal </h5>
                                    </td>
                                    <td width="50%">
                                        <input id="file" name="file" type="file" class="form-control"></input>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <button type="submit" style="margin-top: 10px" class="btn btn-block btn-lg btn-primary">Upload Bank Soal (xls)</button>
                                        <a href="exportBankData.php" target="_blank" style="margin-top: 15px" class="btn btn-block btn-lg btn-primary">Export Bank Data</a>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <form action="pengaturan.php?uploadExcelTafsir=1" method="POST" enctype="multipart/form-data">
                            <table width="100%">
                                <tr>
                                    <td width="50%">
                                    </td>

                                    <td>
                                        <h5 style="text-align: center">Soal Tafsir </h5>
                                        <input id="file" name="file" type="file" class="form-control"></input>
                                        <button type="submit" style="margin-top: 10px" class="btn btn-block btn-lg btn-primary">Upload Soal Tafsir (xls)</button>
                                        <a href="exportSoalTafsir.php" target="_blank" style="margin-top: 15px" class="btn btn-block btn-lg btn-primary">Export Soal Tafsir</a>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%">
                        </form>
                        <tr>
                            <td width="50%">
                                <h5>Pengaturan Database</h5>
                            </td>
                            <td width="50%">

                                <a onclick="resetBank();" style="margin-top: 15px" class="btn btn-block btn-lg btn-danger">Reset Bank Soal</a>
                                <a onclick="resetPerlombaan();" style="margin-top: 15px" class="btn btn-block btn-lg btn-danger">Reset Perlombaan</a>
                            </td>
                        </tr>
                        </table>
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
