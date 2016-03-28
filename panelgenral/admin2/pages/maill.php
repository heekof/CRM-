<?php /* clients.php */

$query4 = " SELECT * FROM identite WHERE numero='".$_GET['cl']."'";
$mysql_result4 = mysql_query($query4) or die ("Erreur : ".mysql_error());
while($rowf = mysql_fetch_array($mysql_result4))
                              {
							          $nom = ($rowf["nom"]);
									  $prenom = ($rowf["prenom"]);
									  $email = ($rowf["email"]);
 }
 if (isset($_GET['send']))
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

						
						
$libelle = mysql_real_escape_string($_GET['editor1']);
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
<script type="text/javascript" src="editeur/ckeditor.js"></script>
<script src="sample.js" type="text/javascript"></script>
<link href="sample.css" rel="stylesheet" type="text/css" />
<form action="" method="get"   >
<table width="%80" height="470" border="2" align="center" cellpadding="6" cellspacing="0">



<tr>
     <td> <b> Email d'envoie </b> </td>
     <td> <input type="text" name="email" size="20" id="dest" value="<?php echo $email;?>" />
	 &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
	Email de retour (test)  &nbsp; &nbsp; &nbsp;      
<input type="text" name="email1" size="30" value="support@ktcentrex.com" />
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
        <input type="hidden" name="page" value="clients" />
	  <input type="hidden" name="cl" value="<?php echo $_GET['cl'];?>" />
	  <input type="hidden" name="a" value="mail" />
  <td><input type="submit" value="ENVOYER"   /></td>
  <td></td>
  </tr>

</table>

</form>
