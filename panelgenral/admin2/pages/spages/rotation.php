<?php
$mysql_link = mysql_connect("94.23.22.154" ,"tshivuadi","tshivuadi2010");
mysql_select_db("testcentrex", $mysql_link);
//SELECTION DE LA PUB DU JOUR
$day=date("Y-m-d");
$queryd = " SELECT * FROM pubcorrespondance WHERE date='".$day."'";
$mysql_resultd = mysql_query($queryd) or die ("Erreur : ".mysql_error());
while($rowd = mysql_fetch_array($mysql_resultd))
                              { 

									  $numpub = ($rowd["numpub"]);
$querys = " SELECT * FROM pub WHERE numpub='".$numpub."'";
$mysql_results = mysql_query($querys) or die ("Erreur : ".mysql_error());
while($rows = mysql_fetch_array($mysql_results))
                              {
							          $objet= ($rows["objet"]);
									  $message = ($rows["contenu"]);
									  $format = ($rows["format"]);
									  $signatureid = ($rows["signature"]);
									
 }
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
 
if($signatureid==""){
$signature = "-- <br> Service commercial  - Ktis   - <a href='http://www.kt-centrex.com'>http://www.kt-centrex.com</a><br>"
						."<br>Location de serveurs dédiés<br>
						Infogérance et consulting<br>
						Opérateur télécom voip<br>
						Serveurs de jeux<br>";

}
else{
$query = "select * from mailparametre WHERE numero='".$signatureid."'";
$result = mysql_query($query) or die ("Erreur : ".mysql_error());
$row = mysql_fetch_array($result);
$signature = $row['signature'];
}
 if($format=="html"){

$messageHTML = "<html><head><title></title></head><body>".stripslashes($message);
$messageHTML .= "<br><br>"
			."Si vous ne souhaitez plus recevoir de mail publicitaire, cliquez <a href='".$url."?page=suppcourriel'>ici</a>"
			."<br><br>".$signature."</body>";
}								     
else{

$messageHTML = stripslashes($message);
$messageHTML .= "\n\n"
			."Si vous ne souhaitez plus recevoir de mail publicitaire, cliquez sur ce lien ".$url."?page=suppcourriel" 
			."\n\n".$signature;
}
//SELECTION DES CLIENTS LIES A LA PUB DU JOUR



$query = " SELECT * FROM pubcorrespondance WHERE date='".$day."'";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
                              { 

								      $numcli = ($row["numcli"]);
									  
									   
$query4 = " SELECT * FROM identite WHERE numero='".$numcli."'";
$mysql_result4 = mysql_query($query4) or die ("Erreur : ".mysql_error());
while($rowf = mysql_fetch_array($mysql_result4))
                              {
							          $nom = ($rowf["nom"]);
									  $prenom = ($rowf["prenom"]);
									  $email = ($rowf["email"]);
 }

mysql_query("insert into mailstosend(email,objet,message,entete,idsignature) "
."values('".mysql_real_escape_string($email)."','".stripslashes($objet)."','".mysql_real_escape_string($messageHTML)."','".mysql_real_escape_string($headers)."','".$signatureid."'"
.") ") or die ("Erreur : ".mysql_error());
 }
?>