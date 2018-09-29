<?php

include "koneksi.php";
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$status = true;
$fahmil = 15;
for ($j = 1; $j <= $fahmil; $j++) {
    # code...
    $acakkategori = mysqli_query($koneksi, "SELECT * FROM soal_fahmil WHERE id_kategori = $j AND status = 0 ORDER BY id;") or die(mysqli_error($koneksi));
    $jumlahsoal = mysqli_num_rows($acakkategori);
    if ($jumlahsoal > 0) {
        $random = rand(1, $jumlahsoal);
        $i = 1;
        while ($data = mysqli_fetch_array($acakkategori)) {
            if ($i == $random) {
                // echo "<br>rand".$random;
                $soal['soal' . $j] = $data['soal'];
                $soal['jawaban' . $j] = $data['jawaban'];
                $_SESSION['soal' . $j] = $data['soal'];
                $_SESSION['jawaban' . $j] = $data['jawaban'];
                $idkat[$j] = $data['id'];
                
            }
            $i++;
        }
// echo "<br>soal".$soal[$j];
// echo "<br>jawab".$jawab[$j];
    } else {
        $status = false;
    }
}


if ($status) {
    for ($i = 1; $i <= $fahmil; $i++){
        $idne = $idkat[$i];
        $update = mysqli_query($koneksi, "UPDATE soal_fahmil SET `status` = 1 WHERE id = $idne AND status = 0;") or die(mysqli_error($koneksi));
    }
    header('location: fahmil.php?note=1&acak=1');
} else {
    header('location: fahmil.php?note=12');
}

    