<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include "../koneksi.php";
//  Include PHPExcel_IOFactory\
include './PHPExcel/IOFactory.php';

$inputFileName = './Excel/Bank Soal'.date("d/m/Y").'.xls';

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
        $data[$row - 2][$col] = $sheet->getCellByColumnAndRow($col, $row, "kosong");
        echo $data[$row - 2][$col] . ' ';
    }
    echo '<br>';

    //  Insert row data array into your database of choice here
}

if ($data[0][0] != null) {
    $queryoperasi = mysqli_query($koneksi, "TRUNCATE kategori");
    $queryoperasi = mysqli_query($koneksi, "TRUNCATE paket");
    $queryoperasi = mysqli_query($koneksi, "TRUNCATE soal");
    $temp = "";
    $temp2 = "";
    for ($row = 0; $row < count($data); $row++) {
        $idpaket = explode("-", $data[$row][5]);// id urutan nama jenis index
        if($temp != $idpaket[0]){
            $querytambah = mysqli_query($koneksi, "INSERT INTO kategori VALUES($idpaket[0], ".$data[$row][2].",'".$data[$row][1]."','".$data[$row][0]."','".$data[$row][3]."');") or die(mysqli_error($koneksi));
            $temp =$idpaket[0];
        }
        if($temp2 != $data[$row][4]){
            $querytambah = mysqli_query($koneksi, "INSERT INTO paket VALUES(".$data[$row][4].", '".$idpaket[0]."', '".$data[$row][3]."', '".$data[$row][5]."');") or die(mysqli_error($koneksi));
            $temp2 =$data[$row][4];
        }
        $querytambah = mysqli_query($koneksi, "INSERT INTO soal VALUES(NULL, ".$data[$row][4].",".$data[$row][6].",".$data[$row][7].",".$data[$row][8].",".$data[$row][9].",".$data[$row][10].");") or die(mysqli_error($koneksi));
    }
    
    
    if ($querytambah) {
        header('location: pengaturan.php?note=6');
    } else {
        header('location: pengaturan.php?note=61');
    }
}