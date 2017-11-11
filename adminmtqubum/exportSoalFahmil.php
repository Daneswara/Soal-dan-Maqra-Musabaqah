<?php

include "../koneksi.php";
require_once './PHPExcel.php';
require_once './PHPExcel/IOFactory.php';

$kategori = $_GET['kategori'];

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Create a first sheet, representing sales data
$objPHPExcel->setActiveSheetIndex(0);

$sql = "SELECT soal_fahmil.soal, soal_fahmil.jawaban "
        . "FROM soal_fahmil left join kategori_fahmil on soal_fahmil.id_kategori = kategori_fahmil.id where soal_fahmil.id_kategori = $kategori;";
$setRec = mysqli_query($koneksi, $sql);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Soal");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, "Jawaban");
$baris = 2;
while ($rec = mysqli_fetch_row($setRec)) {
    $kolom = 0;
    foreach ($rec as $value) {
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolom, $baris, $value);
        $kolom++;
    }
    $baris++;
}


// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Bank Soal Fahmil');

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'. date("d-m-Y") .' - Bank Soal Fahmil Kategori '.$kategori.'.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
