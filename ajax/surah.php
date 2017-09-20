<?php

//get value from page

$kategori = $_POST['kategori'];
//Conect with the database
require_once '../koneksi.php';

$query_mysql = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE kategori = '$kategori' ORDER BY nosurat") or die(mysqli_error($koneksi));
$msg = '';
if (mysqli_num_rows($query_mysql) == 0) {
    $msg .= "<option value=''>Tidak Ada Surah</option>";
} else {
    while ($data = mysqli_fetch_array($query_mysql)) {
        $msg .= "<option value='" . $data['nosurat'] . "'>" . $data['nosurat'] .". ". $data['nama'] . "</option>";
    }
}
echo $msg;
?>