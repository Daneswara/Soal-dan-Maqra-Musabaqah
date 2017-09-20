<?php

include "../koneksi.php";
require_once './PHPExcel.php';
require_once './PHPExcel/IOFactory.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Create a first sheet, representing sales data
$objPHPExcel->setActiveSheetIndex(0);

$sql = "SELECT kategori.nama, kategori.urutan, kategori.index, paket.id, paket.namapaket, soal.soal, soal.surat, soal.ayat FROM kategori left join paket on kategori.index = paket.indexkategori left join soal on paket.id = soal.kategori";
$setRec = mysqli_query($koneksi, $sql);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Kategori");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, "Urutan Kategori");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, "Index Kategori");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, "ID Paket");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, "Nama Paket");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, "Urutan Soal");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, "Surat");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, "Ayat");
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
$objPHPExcel->getActiveSheet()->setTitle('Bank Soal');

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Bank Soal.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
