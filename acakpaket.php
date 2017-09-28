<?php

include "koneksi.php";
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$index = $_GET['kategori'];
$pecah = explode("_",$index);
$idkat = $pecah[1];
//echo $idkat;
$cek = false;
while ($cek == false) {
    $querypaket = mysqli_query($koneksi, "SELECT * FROM paket WHERE id_kategori = $idkat ORDER BY id") or die(mysqli_error($koneksi));
    $ceksoal = mysqli_query($koneksi, "SELECT * FROM penjurianpaket WHERE id_kategori = $idkat ORDER BY id") or die(mysqli_error($koneksi));
    $jumlahsoal = mysqli_num_rows($querypaket);
    $jumlahriwayatsoal = mysqli_num_rows($ceksoal);
    if ($jumlahsoal > $jumlahriwayatsoal) {
        $i = 1;
        $random = rand(1, $jumlahsoal);
        $paket = 0;
        while ($data = mysqli_fetch_array($querypaket)) {
            if ($i == $random) {
                $paket = $data['id'];
                //echo $paket;
                $kategori = $data['indexkategori'];
                $ceksoal = mysqli_query($koneksi, "SELECT * FROM penjurianpaket WHERE id_paket = $paket") or die(mysqli_error($koneksi));
                $soaldidb = mysqli_num_rows($ceksoal);
                if ($soaldidb == 0) {
                    $acakpaket = mysqli_query($koneksi, "INSERT INTO penjurianpaket VALUES('', $paket ,'$kategori', '$idkat')") or die(mysqli_error($koneksi));
                    $cek = true;
                }
            }
            $i++;
        }
    } else {
        $cek = true;
        $querypaket = false;
    }
}
if ($querypaket) {
    header('location: index.php?note=1&paket=' . $paket.'&pilihan='.$index);
} else {
    header('location: index.php?note=12&pilihan='.$index);
}





    