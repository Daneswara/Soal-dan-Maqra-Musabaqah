<?php
include "../koneksi.php";
session_start();
if (empty($_SESSION['admin_login'])) {
    header('location: login.php');
}
$admin = $_SESSION['admin_login'];


if (isset($_GET['uploadExcelFahmil'])) {
    $allowedExts = array("xls");
    $extension1 = pathinfo($_FILES['file1']['name'], PATHINFO_EXTENSION);
    $extension2 = pathinfo($_FILES['file2']['name'], PATHINFO_EXTENSION);
    $extension3 = pathinfo($_FILES['file3']['name'], PATHINFO_EXTENSION);
    $extension4 = pathinfo($_FILES['file4']['name'], PATHINFO_EXTENSION);
    $extension5 = pathinfo($_FILES['file5']['name'], PATHINFO_EXTENSION);
    $extension6 = pathinfo($_FILES['file6']['name'], PATHINFO_EXTENSION);
    $extension7 = pathinfo($_FILES['file7']['name'], PATHINFO_EXTENSION);
    $extension8 = pathinfo($_FILES['file8']['name'], PATHINFO_EXTENSION);
    $extension9 = pathinfo($_FILES['file9']['name'], PATHINFO_EXTENSION);
    $extension10 = pathinfo($_FILES['file10']['name'], PATHINFO_EXTENSION);
    $extension11 = pathinfo($_FILES['file11']['name'], PATHINFO_EXTENSION);
    $extension12 = pathinfo($_FILES['file12']['name'], PATHINFO_EXTENSION);
    $extension13 = pathinfo($_FILES['file13']['name'], PATHINFO_EXTENSION);
    $extension14 = pathinfo($_FILES['file14']['name'], PATHINFO_EXTENSION);
    $extension15 = pathinfo($_FILES['file15']['name'], PATHINFO_EXTENSION);
    $cek = 0;
    include "../koneksi.php";
    include './PHPExcel/IOFactory.php';
    if (($_FILES["file1"]["type"] == "application/vnd.ms-excel") && in_array($extension1, $allowedExts)) {
        if ($_FILES["file1"]["error"] > 0) {
            
        } else {
            move_uploaded_file($_FILES["file1"]["tmp_name"], "ExcelTafsir/" . $_FILES["file1"]["name"]);
            $inputFileName = './ExcelTafsir/' . $_FILES["file1"]["name"];
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $data = [];
            for ($row = 2; $row <= $highestRow; $row++) {
                for ($col = 0; $col <= $colNumber; $col++) {
                    $data[$row - 2][$col] = $sheet->getCellByColumnAndRow($col, $row, true);
                }
            }

            if ($data[0][0] != null) {
//                $queryoperasi = mysqli_query($koneksi, "TRUNCATE kategori_fahmil");
                $queryoperasi = mysqli_query($koneksi, "delete from soal_fahmil where id_kategori = 1");
                $temp = "";
                $temp2 = "";
                for ($row = 0; $row < count($data); $row++) {
                    if ($temp2 != $data[$row][0]) {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO soal_fahmil VALUES(null, " . 1 . ", '" . $data[$row][0] . "', '" . $data[$row][1] . "', 0);") or die(mysqli_error($koneksi));
                        $temp2 = $data[$row][0];
                    }
                }
            }
        }
    } else {
        $cek++;
    }
    if (($_FILES["file2"]["type"] == "application/vnd.ms-excel") && in_array($extension2, $allowedExts)) {
        if ($_FILES["file2"]["error"] > 0) {
            
        } else {
            move_uploaded_file($_FILES["file2"]["tmp_name"], "ExcelTafsir/" . $_FILES["file2"]["name"]);
            $inputFileName = './ExcelTafsir/' . $_FILES["file2"]["name"];
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $data = [];
            for ($row = 2; $row <= $highestRow; $row++) {
                for ($col = 0; $col <= $colNumber; $col++) {
                    $data[$row - 2][$col] = $sheet->getCellByColumnAndRow($col, $row, true);
                }
            }

            if ($data[0][0] != null) {
//                $queryoperasi = mysqli_query($koneksi, "TRUNCATE kategori_fahmil");
                $queryoperasi = mysqli_query($koneksi, "delete from soal_fahmil where id_kategori = 2");
                $temp = "";
                $temp2 = "";
                for ($row = 0; $row < count($data); $row++) {
                    if ($temp2 != $data[$row][0]) {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO soal_fahmil VALUES(null, " . 2 . ", '" . $data[$row][0] . "', '" . $data[$row][1] . "', 0);") or die(mysqli_error($koneksi));
                        $temp2 = $data[$row][0];
                    }
                }
            }
        }
    } else {
        $cek++;
    }
    if (($_FILES["file3"]["type"] == "application/vnd.ms-excel") && in_array($extension3, $allowedExts)) {
        if ($_FILES["file3"]["error"] > 0) {
            
        } else {
            move_uploaded_file($_FILES["file3"]["tmp_name"], "ExcelTafsir/" . $_FILES["file3"]["name"]);
            $inputFileName = './ExcelTafsir/' . $_FILES["file3"]["name"];
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $data = [];
            for ($row = 2; $row <= $highestRow; $row++) {
                for ($col = 0; $col <= $colNumber; $col++) {
                    $data[$row - 2][$col] = $sheet->getCellByColumnAndRow($col, $row, true);
                }
            }

            if ($data[0][0] != null) {
//                $queryoperasi = mysqli_query($koneksi, "TRUNCATE kategori_fahmil");
                $queryoperasi = mysqli_query($koneksi, "delete from soal_fahmil where id_kategori = 3");
                $temp = "";
                $temp2 = "";
                for ($row = 0; $row < count($data); $row++) {
                    if ($temp2 != $data[$row][0]) {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO soal_fahmil VALUES(null, " . 3 . ", '" . $data[$row][0] . "', '" . $data[$row][1] . "', 0);") or die(mysqli_error($koneksi));
                        $temp2 = $data[$row][0];
                    }
                }
            }
        }
    } else {
        $cek++;
    }
    if (($_FILES["file4"]["type"] == "application/vnd.ms-excel") && in_array($extension4, $allowedExts)) {
        if ($_FILES["file4"]["error"] > 0) {
            
        } else {
            move_uploaded_file($_FILES["file4"]["tmp_name"], "ExcelTafsir/" . $_FILES["file4"]["name"]);
            $inputFileName = './ExcelTafsir/' . $_FILES["file4"]["name"];
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $data = [];
            for ($row = 2; $row <= $highestRow; $row++) {
                for ($col = 0; $col <= $colNumber; $col++) {
                    $data[$row - 2][$col] = $sheet->getCellByColumnAndRow($col, $row, true);
                }
            }

            if ($data[0][0] != null) {
//                $queryoperasi = mysqli_query($koneksi, "TRUNCATE kategori_fahmil");
                $queryoperasi = mysqli_query($koneksi, "delete from soal_fahmil where id_kategori = 4");
                $temp = "";
                $temp2 = "";
                for ($row = 0; $row < count($data); $row++) {
                    if ($temp2 != $data[$row][0]) {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO soal_fahmil VALUES(null, " . 4 . ", '" . $data[$row][0] . "', '" . $data[$row][1] . "', 0);") or die(mysqli_error($koneksi));
                        $temp2 = $data[$row][0];
                    }
                }
            }
        }
    } else {
        $cek++;
    }
    if (($_FILES["file5"]["type"] == "application/vnd.ms-excel") && in_array($extension5, $allowedExts)) {
        if ($_FILES["file5"]["error"] > 0) {
            
        } else {
            move_uploaded_file($_FILES["file5"]["tmp_name"], "ExcelTafsir/" . $_FILES["file5"]["name"]);
            $inputFileName = './ExcelTafsir/' . $_FILES["file5"]["name"];
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $data = [];
            for ($row = 2; $row <= $highestRow; $row++) {
                for ($col = 0; $col <= $colNumber; $col++) {
                    $data[$row - 2][$col] = $sheet->getCellByColumnAndRow($col, $row, true);
                }
            }

            if ($data[0][0] != null) {
//                $queryoperasi = mysqli_query($koneksi, "TRUNCATE kategori_fahmil");
                $queryoperasi = mysqli_query($koneksi, "delete from soal_fahmil where id_kategori = 5");
                $temp = "";
                $temp2 = "";
                for ($row = 0; $row < count($data); $row++) {
                    if ($temp2 != $data[$row][0]) {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO soal_fahmil VALUES(null, " . 5 . ", '" . $data[$row][0] . "', '" . $data[$row][1] . "', 0);") or die(mysqli_error($koneksi));
                        $temp2 = $data[$row][0];
                    }
                }
            }
        }
    } else {
        $cek++;
    }
    if (($_FILES["file6"]["type"] == "application/vnd.ms-excel") && in_array($extension6, $allowedExts)) {
        if ($_FILES["file6"]["error"] > 0) {
            
        } else {
            move_uploaded_file($_FILES["file6"]["tmp_name"], "ExcelTafsir/" . $_FILES["file6"]["name"]);
            $inputFileName = './ExcelTafsir/' . $_FILES["file6"]["name"];
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $data = [];
            for ($row = 2; $row <= $highestRow; $row++) {
                for ($col = 0; $col <= $colNumber; $col++) {
                    $data[$row - 2][$col] = $sheet->getCellByColumnAndRow($col, $row, true);
                }
            }

            if ($data[0][0] != null) {
//                $queryoperasi = mysqli_query($koneksi, "TRUNCATE kategori_fahmil");
                $queryoperasi = mysqli_query($koneksi, "delete from soal_fahmil where id_kategori = 6");
                $temp = "";
                $temp2 = "";
                for ($row = 0; $row < count($data); $row++) {
                    if ($temp2 != $data[$row][0]) {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO soal_fahmil VALUES(null, " . 6 . ", '" . $data[$row][0] . "', '" . $data[$row][1] . "', 0);") or die(mysqli_error($koneksi));
                        $temp2 = $data[$row][0];
                    }
                }
            }
        }
    } else {
        $cek++;
    }
    if (($_FILES["file7"]["type"] == "application/vnd.ms-excel") && in_array($extension7, $allowedExts)) {
        if ($_FILES["file7"]["error"] > 0) {
            
        } else {
            move_uploaded_file($_FILES["file7"]["tmp_name"], "ExcelTafsir/" . $_FILES["file7"]["name"]);
            $inputFileName = './ExcelTafsir/' . $_FILES["file7"]["name"];
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $data = [];
            for ($row = 2; $row <= $highestRow; $row++) {
                for ($col = 0; $col <= $colNumber; $col++) {
                    $data[$row - 2][$col] = $sheet->getCellByColumnAndRow($col, $row, true);
                }
            }

            if ($data[0][0] != null) {
//                $queryoperasi = mysqli_query($koneksi, "TRUNCATE kategori_fahmil");
                $queryoperasi = mysqli_query($koneksi, "delete from soal_fahmil where id_kategori = 7");
                $temp = "";
                $temp2 = "";
                for ($row = 0; $row < count($data); $row++) {
                    if ($temp2 != $data[$row][0]) {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO soal_fahmil VALUES(null, " . 7 . ", '" . $data[$row][0] . "', '" . $data[$row][1] . "', 0);") or die(mysqli_error($koneksi));
                        $temp2 = $data[$row][0];
                    }
                }
            }
        }
    } else {
        $cek++;
    }
    if (($_FILES["file8"]["type"] == "application/vnd.ms-excel") && in_array($extension8, $allowedExts)) {
        if ($_FILES["file8"]["error"] > 0) {
            
        } else {
            move_uploaded_file($_FILES["file8"]["tmp_name"], "ExcelTafsir/" . $_FILES["file8"]["name"]);
            $inputFileName = './ExcelTafsir/' . $_FILES["file8"]["name"];
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $data = [];
            for ($row = 2; $row <= $highestRow; $row++) {
                for ($col = 0; $col <= $colNumber; $col++) {
                    $data[$row - 2][$col] = $sheet->getCellByColumnAndRow($col, $row, true);
                }
            }

            if ($data[0][0] != null) {
//                $queryoperasi = mysqli_query($koneksi, "TRUNCATE kategori_fahmil");
                $queryoperasi = mysqli_query($koneksi, "delete from soal_fahmil where id_kategori = 8");
                $temp = "";
                $temp2 = "";
                for ($row = 0; $row < count($data); $row++) {
                    if ($temp2 != $data[$row][0]) {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO soal_fahmil VALUES(null, " . 8 . ", '" . $data[$row][0] . "', '" . $data[$row][1] . "', 0);") or die(mysqli_error($koneksi));
                        $temp2 = $data[$row][0];
                    }
                }
            }
        }
    } else {
        $cek++;
    }
    if (($_FILES["file9"]["type"] == "application/vnd.ms-excel") && in_array($extension9, $allowedExts)) {
        if ($_FILES["file9"]["error"] > 0) {
            
        } else {
            move_uploaded_file($_FILES["file9"]["tmp_name"], "ExcelTafsir/" . $_FILES["file9"]["name"]);
            $inputFileName = './ExcelTafsir/' . $_FILES["file9"]["name"];
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $data = [];
            for ($row = 2; $row <= $highestRow; $row++) {
                for ($col = 0; $col <= $colNumber; $col++) {
                    $data[$row - 2][$col] = $sheet->getCellByColumnAndRow($col, $row, true);
                }
            }

            if ($data[0][0] != null) {
//                $queryoperasi = mysqli_query($koneksi, "TRUNCATE kategori_fahmil");
                $queryoperasi = mysqli_query($koneksi, "delete from soal_fahmil where id_kategori = 9");
                $temp = "";
                $temp2 = "";
                for ($row = 0; $row < count($data); $row++) {
                    if ($temp2 != $data[$row][0]) {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO soal_fahmil VALUES(null, " . 9 . ", '" . $data[$row][0] . "', '" . $data[$row][1] . "', 0);") or die(mysqli_error($koneksi));
                        $temp2 = $data[$row][0];
                    }
                }
            }
        }
    } else {
        $cek++;
    }
    if (($_FILES["file10"]["type"] == "application/vnd.ms-excel") && in_array($extension10, $allowedExts)) {
        if ($_FILES["file10"]["error"] > 0) {
            
        } else {
            move_uploaded_file($_FILES["file10"]["tmp_name"], "ExcelTafsir/" . $_FILES["file10"]["name"]);
            $inputFileName = './ExcelTafsir/' . $_FILES["file10"]["name"];
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $data = [];
            for ($row = 2; $row <= $highestRow; $row++) {
                for ($col = 0; $col <= $colNumber; $col++) {
                    $data[$row - 2][$col] = $sheet->getCellByColumnAndRow($col, $row, true);
                }
            }

            if ($data[0][0] != null) {
//                $queryoperasi = mysqli_query($koneksi, "TRUNCATE kategori_fahmil");
                $queryoperasi = mysqli_query($koneksi, "delete from soal_fahmil where id_kategori = 10");
                $temp = "";
                $temp2 = "";
                for ($row = 0; $row < count($data); $row++) {
                    if ($temp2 != $data[$row][0]) {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO soal_fahmil VALUES(null, " . 10 . ", '" . $data[$row][0] . "', '" . $data[$row][1] . "', 0);") or die(mysqli_error($koneksi));
                        $temp2 = $data[$row][0];
                    }
                }
            }
        }
    } else {
        $cek++;
    }
    if (($_FILES["file11"]["type"] == "application/vnd.ms-excel") && in_array($extension11, $allowedExts)) {
        if ($_FILES["file11"]["error"] > 0) {
            
        } else {
            move_uploaded_file($_FILES["file11"]["tmp_name"], "ExcelTafsir/" . $_FILES["file11"]["name"]);
            $inputFileName = './ExcelTafsir/' . $_FILES["file11"]["name"];
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $data = [];
            for ($row = 2; $row <= $highestRow; $row++) {
                for ($col = 0; $col <= $colNumber; $col++) {
                    $data[$row - 2][$col] = $sheet->getCellByColumnAndRow($col, $row, true);
                }
            }

            if ($data[0][0] != null) {
//                $queryoperasi = mysqli_query($koneksi, "TRUNCATE kategori_fahmil");
                $queryoperasi = mysqli_query($koneksi, "delete from soal_fahmil where id_kategori = 11");
                $temp = "";
                $temp2 = "";
                for ($row = 0; $row < count($data); $row++) {
                    if ($temp2 != $data[$row][0]) {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO soal_fahmil VALUES(null, " . 11 . ", '" . $data[$row][0] . "', '" . $data[$row][1] . "', 0);") or die(mysqli_error($koneksi));
                        $temp2 = $data[$row][0];
                    }
                }
            }
        }
    } else {
        $cek++;
    }
    if (($_FILES["file12"]["type"] == "application/vnd.ms-excel") && in_array($extension12, $allowedExts)) {
        if ($_FILES["file12"]["error"] > 0) {
            
        } else {
            move_uploaded_file($_FILES["file12"]["tmp_name"], "ExcelTafsir/" . $_FILES["file12"]["name"]);
            $inputFileName = './ExcelTafsir/' . $_FILES["file12"]["name"];
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $data = [];
            for ($row = 2; $row <= $highestRow; $row++) {
                for ($col = 0; $col <= $colNumber; $col++) {
                    $data[$row - 2][$col] = $sheet->getCellByColumnAndRow($col, $row, true);
                }
            }

            if ($data[0][0] != null) {
//                $queryoperasi = mysqli_query($koneksi, "TRUNCATE kategori_fahmil");
                $queryoperasi = mysqli_query($koneksi, "delete from soal_fahmil where id_kategori = 12");
                $temp = "";
                $temp2 = "";
                for ($row = 0; $row < count($data); $row++) {
                    if ($temp2 != $data[$row][0]) {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO soal_fahmil VALUES(null, " . 12 . ", '" . $data[$row][0] . "', '" . $data[$row][1] . "', 0);") or die(mysqli_error($koneksi));
                        $temp2 = $data[$row][0];
                    }
                }
            }
        }
    } else {
        $cek++;
    }
    if (($_FILES["file13"]["type"] == "application/vnd.ms-excel") && in_array($extension13, $allowedExts)) {
        if ($_FILES["file13"]["error"] > 0) {
            
        } else {
            move_uploaded_file($_FILES["file13"]["tmp_name"], "ExcelTafsir/" . $_FILES["file13"]["name"]);
            $inputFileName = './ExcelTafsir/' . $_FILES["file13"]["name"];
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $data = [];
            for ($row = 2; $row <= $highestRow; $row++) {
                for ($col = 0; $col <= $colNumber; $col++) {
                    $data[$row - 2][$col] = $sheet->getCellByColumnAndRow($col, $row, true);
                }
            }

            if ($data[0][0] != null) {
//                $queryoperasi = mysqli_query($koneksi, "TRUNCATE kategori_fahmil");
                $queryoperasi = mysqli_query($koneksi, "delete from soal_fahmil where id_kategori = 13");
                $temp = "";
                $temp2 = "";
                for ($row = 0; $row < count($data); $row++) {
                    if ($temp2 != $data[$row][0]) {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO soal_fahmil VALUES(null, " . 13 . ", '" . $data[$row][0] . "', '" . $data[$row][1] . "', 0);") or die(mysqli_error($koneksi));
                        $temp2 = $data[$row][0];
                    }
                }
            }
        }
    } else {
        $cek++;
    }
    if (($_FILES["file14"]["type"] == "application/vnd.ms-excel") && in_array($extension14, $allowedExts)) {
        if ($_FILES["file14"]["error"] > 0) {
            
        } else {
            move_uploaded_file($_FILES["file14"]["tmp_name"], "ExcelTafsir/" . $_FILES["file14"]["name"]);
            $inputFileName = './ExcelTafsir/' . $_FILES["file14"]["name"];
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $data = [];
            for ($row = 2; $row <= $highestRow; $row++) {
                for ($col = 0; $col <= $colNumber; $col++) {
                    $data[$row - 2][$col] = $sheet->getCellByColumnAndRow($col, $row, true);
                }
            }

            if ($data[0][0] != null) {
//                $queryoperasi = mysqli_query($koneksi, "TRUNCATE kategori_fahmil");
                $queryoperasi = mysqli_query($koneksi, "delete from soal_fahmil where id_kategori = 14");
                $temp = "";
                $temp2 = "";
                for ($row = 0; $row < count($data); $row++) {
                    if ($temp2 != $data[$row][0]) {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO soal_fahmil VALUES(null, " . 14 . ", '" . $data[$row][0] . "', '" . $data[$row][1] . "', 0);") or die(mysqli_error($koneksi));
                        $temp2 = $data[$row][0];
                    }
                }
            }
        }
    } else {
        $cek++;
    }
    if (($_FILES["file15"]["type"] == "application/vnd.ms-excel") && in_array($extension15, $allowedExts)) {
        if ($_FILES["file15"]["error"] > 0) {
            
        } else {
            move_uploaded_file($_FILES["file15"]["tmp_name"], "ExcelTafsir/" . $_FILES["file15"]["name"]);
            $inputFileName = './ExcelTafsir/' . $_FILES["file15"]["name"];
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $data = [];
            for ($row = 2; $row <= $highestRow; $row++) {
                for ($col = 0; $col <= $colNumber; $col++) {
                    $data[$row - 2][$col] = $sheet->getCellByColumnAndRow($col, $row, true);
                }
            }

            if ($data[0][0] != null) {
//                $queryoperasi = mysqli_query($koneksi, "TRUNCATE kategori_fahmil");
                $queryoperasi = mysqli_query($koneksi, "delete from soal_fahmil where id_kategori = 15");
                $temp = "";
                $temp2 = "";
                for ($row = 0; $row < count($data); $row++) {
                    if ($temp2 != $data[$row][0]) {
                        $querytambah = mysqli_query($koneksi, "INSERT INTO soal_fahmil VALUES(null, " . 15 . ", '" . $data[$row][0] . "', '" . $data[$row][1] . "', 0);") or die(mysqli_error($koneksi));
                        $temp2 = $data[$row][0];
                    }
                }
            }
        }
    } else {
        $cek++;
    }
    if ($cek == 15) {
        header('location: fahmil.php?note=63');
    } else {
        if ($querytambah) {
            header('location: fahmil.php?note=8');
        } else {
            header('location: fahmil.php?note=81');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>SOAL DAN MAQRA' MUSABAQAH</title>
        <meta name="description" content="Flat UI Kit Free is a Twitter Bootstrap Framework design and Theme, this responsive framework includes a PSD and HTML version."/>

        <meta name="viewport" content="width=1000, initial-scale=1.0, maximum-scale=1.0">

        <!-- Loading Bootstrap -->
        <link href="../dist/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Loading Flat UI -->
        <link href="../dist/css/flat-ui.css" rel="stylesheet">
        <link href="../docs/assets/css/demo.css" rel="stylesheet">

        <script src="../js/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../js/sweetalert.css">
        <script src="js/jquery.min.js"></script>

        <link rel="shortcut icon" href="../img/favicon.ico">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
        <!--[if lt IE 9]>
          <script src="dist/js/vendor/html5shiv.js"></script>
          <script src="dist/js/vendor/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php
        if (isset($_GET['note'])) {
            $notifikasi = $_GET['note'];
            if ($notifikasi == 1) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Pengaturan perlombaan telah diubah', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 12) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Pengaturan perlombaan tidak dapat diubah, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 2) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Pengaturan website telah diubah', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 21) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Gagal mengupload gambar, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 22) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Ukuran gambar terlalu besar, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 23) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Format file yang diperbolehkan hanya .jpg dan .png, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 3) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Data Bank Soal telah direset', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 31) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Data Bank Soal gagal direset, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 4) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Data Perlombaan telah direset', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 41) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Data Perlombaan tidak dapat direset, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 5) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Akun telah diedit', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 51) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Akun tidak dapat diedit, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 6) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Import Bank Soal baru berhasil disimpan', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 61) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Import Bank Soal gagal disimpan, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 62) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Excel dengan nama sama sudah ada, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 63) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Upload file dengan tipe xls, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 7) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Video berhasil terupload', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 71) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Video dengan nama sama sudah ada, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 72) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Upload file dengan ekstensi mp4. silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 8) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Import Soal MFQ berhasil disimpan', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 81) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Import Soal MFQ gagal disimpan, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 9) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Import Soal Tafsir berhasil disimpan', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 91) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Import Soal Tafsir gagal disimpan, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            }
        }
        ?>
        <style>
            body {
                padding-bottom: 20px;
                padding-top: 20px;
            }
            .navbar {
                margin-bottom: 20px;
            }
            video{
                height: auto;
            }
        </style>
        <div class="container">
            <nav class="navbar navbar-inverse navbar-lg navbar-embossed" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-8">
                        <span class="sr-only">Toggle navigation</span>
                    </button>
                    <a class="navbar-brand" style="padding-top: 10px; line-height: 1.15; text-align: center" href="#"><font size=4> SOAL DAN MAQRA'</font><br> MUSABAQAH</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse-8">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Bank Soal</a></li>
                        <li class="active"><a href="fahmil.php">Bank Soal MFQ</a></li>
                        <li><a href="juri.php">Daftar Juri</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pengaturan <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="about.php">Tentang</a></li>
                                <li ><a href="pengaturan.php">Pengaturan</a></li>
                                <li><a href="login.php">Keluar</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>

            <div class="row demo-samples">
                <div class="form-group">

                    <div class="col-xs-12">
                        <form action="fahmil.php?uploadExcelFahmil=1" method="POST" enctype="multipart/form-data">
                            <h5 style="text-align: center">Export & Import Soal Fahmil </h5>
                            <table width="100%">
                                <tr>
                                    <td width="20%">
                                        <h6>Kategori 1</h6>
                                    </td>
                                    <td width="60%">
                                        <input id="file1" name="file1" type="file" class="form-control">
                                    </td>
                                    <td width="20%">
                                        <a href="exportSoalFahmil.php?kategori=1" style="margin-left: 20px" target="_blank" class="btn btn-lg btn-inverse">Export Kategori 1</a>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%">
                                <tr>
                                    <td width="20%">
                                        <h6>Kategori 2</h6>
                                    </td>
                                    <td width="60%">
                                        <input id="file2" name="file2" type="file" class="form-control">
                                    </td>
                                    <td width="20%">
                                        <a href="exportSoalFahmil.php?kategori=2" style="margin-left: 20px" target="_blank" class="btn btn-lg btn-inverse">Export Kategori 2</a>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%">
                                <tr>
                                    <td width="20%">
                                        <h6>Kategori 3</h6>
                                    </td>
                                    <td width="60%">
                                        <input id="file3" name="file3" type="file" class="form-control">
                                    </td>
                                    <td width="20%">
                                        <a href="exportSoalFahmil.php?kategori=3" style="margin-left: 20px" target="_blank" class="btn btn-lg btn-inverse">Export Kategori 3</a>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%">
                                <tr>
                                    <td width="20%">
                                        <h6>Kategori 4</h6>
                                    </td>
                                    <td width="60%">
                                        <input id="file4" name="file4" type="file" class="form-control">
                                    </td>
                                    <td width="20%">
                                        <a href="exportSoalFahmil.php?kategori=4" style="margin-left: 20px" target="_blank" class="btn btn-lg btn-inverse">Export Kategori 4</a>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%">
                                <tr>
                                    <td width="20%">
                                        <h6>Kategori 5</h6>
                                    </td>
                                    <td width="60%">
                                        <input id="file5" name="file5" type="file" class="form-control">
                                    </td>
                                    <td width="20%">
                                        <a href="exportSoalFahmil.php?kategori=5" style="margin-left: 20px" target="_blank" class="btn btn-lg btn-inverse">Export Kategori 5</a>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%">
                                <tr>
                                    <td width="20%">
                                        <h6>Kategori 6</h6>
                                    </td>
                                    <td width="60%">
                                        <input id="file6" name="file6" type="file" class="form-control">
                                    </td>
                                    <td width="20%">
                                        <a href="exportSoalFahmil.php?kategori=6" style="margin-left: 20px" target="_blank" class="btn btn-lg btn-inverse">Export Kategori 6</a>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%">
                                <tr>
                                    <td width="20%">
                                        <h6>Kategori 7</h6>
                                    </td>
                                    <td width="60%">
                                        <input id="file7" name="file7" type="file" class="form-control">
                                    </td>
                                    <td width="20%">
                                        <a href="exportSoalFahmil.php?kategori=7" style="margin-left: 20px" target="_blank" class="btn btn-lg btn-inverse">Export Kategori 7</a>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%">
                                <tr>
                                    <td width="20%">
                                        <h6>Kategori 8</h6>
                                    </td>
                                    <td width="60%">
                                        <input id="file8" name="file8" type="file" class="form-control">
                                    </td>
                                    <td width="20%">
                                        <a href="exportSoalFahmil.php?kategori=8" style="margin-left: 20px" target="_blank" class="btn btn-lg btn-inverse">Export Kategori 8</a>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%">
                                <tr>
                                    <td width="20%">
                                        <h6>Kategori 9</h6>
                                    </td>
                                    <td width="60%">
                                        <input id="file9" name="file9" type="file" class="form-control">
                                    </td>
                                    <td width="20%">
                                        <a href="exportSoalFahmil.php?kategori=9" style="margin-left: 20px" target="_blank" class="btn btn-lg btn-inverse">Export Kategori 9</a>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%">
                                <tr>
                                    <td width="20%">
                                        <h6>Kategori 10</h6>
                                    </td>
                                    <td width="60%">
                                        <input id="file10" name="file10" type="file" class="form-control">
                                    </td>
                                    <td width="20%">
                                        <a href="exportSoalFahmil.php?kategori=10" style="margin-left: 10px" target="_blank" class="btn btn-lg btn-inverse">Export Kategori 10</a>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%">
                                <tr>
                                    <td width="20%">
                                        <h6>Kategori 11</h6>
                                    </td>
                                    <td width="60%">
                                        <input id="file11" name="file11" type="file" class="form-control">
                                    </td>
                                    <td width="20%">
                                        <a href="exportSoalFahmil.php?kategori=11" style="margin-left: 10px" target="_blank" class="btn btn-lg btn-inverse">Export Kategori 11</a>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%">
                                <tr>
                                    <td width="20%">
                                        <h6>Kategori 12</h6>
                                    </td>
                                    <td width="60%">
                                        <input id="file12" name="file12" type="file" class="form-control">
                                    </td>
                                    <td width="20%">
                                        <a href="exportSoalFahmil.php?kategori=12" style="margin-left: 10px" target="_blank" class="btn btn-lg btn-inverse">Export Kategori 12</a>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%">
                                <tr>
                                    <td width="20%">
                                        <h6>Kategori 13</h6>
                                    </td>
                                    <td width="60%">
                                        <input id="file13" name="file13" type="file" class="form-control">
                                    </td>
                                    <td width="20%">
                                        <a href="exportSoalFahmil.php?kategori=13" style="margin-left: 10px" target="_blank" class="btn btn-lg btn-inverse">Export Kategori 13</a>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%">
                                <tr>
                                    <td width="20%">
                                        <h6>Kategori 14</h6>
                                    </td>
                                    <td width="60%">
                                        <input id="file14" name="file14" type="file" class="form-control">
                                    </td>
                                    <td width="20%">
                                        <a href="exportSoalFahmil.php?kategori=14" style="margin-left: 10px" target="_blank" class="btn btn-lg btn-inverse">Export Kategori 14</a>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%">
                                <tr>
                                    <td width="20%">
                                        <h6>Kategori 15</h6>
                                    </td>
                                    <td width="60%">
                                        <input id="file15" name="file15" type="file" class="form-control">
                                    </td>
                                    <td width="20%">
                                        <a href="exportSoalFahmil.php?kategori=15" style="margin-left: 10px" target="_blank" class="btn btn-lg btn-inverse">Export Kategori 15</a>
                                    </td>
                                </tr>
                            </table>


                            <button type="submit" style="margin-top: 10px" class="btn btn-block btn-lg btn-primary">Upload Soal MFQ (xls)</button>
                        </form>
                    </div> 

                </div>
            </div>
        </div>
        <script src="../dist/js/vendor/jquery.min.js"></script>
        <script src="../dist/js/vendor/video.js"></script>
        <script src="../dist/js/flat-ui.min.js"></script>
        <script src="../docs/assets/js/application.js"></script>

        <script>
            videojs.options.flash.swf = "../dist/js/vendors/video-js.swf"
        </script>
    </body>
</html>
