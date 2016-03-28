<?php
include 'MaitrePylosExcel.php';
$workbook = new MaitrePylosExcel();
$sheet = $workbook->getActiveSheet();
$sheet->setCellValue('A1',4);
$sheet->setCellValue('A2',5);
$sheet->setCellValue('A3','=SUM(A1:A2)');
$workbook->affiche('Excel2007','MaPremiereFormule');
?>