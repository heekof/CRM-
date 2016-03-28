<?PHP
//include("../includes/fonctions.php");
include("../panelgenral/admin2/excel/Classes/PHPExcel.php");
include("../panelgenral/admin2/excel/Classes/PHPExcel/Writer/Excel5.php");
 $datetarifs=date("l");
 
 
 if($datetarifs=="Friday"){
$workbook = new PHPExcel;
 
$sheet = $workbook->getActiveSheet();
 
$col=0;
$lig=2;
 
$mysql_server = '94.23.22.154';
$mysql_user = 'tshivuadi';
$mysql_password = 'tshivuadi2010';
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
 
$writer->save(str_replace('.php', '.xls', __FILE__));
 
header("Location:http://support.kt-centrex.com/panelgenral/admin2/pages/spages/excel.php"); 
}
?>