<?php

include "koneksi.php";
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$kategori = $_GET['kategori'];
if (strpos($kategori, "-") != false) {
    $kat = explode("-", $kategori);
    $where = "juz >= $kat[0] AND juz <= $kat[1]";
} else if (strpos($kategori, ",")) {
    $kat = explode(",", $kategori);
    $where = "";
    for ($i = 0; $i < count($kat); $i++) {
        if ($i == count($kat) - 1) {
            $where .= "juz = $kat[$i]";
        } else {
            $where .= "juz = $kat[$i] OR ";
        }
    }
} else {
    $where = "juz = $kategori";
}

$querypaket = mysqli_query($koneksi, "SELECT * FROM mutasyabihat WHERE $where ORDER BY id") or die(mysqli_error($koneksi));
$queryview = mysqli_query($koneksi, "SELECT * FROM pengaturan LIMIT 1") or die(mysqli_error($koneksi));
$pengaturan = mysqli_fetch_array($queryview);
$jumlahsoal = $pengaturan['jumlahsoal'];
$jumlahsoalacak = mysqli_num_rows($querypaket);
$jmlsoal = 0;
$soal = array();
$acakmanual = array(0, 0, 0, 0, 0);

while ($jmlsoal < $jumlahsoal) {
    $random = rand(1, $jumlahsoalacak);
    $cek = true;
    for ($i = 0; $i < count($soal); $i++) {
        if ($random == $soal[$i]) {
            $cek = false;
        }
    }
    if ($cek) {
        // tambahkan query cek data di database 
        $soal[$jmlsoal] = $random;
        $jmlsoal++;
    }
}

$a = 1;
while ($data = mysqli_fetch_array($querypaket)) {
    for ($i = 0; $i < $jumlahsoal; $i++) {
        if($a == $soal[$i]){
            $acakmanual[$i] = $data['id'];
            echo 'masuk';
        }
    }
    $a++;
}

foreach ($acakmanual as $nilai) {
    echo $nilai." ";
}

if ($jumlahsoal == 5) {
    $soal1 = $acakmanual[0];
    $soal2 = $acakmanual[1];
    $soal3 = $acakmanual[2];
    $soal4 = $acakmanual[3];
    $soal5 = $acakmanual[4];
    if ($querypaket) {
        header('location: penjurian.php?note=2&soal1=' . $soal1 . '&soal2=' . $soal2 . '&soal3=' . $soal3 . '&soal4=' . $soal4 . '&soal5=' . $soal5);
    } else {
        header('location: penjurian.php?note=21');
    }
} else if ($jumlahsoal == 4) {
    $soal1 = $acakmanual[0];
    $soal2 = $acakmanual[1];
    $soal3 = $acakmanual[2];
    $soal4 = $acakmanual[3];
    if ($querypaket) {
        header('location: penjurian.php?note=2&soal1=' . $soal1 . '&soal2=' . $soal2 . '&soal3=' . $soal3 . '&soal4=' . $soal4);
    } else {
        header('location: penjurian.php?note=21');
    }
} else {
    $soal1 = $acakmanual[0];
    $soal2 = $acakmanual[1];
    $soal3 = $acakmanual[2];
    if ($querypaket) {
        header('location: penjurian.php?note=2&soal1=' . $soal1 . '&soal2=' . $soal2 . '&soal3=' . $soal3);
    } else {
        header('location: penjurian.php?note=21');
    }
}


