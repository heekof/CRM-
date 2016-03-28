<?php
$date=date("l");
$datej=date("Y-m-d");
//if($date=="Friday"){

include("PHPExcel/classes/PHPExcel.php");
include("PHPExcel/classes/PHPExcel/Writer/Excel5.php");
 
$workbook = new PHPExcel;
 
$sheet = $workbook->getActiveSheet();
 
$col=1;
$lig=2;

                         
$query = " SELECT * FROM prix WHERE id=0 ";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
                              {

   
      $sheet->setCellValueByColumnAndRow($col,$lig,$row->pays);
      $col=$col+1;
      $sheet->setCellValueByColumnAndRow($col,$lig,$result->extension);
      $col=$col+1;
      $sheet->setCellValueByColumnAndRow($col,$lig,$result->prix2);
      $col=$col+1;
      $sheet->setCellValueByColumnAndRow($col,$lig,$result->public);
      $col=$col+1;
      $col=1;
      $lig=$lig+1;
}
 
$writer = new PHPExcel_Writer_Excel5($workbook);
 
//mysql_close();
 
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition:inline;filename=test.xls');
$writer->save(str_replace('.php', '.xls', __FILE__));

echo $message="
Bonjour Monsieur<br>
Ci dessous nos promotion sur nos terminaison d appel<br>
<table>
<tr>
<td>Pays</td>
<td>Extension</td>
<td>Prix en HT</td>
</tr>
";
$query = " SELECT * FROM prix WHERE id=0 ";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
                              {
    $pays = ($row["pays"]) ;
    $extension = ($row["extension"]) ;
    $prix = ($row["prix2"]) ;
echo "<tr>
<td>".$pays."</td>
<td>".$extension."</td>
<td>".$prix."</td>
</tr>";
}
$message.="
</table>
Vous pouvez trouver en piece jointe la grille tarifaire pour la semaine de ".$datej." qui sera mise en<br>
routage cette nouvelle semaine.<br></br>
En vous souhaitant bonne réception.
";
$signature = "-- <br> Service commercial  - Ktis   - <a href='http://www.kt-centrex.com'>http://www.kt-centrex.com</a><br>"
						."<br>Location de serveurs dédiés<br>
						Infogérance et consulting<br>
						Opérateur télécom voip<br>
						Serveurs de jeux<br>";



$messageHTML = "<html><head><title></title></head><body>".stripslashes($message);
$objet="envoie liste d'appel";
$messageHTML .= "<br><br>"
			."Si vous ne souhaitez plus recevoir de mail publicitaire, cliquez <a href='".$url."?page=suppcourriel'>ici</a>"
			."<br><br>".$signature."</body>";
$separator = md5(time());
// carriage return type (we use a PHP end of line constant)
$eol = PHP_EOL;
// attachment name
$filename = "tarifsktcentrex.xls";
// encode data (puts attachment in proper format)
$pdfdoc = "tarifs.xls";
$attachment = chunk_split(base64_encode($pdfdoc));
// main header (multipart mandatory)
$headers ='From: "KTcentrex.com" <webkalor@gmail.com>'."\n";
$headers .='Reply-To: webkalor@gmail.com'."\n";
$headers .= "MIME-Version: 1.0".$eol;
$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol;
$headers .= "Content-Transfer-Encoding: 7bit".$eol;
$headers .= "This is a MIME encoded message.".$eol.$eol;

// message

$headers .= "--".$separator.$eol;
$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
$headers .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
$headers .= $messageHTML.$eol.$eol;

// attachment

$headers .= "--".$separator.$eol;
$headers .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
$headers .= "Content-Transfer-Encoding: base64".$eol;
$headers .= "Content-Disposition: attachment".$eol.$eol;
$headers .= $attachment.$eol.$eol;

$headers .= "--".$separator."--";					


$query = " SELECT * FROM identite ;";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
    //$nomgroupe = ($row["numgroup"]) ;
    //$email = ($row["email"]) ;
    $nom = ($row["nom"]) ;
    $prenom = ($row["prenom"]) ;

	//On mets dans la fils de lancement
    //if(mail($email,stripslashes($objet),$messageHTML, $headers))
	{
mail("webkalortest@gmail.com",stripslashes($objet),$messageHTML, $headers);
}}
?>