<?php
if (isset($_POST['mail']))
{
$headers ='From: "KTcentrex.com" <info@kt-centrex.com>'."\n";
$headers .='Reply-To: info@kt-centrex.com'."\n";
$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
$headers .='Content-Transfer-Encoding: 8bit';

$signature = "-- <br> Service commercial  - Ktis   - <a href='http://www.kt-centrex.com'>http://www.kt-centrex.com</a><br>"
						."<br>Location de serveurs dédiés<br>
						Infogérance et consulting<br>
						Opérateur télécom voip<br>
						Serveurs de jeux<br>";

						
						
$libelle = mysql_real_escape_string($_POST['editor1']);
$objet = $_POST['ob'];
$email = $_POST['email'];



$messageHTML = "<html><head><title></title></head><body>".stripslashes($libelle);
$messageHTML .= "<br><br>"
			."Si vous ne souhaitez plus recevoir de mail publicitaire, cliquez <a href='".$url."?page=suppcourriel'>ici</a>"
			."<br><br>".$signature."</body>";
								     

$day=date("Y-m-d");
	//Fin enregistrement
mysql_query("insert into mailstosend(email,objet,message,entete,idsignature) "
."values('".mysql_real_escape_string($email)."','".stripslashes($objet)."','".mysql_real_escape_string($messageHTML)."','".mysql_real_escape_string($headers)."','$idsignature'"
.") ") or die ("Erreur : ".mysql_error());

echo "<br><center><font color='green' size='4'>Mail de test envoi&eacute; avec succ&egrave;!!!</font></center>";
}
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" title="Design" href="../design.css" type="text/css" media="screen" />
<!-- TinyMCE -->
<script type="text/javascript" src="editeur/ckeditor.js"></script>
<script src="sample.js" type="text/javascript"></script>
<link href="sample.css" rel="stylesheet" type="text/css" />

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
 <a href="?page=listedepub&spage=listedepub">Publicites </a> <br>
 

</td>
</table>

<form action="" method="post"   >
<?php
	if(isset($modif) && $modif=="ok")
	{
		echo '<input type="hidden" name="modif" value="ok">';
		echo '<input type="hidden" name="idmail" value="'.$idmail.'">';
		
		$query = "select * from lesmails where numero='$idmail' ;";
		if($result = mysql_query($query) or die ("Erreur : ".mysql_error()))
		{
			while($row = mysql_fetch_array($result))
			{
				$type = $row['type'];
				$exp = $row['expediteur'];
				$dest = $row['destinataire'];
				$obj = $row['objet'];
				$msg = $row['message'];
				$date = $row['date'];
				$datemodif = $row['datemodif'];
				$idsignature = $row['idsignature'];
			}
		}
	}
?>
<table width="%80" height="470" border="2" align="center" cellpadding="6" cellspacing="0">



<tr>
     <td> <b> Email d'envoie </b> </td>
     <td> <input type="text" name="email" size="20" id="dest" value="<?php echo $dest;?>" />
	 &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
	Email de retour (test)  &nbsp; &nbsp; &nbsp;      
<input type="text" name="email1" size="30" value="<?php echo $exp;?>" />
      </td>
</tr>



  <tr>
    <td><label for="editor1" style="font-family:verdana; font-size:11px;">Objet du mail:</label></td>
    <td><input class="ckeditor" style="width:355px;" id="ob" value="" name="ob"></td>
  </tr>

  <tr>
    <td height="335" colspan="2">

     <textarea class="ckeditor"  cols="10" id="editor1" name="editor1" rows="5"><?php echo $message;?></textarea>  </td>
  </tr>
  
   <tr>
  <td>Signature : </td>
  <td>
	<?php
	$query = "select * from mailparametre;";
		if($result = mysql_query($query) or die ("Erreur : ".mysql_error()))
		{
			echo '<select name="idsignature">';
			while($row = mysql_fetch_array($result))
			{
				$numero = $row['numero'];
				$nom = $row['nom'];
				echo '<option value="'.$numero.'"';
				if($idsignature == $numero) echo ' selected="selected"';
				echo '>'.$nom.'</option>';
			}
			echo '</select>';
		}
	?>
  </td>
  </tr>
  
  <tr>
        <input type="hidden" name="page" value="mail" />
      <input type="hidden" name="spage" value="mail" />
	  <input type="hidden" name="add" value="add" />
  <td><input type="submit" value="ENVOYER"   /></td>
  <td></td>
  </tr>

</table>

</form>
</body>
</html>