<?php
include "koneksi.php";

$table_name = "mutasyabihat";
$path = realpath(dirname(__FILE__));
$path = str_replace("\\", "/", $path);
$backup_file  = $path."/database/mutasyabihat.sql";
$sql = "SELECT * INTO OUTFILE '$backup_file' FROM $table_name";
 
$query_mysql = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

if(!$query_mysql)
{
  die('Gagal Backup: ' . mysqli_error($koneksi));
}
echo "Backup Berhasil\n";
?>