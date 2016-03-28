<?php
// AJOUTER LES JOURS
function datePlus($dateDo,$nbrJours)
{
$timeStamp = strtotime($dateDo); 
$timeStamp += 24 * 60 * 60 * $nbrJours;
$newDate = date("Y-m-d", $timeStamp);
return  $newDate;
}
// MISE A JOURS PUBLICITE
if (isset($_POST['update']))
{
$libelle1 = $_POST['editor1'];
$libelle2 = $_POST['editor2'];
$objet = $_POST['ob'];
$etatpub = $_POST['etat'];
$idsemaine = $_POST['id_semaine'];
$signaturepub = $_POST['idsignature'];
$format = $_POST['format'];

if($libelle1!=""){$libelle=$libelle1;}
if($libelle2!=""){$libelle=$libelle2;}
if($etatpub==1){$numsem="";} else{$numsem=$idsemaine;}





$nums = "UPDATE pub SET contenu='".$libelle."',objet='".$objet."',etat='".$etatpub."',signature='".$signaturepub."',format='".$format."',semaine='".$numsem."'
WHERE  numpub='".$_POST['numpub']."'";
mysql_query($nums);
$numpub=$_POST['numpub'];
//SIGNATURE

if(!isset($_POST['idsignature']) && !$_POST['idsignature']){
$signature = "-- <br> Service commercial  - Ktis   - <a href='http://www.kt-centrex.com'>http://www.kt-centrex.com</a><br>"
						."<br>Location de serveurs dédiés<br>
						Infogérance et consulting<br>
						Opérateur télécom voip<br>
						Serveurs de jeux<br>";

}
else{
$query = "select * from mailparametre WHERE numero='".$signaturepub."'";
$result = mysql_query($query) or die ("Erreur : ".mysql_error());
$row = mysql_fetch_array($result);
$signature = $row['signature'];
}
//ENTETE		
 $headers ='From: "KTcentrex.com" <support@ktcentrex.com>'."\n";
 $headers .='Reply-To: support@ktcentrex.com '."\n";
 if($format=="html"){
 $headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
 }else{
 $headers .="Content-Type: text/plain\n";
 }
 $headers .='Content-Transfer-Encoding: 8bit';
 
 
 //MESSAGE
 
  if($format=="html"){
  $libelle=$libelle1;
$messageHTML = "<html><head><title></title></head><body>".stripslashes($libelle);
$messageHTML .= "<br><br>"
			."Si vous ne souhaitez plus recevoir de mail publicitaire, cliquez <a href='".$url."?page=suppcourriel'>ici</a>"
			."<br><br>".$signature."</body>";
}								     
else{
 $libelle=$libelle2;
$messageHTML = stripslashes($libelle);
$messageHTML .= "\n\n"
			."Si vous ne souhaitez plus recevoir de mail publicitaire, cliquez sur ce lien ".$url."?page=suppcourriel" 
			."\n\n".$signature;
}




//ETAT TEST 
if($etatpub == '1')
{
		
$day=date("Y-m-d");
	//Fin enregistrement
	mail($email,stripslashes($objet),$messageHTML, $headers);
echo "<br><center><font color='green' size='4'>Mail de test envoi&eacute; avec succ&egrave;!!!</font></center>";	
}



}		
if (isset($_POST['add']))
{
$libelle1 = $_POST['editor1'];
$libelle2 = $_POST['editor2'];
$objet = $_POST['ob'];
$etatpub = $_POST['etat'];
$idsemaine = $_POST['id_semaine'];
$signaturepub = $_POST['idsignature'];
$format = $_POST['format'];

if($libelle1!=""){$libelle=$libelle1;}
if($libelle2!=""){$libelle=$libelle2;}
if($etatpub==1){$numsem="";} else{$numsem=$idsemaine;}

$sql = 'INSERT INTO  pub(numpub,objet,contenu,signature,etat,format,semaine) VALUES ("'.$numpromo.'","'.$objet.'","'.$libelle.'","'.$signaturepub.'","'.$etatpub.'","'.$format.'","'.$numsem.'")';
mysql_query($sql);
$numpub=mysql_insert_id();

//ETAT TEST

//ETAT SIGNATURE
if(!isset($_POST['idsignature']) && !$_POST['idsignature']){
$signature = "-- <br> Service commercial  - Ktis   - <a href='http://www.kt-centrex.com'>http://www.kt-centrex.com</a><br>"
						."<br>Location de serveurs dédiés<br>
						Infogérance et consulting<br>
						Opérateur télécom voip<br>
						Serveurs de jeux<br>";

}
else{
$query = "select * from mailparametre WHERE numero='".$signaturepub."'";
$result = mysql_query($query) or die ("Erreur : ".mysql_error());
$row = mysql_fetch_array($result);
$signature = $row['signature'];
}

//ENTETES
		
 $headers ='From: "KTcentrex.com" <support@ktcentrex.com>'."\n";
 $headers .='Reply-To: support@ktcentrex.com '."\n";
if($format=="html"){
 $headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
 }else{
 $headers .="Content-Type: text/plain\n";
 }
 $headers .='Content-Transfer-Encoding: 8bit';

//MESSAGE
 if($format=="html"){
  $libelle=$libelle1;
$messageHTML = "<html><head><title></title></head><body>".stripslashes($libelle);
$messageHTML .= "<br><br>"
			."Si vous ne souhaitez plus recevoir de mail publicitaire, cliquez <a href='".$url."?page=suppcourriel'>ici</a>"
			."<br><br>".$signature."</body>";
}								     
else{
 $libelle=$libelle2;
$messageHTML = stripslashes($libelle);
$messageHTML .= "\n\n"
			."Si vous ne souhaitez plus recevoir de mail publicitaire, cliquez sur ce lien ".$url."?page=suppcourriel" 
			."\n\n".$signature;
} 
//ETAT TEST 
if($etatpub == '1')
{


$day=date("Y-m-d");
	//Fin enregistrement
	mail($email,stripslashes($objet),$messageHTML, $headers);
echo "<br><center><font color='green' size='4'>Mail de test envoi&eacute; avec succ&egrave;!!!</font></center>";	
}

}		
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" title="Design" href="../design.css" type="text/css" media="screen" />
<!-- TinyMCE -->
<script type="text/javascript" src="editeur/ckeditor.js"></script>
<script src="sample.js" type="text/javascript"></script>
<link href="sample.css" rel="stylesheet" type="text/css" />
<script language="javascript">

  function ConfirmMessage(id) {

    if (confirm("Etes-vous sur de vouloir supprimer cette publicite?")) { // Clic sur OK
      document.location.href="pages/spages/deletepub.php?numpub="+id;
    }
}
</script>
</head>
<body>
<table  width="100%" bgcolor="#808080" border="3" align="center" >
<td>
<br>
<b>
<center> ADMIN GENERALE PUBLICITE</center>
</b>
<br><br><br>
</td>

<td Bgcolor="white">
 <a href="?page=publicite&spage=publicite"> Acceuil </a> <br>
 <a href="?page=publicite&spage=listedepub">Publicites </a> <br>
 

</td>
</table>
<br>
		<table border="3" align="center" style="font-size:11px;  width:700px; font-family:verdana;margin:0px auto;">
	<tbody>
	<tr>

		<th align="left"  width="50%"><b>Libelle promotion</b></th>
        <th align="center" width="25%"><b>Etat</b></th>
		<th align="center" width="25%"><b>Action</b></th>
	</tr>				
                  <?php
         $a = "0";
         // print("<br> centrex $centrex <br> ");


$query = " SELECT * FROM pub ORDER BY numpub DESC";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
if(mysql_num_rows($mysql_result) > 0){
while($row = mysql_fetch_array($mysql_result))
                              {
							          $semaine = ($row["semaine"]);
                                      //$datepubfin = ($row["datefin"]);
									  $numpub = ($row["numpub"]);
									  $ob = ($row["objet"]);
									  $et = ($row["etat"]);

if ($et=="1"){$es="En test";} else{$es="En production";}

               ?>

  <tr>

  <td align="left" valign="middle"><?php echo strtoupper($ob); ?></td>
  <td align="center" valign="middle"><?php echo $es; ?> </td>
  <td align="center" valign="middle"><a href="?page=publicite&spage=publicite&numpub=<?php echo $numpub;?>">Editer</a>&nbsp; &nbsp; &nbsp;<a href="#" onClick="javascript:ConfirmMessage('<?php echo $numpub;?>')">Supprimer </a></td>
 
  </tr>
	




                              <?php
                             // $a++;

                              }}else{echo "<tr><td colspan='3' style='font-size:11px;color:red;'>Il n y a pas des promos pour le moment....</td></tr>  <tr height='10'><td colspan='4'></td></tr>	
  <tr><td colspan='5' class='seperator'></td></tr>";}
                                ?>

         </table>


</form>			
</body></html>