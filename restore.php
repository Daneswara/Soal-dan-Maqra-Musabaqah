<?php
include "koneksi.php";

$table_name = "coba";
$backup_file  = "F:/tabel.sql";

$sql = "LOAD DATA INFILE '$backup_file' INTO TABLE $table_name";

$query_mysql = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

if(!$query_mysql)
{
  die('Gagal Backup: ' . mysqli_error($koneksi));
}
echo "Restore Berhasil\n";
?>