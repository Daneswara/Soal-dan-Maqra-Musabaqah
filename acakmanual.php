<?php

include "koneksi.php";
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$getkat = $_GET['kategori'];
$pecah = explode("_",$getkat);

$kategori = $pecah[0];
$index = $_GET['kategori'];

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
$jumlahsoalmudah = $pengaturan['jumlahsoalmudah'];
$jumlahsoalacak = mysqli_num_rows($querypaket);
$jmlsoal = 0;
$soal = array();
$acakmanual = array(0, 0, 0, 0, 0, 0);
if ($jumlahsoalacak < $jumlahsoal) {
    header('location: index.php?note=22');
}
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
        if ($a == $soal[$i]) {
            $acakmanual[$i] = $data['id'];
        }
    }
    $a++;
}

//foreach ($acakmanual as $nilai) {
//    echo $nilai . " ";
//}

//$kategori = $_GET['kategori'];
$kategori = $pecah[0];
if (strpos($kategori, "-") != false) {
    $kat = explode("-", $kategori);
    $where = "kategori >= $kat[0] AND kategori <= $kat[1]";
} else if (strpos($kategori, ",")) {
    $kat = explode(",", $kategori);
    $where = "";
    for ($i = 0; $i < count($kat); $i++) {
        if ($i == count($kat) - 1) {
            $where .= "kategori = $kat[$i]";
        } else {
            $where .= "kategori = $kat[$i] OR ";
        }
    }
} else {
    $where = "kategori = $kategori";
}
$querymudah = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where AND id != 1 ORDER BY id") or die(mysqli_error($koneksi));
$jumlahacakmudah = mysqli_num_rows($querymudah);
$i = 0;
$surahacak = array();
$ayatacak = array();
while ($i < $jumlahsoalmudah) {
    $queryambilsoal1 = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where AND id != 1 ORDER BY id") or die(mysqli_error($koneksi));
    $queryambilsoal2 = mysqli_query($koneksi, "SELECT * FROM daftarsurah WHERE $where AND id != 1 ORDER BY id") or die(mysqli_error($koneksi));
    $random = rand(1, $jumlahacakmudah);
    $total = 0;
    while ($data = mysqli_fetch_array($queryambilsoal1)) {
        $selisih = $data['akhir'] - $data['awal'] + 1;
        $total += $selisih;
    }
//    echo 'total' . $total;
    $random = rand(1, $total);
//    echo 'hasil random ' . $random;
    $hasilacakcek = 0;
    while ($data = mysqli_fetch_array($queryambilsoal2)) {
        for ($awal = $data['awal']; $awal <= $data['akhir']; $awal++){
            $hasilacakcek += 1;
            if($hasilacakcek == $random){
                $surahke = $data['nosurat'];
                $namake = $data['nama'];
                $ayatke = $awal;
                //if (isMutashabihat($surahke, $ayatke)) {
//                echo 'tidak bisa';
                //    $i--;
                //} else {
    //                echo 'bisa';
                    $querycek0 = mysqli_query($koneksi, "SELECT * FROM penjurian WHERE nosurat=$surahke AND ayat=$ayatke;") or die(mysqli_error($koneksi));
                    $cek = mysqli_num_rows($querycek0);
                    if ($cek == 0) {
                        $db = mysqli_query($koneksi, "INSERT INTO penjurian VALUES('', $surahke, $ayatke);") or die(mysqli_error($koneksi));
                        $surahacak[$i] = $surahke;
                        $ayatacak[$i] = $ayatke;
    //                    echo 'masuk ke-' . $i;
                    } else {
                        $i--;
                    }
                // }
                break;
            }
        }
//        echo 'keluar';
    }
    $i++;
//    echo '<br>soal ganti<br>';
}

function isMutashabihat($surah, $ayat) {
    include "koneksi.php";
    $ayat5 = $ayat + 5;
    $querycek0 = mysqli_query($koneksi, "SELECT * FROM cekayatmutasyabihat WHERE nosurat=$surah AND ayat>=$ayat AND ayat<=$ayat5;") or die(mysqli_error($koneksi));
    $cek = mysqli_num_rows($querycek0);
    if ($cek > 0) {
        return true;
    } else {
        return false;
    }
}

if ($jumlahsoal == 6) {
    $soal1 = $acakmanual[0];
    $soal2 = $acakmanual[1];
    $soal3 = $acakmanual[2];
    $soal4 = $acakmanual[3];
    $soal5 = $acakmanual[4];
    $soal6 = $acakmanual[5];
    if ($querypaket) {
        header('location: index.php?note=2&soal1=' . $soal1 . '&soal2=' . $soal2 . '&soal3=' . $soal3 . '&soal4=' . $soal4 . '&soal5=' . $soal5 . '&soal6=' . $soal6 .'&pilihan=' . $index);
    } else {
        header('location: index.php?note=21&pilihan=' . $index);
    }
} else if ($jumlahsoal == 5) {
    $soal1 = $acakmanual[0];
    $soal2 = $acakmanual[1];
    $soal3 = $acakmanual[2];
    $soal4 = $acakmanual[3];
    $soal5 = $acakmanual[4];
    if ($querypaket) {
        if ($jumlahsoalmudah == 1) {
            header('location: index.php?note=2&soal1=' . $soal1 . '&soal2=' . $soal2 . '&soal3=' . $soal3 . '&soal4=' . $soal4 . '&soal5=' . $soal5 . '&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&pilihan=' . $index);
        } else {
            header('location: index.php?note=2&soal1=' . $soal1 . '&soal2=' . $soal2 . '&soal3=' . $soal3 . '&soal4=' . $soal4 . '&soal5=' . $soal5 . '&pilihan=' . $index);
        }
    } else {
        header('location: index.php?note=21&pilihan=' . $index);
    }
} else if ($jumlahsoal == 4) {
    $soal1 = $acakmanual[0];
    $soal2 = $acakmanual[1];
    $soal3 = $acakmanual[2];
    $soal4 = $acakmanual[3];
    if ($querypaket) {
        if ($jumlahsoalmudah == 1) {
            header('location: index.php?note=2&soal1=' . $soal1 . '&soal2=' . $soal2 . '&soal3=' . $soal3 . '&soal4=' . $soal4 . '&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&pilihan=' . $index);
        } else if ($jumlahsoalmudah == 2) {
            header('location: index.php?note=2&soal1=' . $soal1 . '&soal2=' . $soal2 . '&soal3=' . $soal3 . '&soal4=' . $soal4 . '&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&surat2=' . $surahacak[1] . '&ayat2=' . $ayatacak[1] . '&pilihan=' . $index);
        } else {
            header('location: index.php?note=2&soal1=' . $soal1 . '&soal2=' . $soal2 . '&soal3=' . $soal3 . '&soal4=' . $soal4 . '&pilihan=' . $index);
        }
    } else {
        header('location: index.php?note=21&pilihan=' . $index);
    }
} else if ($jumlahsoal == 3) {
    $soal1 = $acakmanual[0];
    $soal2 = $acakmanual[1];
    $soal3 = $acakmanual[2];
    if ($querypaket) {
        if ($jumlahsoalmudah == 1) {
            header('location: index.php?note=2&soal1=' . $soal1 . '&soal2=' . $soal2 . '&soal3=' . $soal3 . '&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&pilihan=' . $index);
        } else if ($jumlahsoalmudah == 2) {
            header('location: index.php?note=2&soal1=' . $soal1 . '&soal2=' . $soal2 . '&soal3=' . $soal3 . '&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&surat2=' . $surahacak[1] . '&ayat2=' . $ayatacak[1] . '&pilihan=' . $index);
        } else if ($jumlahsoalmudah == 3) {
            header('location: index.php?note=2&soal1=' . $soal1 . '&soal2=' . $soal2 . '&soal3=' . $soal3 . '&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&surat2=' . $surahacak[1] . '&ayat2=' . $ayatacak[1] . '&surat3=' . $surahacak[2] . '&ayat3=' . $ayatacak[2] . '&pilihan=' . $index);
        } else {
            header('location: index.php?note=2&soal1=' . $soal1 . '&soal2=' . $soal2 . '&soal3=' . $soal3 . '&pilihan=' . $index);
        }
    } else {
        header('location: index.php?note=21&pilihan=' . $index);
    }
} else if ($jumlahsoal == 2) {
    $soal1 = $acakmanual[0];
    $soal2 = $acakmanual[1];
    if ($querypaket) {
        if ($jumlahsoalmudah == 1) {
            header('location: index.php?note=2&soal1=' . $soal1 . '&soal2=' . $soal2 . '&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&pilihan=' . $index);
        } else if ($jumlahsoalmudah == 2) {
            header('location: index.php?note=2&soal1=' . $soal1 . '&soal2=' . $soal2 . '&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&surat2=' . $surahacak[1] . '&ayat2=' . $ayatacak[1] . '&pilihan=' . $index);
        } else if ($jumlahsoalmudah == 3) {
            header('location: index.php?note=2&soal1=' . $soal1 . '&soal2=' . $soal2 . '&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&surat2=' . $surahacak[1] . '&ayat2=' . $ayatacak[1] . '&surat3=' . $surahacak[2] . '&ayat3=' . $ayatacak[2] . '&pilihan=' . $index);
        } else if ($jumlahsoalmudah == 4) {
            header('location: index.php?note=2&soal1=' . $soal1 . '&soal2=' . $soal2 . '&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&surat2=' . $surahacak[1] . '&ayat2=' . $ayatacak[1] . '&surat3=' . $surahacak[2] . '&ayat3=' . $ayatacak[2] . '&surat4=' . $surahacak[3] . '&ayat4=' . $ayatacak[3] . '&pilihan=' . $index);
        } else {
            header('location: index.php?note=2&soal1=' . $soal1 . '&soal2=' . $soal2 . '&pilihan=' . $index);
        }
    } else {
        header('location: index.php?note=21&pilihan=' . $index);
    }
} else if ($jumlahsoal == 1){
    $soal1 = $acakmanual[0];
    if ($querypaket) {
        if ($jumlahsoalmudah == 1) {
            header('location: index.php?note=2&soal1=' . $soal1 . '&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&pilihan=' . $index);
        } else if ($jumlahsoalmudah == 2) {
            header('location: index.php?note=2&soal1=' . $soal1 . '&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&surat2=' . $surahacak[1] . '&ayat2=' . $ayatacak[1] . '&pilihan=' . $index);
        } else if ($jumlahsoalmudah == 3) {
            header('location: index.php?note=2&soal1=' . $soal1 . '&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&surat2=' . $surahacak[1] . '&ayat2=' . $ayatacak[1] . '&surat3=' . $surahacak[2] . '&ayat3=' . $ayatacak[2] . '&pilihan=' . $index);
        } else if ($jumlahsoalmudah == 4) {
            header('location: index.php?note=2&soal1=' . $soal1 . '&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&surat2=' . $surahacak[1] . '&ayat2=' . $ayatacak[1] . '&surat3=' . $surahacak[2] . '&ayat3=' . $ayatacak[2] . '&surat4=' . $surahacak[3] . '&ayat4=' . $ayatacak[3] . '&pilihan=' . $index);
        } else if ($jumlahsoalmudah == 5) {
            header('location: index.php?note=2&soal1=' . $soal1 . '&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&surat2=' . $surahacak[1] . '&ayat2=' . $ayatacak[1] . '&surat3=' . $surahacak[2] . '&ayat3=' . $ayatacak[2] . '&surat4=' . $surahacak[3] . '&ayat4=' . $ayatacak[3] .  '&surat5=' . $surahacak[4] . '&ayat5=' . $ayatacak[4] . '&pilihan=' . $index);
        } else {
            header('location: index.php?note=2&soal1=' . $soal1 . '&pilihan=' . $index);
        }
    } else {
        header('location: index.php?note=21&pilihan=' . $index);
    }
} else {
    if ($querypaket) {
        if ($jumlahsoalmudah == 1) {
            header('location: index.php?note=2&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&pilihan=' . $index);
        } else if ($jumlahsoalmudah == 2) {
            header('location: index.php?note=2&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&surat2=' . $surahacak[1] . '&ayat2=' . $ayatacak[1] . '&pilihan=' . $index);
        } else if ($jumlahsoalmudah == 3) {
            header('location: index.php?note=2&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&surat2=' . $surahacak[1] . '&ayat2=' . $ayatacak[1] . '&surat3=' . $surahacak[2] . '&ayat3=' . $ayatacak[2] . '&pilihan=' . $index);
        } else if ($jumlahsoalmudah == 4) {
            header('location: index.php?note=2&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&surat2=' . $surahacak[1] . '&ayat2=' . $ayatacak[1] . '&surat3=' . $surahacak[2] . '&ayat3=' . $ayatacak[2] . '&surat4=' . $surahacak[3] . '&ayat4=' . $ayatacak[3] . '&pilihan=' . $index);
        } else if ($jumlahsoalmudah == 5) {
            header('location: index.php?note=2&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&surat2=' . $surahacak[1] . '&ayat2=' . $ayatacak[1] . '&surat3=' . $surahacak[2] . '&ayat3=' . $ayatacak[2] . '&surat4=' . $surahacak[3] . '&ayat4=' . $ayatacak[3] .  '&surat5=' . $surahacak[4] . '&ayat5=' . $ayatacak[4] . '&pilihan=' . $index);
        } else if ($jumlahsoalmudah == 6) {
            header('location: index.php?note=2&surat1=' . $surahacak[0] . '&ayat1=' . $ayatacak[0] . '&surat2=' . $surahacak[1] . '&ayat2=' . $ayatacak[1] . '&surat3=' . $surahacak[2] . '&ayat3=' . $ayatacak[2] . '&surat4=' . $surahacak[3] . '&ayat4=' . $ayatacak[3] .  '&surat5=' . $surahacak[4] . '&ayat5=' . $ayatacak[4] . '&surat6=' . $surahacak[5] . '&ayat6=' . $ayatacak[5] .'&pilihan=' . $index);
        } else {
            header('location: index.php?note=21&pilihan=' . $index);
        }
    } else {
        header('location: index.php?note=21&pilihan=' . $index);
    }
}


