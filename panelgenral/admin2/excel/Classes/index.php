<?php
include 'MaitrePylosExcel.php';
$workbook = new MaitrePylosExcel();
function cel($cel)
{
$cel=str_replace ("10","K",$cel);
$cel=str_replace ("11","L",$cel);
$cel=str_replace ("12","M",$cel);
$cel=str_replace ("1","B",$cel);
$cel=str_replace ("2","C",$cel);
$cel=str_replace ("3","D",$cel);
$cel=str_replace ("4","E",$cel);
$cel=str_replace ("5","F",$cel);
$cel=str_replace ("6","G",$cel);
$cel=str_replace ("7","H",$cel);
$cel=str_replace ("8","I",$cel);
$cel=str_replace ("9","J",$cel);


//... et ainsi de suite pour tout les jours et mois
return ($cel);
}

$sheet = $workbook->getActiveSheet();
$col=0;
$lig=2;
$an=date("y");
$connect=mysql_connect("mysql51-29.bdb","etikeoprodb","jKDiCfGO");
$db = mysql_select_db("etikeoprodb");
$sheet->getColumnDimension('A')->setWidth(50);
//...style
$styleA1 = $sheet->getStyle('A1');
$styleFont = $styleA1->getFont();
$styleFont->setBold(true);

//...alimentation de cellule
$sheet->setCellValue('A1','CLIENT');
$sheet->setCellValue('B1','jan-'.$an);
$sheet->setCellValue('C1','fev-'.$an);
$sheet->setCellValue('D1','mars-'.$an);
$sheet->setCellValue('E1','avril-'.$an);
$sheet->setCellValue('F1','mai-'.$an);
$sheet->setCellValue('G1','juin-'.$an);
$sheet->setCellValue('H1','juil-'.$an);
$sheet->setCellValue('I1','aout-'.$an);
$sheet->setCellValue('J1','sep-'.$an);
$sheet->setCellValue('K1','oct-'.$an);
$sheet->setCellValue('L1','nov-'.$an);
$sheet->setCellValue('M1','dec-'.$an);
$sheet->setCellValue('N1','Total');

$sql = "SELECT COUNT(NUMCLI) AS NBP FROM clienttab";    //****EDIT HERE**** you need to edit... WHERE `active` = 1 ORDER BY `date` DESC
$result = mysql_query($sql);
$colonne = mysql_fetch_array($result);
$nb = $colonne['NBP'];

$query = " SELECT * FROM clienttab ORDER BY RAISONSOCIALE";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());

while($row = mysql_fetch_array($mysql_result))
                              {
                                      $numcli = ($row["NUMCLI"]);
									  $raison = ($row["RAISONSOCIALE"]);
									  $agence = ($row["AGENCELIV"]);
									  $statutcli = ($row["STATUT"]);
									 if($statutcli =="franchise"){$raisons=$raison." agence ".$agence;}else{$raisons=$raison;}	
$sheet->setCellValueByColumnAndRow($col,$lig,$raisons);

for($i=1;$i<13;$i++)									  
	{
	
$tableauNombreVentes = array();
$yearac=date("Y");
$sql = " SELECT SUM(TOTAL_PAYE) AS NBR_VENTES FROM commandes WHERE YEAR(date_com)='".$yearac."' AND MONTH (date_com)='".$i."' AND NUMCLI='".$numcli."'";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
// Alimentation des tableaux de données
$tableauNombreVentes[$i] = $row['NBR_VENTES'];

}
$euro = utf8_encode('€');
$sheet->setCellValue(cel($i).$lig,(int) $tableauNombreVentes[$i]);

	}
	$c='N'.$lig;
	$d='B'.$lig;
	$f='M'.$lig;
	
$sheet->setCellValue($c,'=SUM('.$d.':'.$f.')');

			

$lig=$lig+1;
}
$sheet->getDefaultStyle()
->applyFromArray(array(
'alignment'=>array(
'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
)
);
//$styleA2 = $sheet-> getStyle('B1:N'.$lig);
//$styleA2-> applyFromArray(array(
//'alignment'=>array(
//'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER), 'B1:N'.$lig));
//Duplication du style
$sheet->getStyle('A2:A'.$lig)
->applyFromArray(array(
'alignment'=>array(
'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
)
);
$styleA = $sheet->getStyle('A'.$lig);
$styleFont = $styleA->getFont();
$styleFont->setBold(true);

$sheet->setCellValue('A'.$lig,'TOTAL CA');
$c='N'.$lig;
$d='B'.$lig;
$f='M'.$lig;
for($j=1;$j<13;$j++)									  
	{								  
$tableauNombreVente = array();
$yearac=date("Y");
$sql = " SELECT SUM(TOTAL_PAYE) AS NBR_VENTES FROM commandes WHERE YEAR(date_com)='".$yearac."' AND MONTH (date_com)='".$j."'";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
// Alimentation des tableaux de données
$tableauNombreVente[$j] = $row['NBR_VENTES'];

}
$c='N'.$lig;
	$fi=$lig-1;

	
//$sheet->setCellValue($c,'=SUM('.$d.':'.$f.')');
//$sheet->setCellValue(cel($i).$lig,number_format($tableauNombreVentes[$i],0,"",""));

$sheet->setCellValue(cel($j).$lig,'=SUM('.cel($j).'2:'.cel($j).$fi.')');

}
	$fi=$lig-1;
	
$sheet->setCellValue($c,'=SUM(N2:N'.$fi.')');	
//$sheet->setCellValue('A3','=SUM(C1:A2)');

$sheet->setTitle('SUIVI  C.A.');
/*********************************************************
*
* Création de la deuxième feuille
*******************************************************/
//création de la nouvelle feuille
$sheet2 = $workbook->createSheet();
$sheet2->setTitle('NOMBRE DE COMMANDE');
/*********************************************************
*
* Création de la troisème feuille
*******************************************************/
//création de la nouvelle feuille
$sheet3 = $workbook->createSheet();
$sheet3->setTitle('NBR DES PRODUITS PAR COMMANDE ');
/*********************************************************
*
* Création de la quatrième feuille
*******************************************************/
$sheet4 = $workbook->createSheet();
$sheet4->setTitle('PANIER MOYEN PAR COMMANDE');
/*********************************************************
*
* Création de la cinquième feuille
*******************************************************/
$sheet5 = $workbook->createSheet();
$sheet5->setTitle('C.A. PAR TYPE DE PRODUIT');
$workbook->affiche('Excel2007','statistique');
?>