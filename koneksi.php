<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "alquranprog";
$koneksi = mysqli_connect($host, $user, $pass, $db);
$dbconnect = new mysqli($host, $user, $pass, $db);
if (mysqli_connect_errno()) {
    echo "Gagal Terhubung " . mysqli_connect_error();
}
if ($dbconnect->connect_error) {
    die('Database Not Connect. Error : ' . $dbconnect->connect_error);
}
?>