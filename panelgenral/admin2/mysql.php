<?PHP
//include("../includes/fonctions.php");
include("excel/Classes/PHPExcel.php");
include("excel/Classes/PHPExcel/Writer/Excel5.php");
 
$workbook = new PHPExcel;
 
$sheet = $workbook->getActiveSheet();
 
$col=0;
$lig=2;
 
$mysql_server = '192.168.137.25';
$mysql_user = 'root';
$mysql_password = 'kalonji';
$mysql_db = 'testcentrex';

$mysql_link = mysql_connect($mysql_server, $mysql_user, $mysql_password);
mysql_select_db($mysql_db, $mysql_link);
 
$sql="SELECT * FROM prix WHERE id=0 ";
$requete=mysql_query($sql) or die ("Erreur : ".mysql_error());
 
$sheet->setCellValue('A1','PAYS');
$sheet->setCellValue('B1','EXTENSION');
$sheet->setCellValue('C1','PRIX en HT'); 
 
 
 
 
while( $result = mysql_fetch_object( $requete ) )
{
 
      $sheet->setCellValueExplicitByColumnAndRow($col,$lig,$result->pays,PHPExcel_Cell_DataType::TYPE_STRING);
      $col=$col+1;
      $sheet->setCellValueExplicitByColumnAndRow($col,$lig,$result->extension,PHPExcel_Cell_DataType::TYPE_STRING);
      $col=$col+1;
      $sheet->setCellValueExplicitByColumnAndRow($col,$lig,$result->prix2,PHPExcel_Cell_DataType::TYPE_STRING);
      $col=$col+1;
      $sheet->setCellValueExplicitByColumnAndRow($col,$lig,$result->public,PHPExcel_Cell_DataType::TYPE_STRING);
      $col=$col+1;
      $col=1;
      $lig=$lig+1;
}
 
$writer = new PHPExcel_Writer_Excel5($workbook);
 
mysql_close();
 
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition:inline;filename=test.xls');
$writer->save('php://output');
 
 
?>