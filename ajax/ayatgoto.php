<?php

//get value from page

$surah = $_POST['surah'];
//Conect with the database
require_once '../koneksi.php';

$query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE nosurat = '$surah'") or die(mysqli_error($koneksi));
$msg = '';
if (mysqli_num_rows($query_mysql) == 0) {
    $msg .= "<option value=''>Tidak Ada Ayat</option>";
} else {
    while ($data = mysqli_fetch_array($query_mysql)) {
        for ($a = $data['awal']; $a <= $data['akhir']; $a++) {
            $msg .= "<option value='" . $a . "'>" . $a . "</option>";
        }
    }
}
echo $msg;
?>