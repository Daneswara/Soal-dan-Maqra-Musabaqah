<?php

include "../koneksi.php";
require_once './PHPExcel.php';
require_once './PHPExcel/IOFactory.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Create a first sheet, representing sales data
$objPHPExcel->setActiveSheetIndex(0);

$sql = "SELECT soal_fahmil.id, soal_fahmil.id_kategori, kategori_fahmil.nama_kategori, soal_fahmil.soal, soal_fahmil.jawaban "
        . "FROM soal_fahmil left join kategori_fahmil on soal_fahmil.id_kategori = kategori_fahmil.id;";
$setRec = mysqli_query($koneksi, $sql);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "ID");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, "ID Kategori Fahmil");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, "Nama Kategori");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, "Soal");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, "Jawaban");
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
header('Content-Disposition: attachment;filename="'. date("d-m-Y") .' - Bank Soal Fahmil.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
