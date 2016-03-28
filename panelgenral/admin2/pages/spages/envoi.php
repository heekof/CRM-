<?php
$day=("Y-m-d");
	$signature = "-- <br> Service commercial  - Ktis   - <a href='http://www.kt-centrex.com'>http://www.kt-centrex.com</a><br>"
						."<br>Location de serveurs dédiés<br>
						Infogérance et consulting<br>
						Opérateur télécom voip<br>
						Serveurs de jeux<br>";

$Tfile_path = explode('/',$_SERVER['PHP_SELF']);
$ch = "";
for($i=0; $i<count($Tfile_path)-1; $i++) $ch .= $Tfile_path[$i]."/";
$url = "http://".$_SERVER['HTTP_HOST'].$ch."voir.php";
		
 $headers ='From: "KTcentrex.com" <webkalor@gmail.com>'."\n";
 $headers .='Reply-To: webkalor@gmail.com '."\n";
 $headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
 $headers .='Content-Transfer-Encoding: 8bit';


$query = " SELECT DISTINCT numpub FROM pubcorrespondance WHERE date='".$day."'";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
                              {
							          $numpub = ($row["numpub"]);

 $querys = " SELECT * FROM pub WHERE numpub='".$numpub."'";
$mysql_results = mysql_query($querys) or die ("Erreur : ".mysql_error());
while($rows = mysql_fetch_array($mysql_results))
                              {
							          $objet= ($rows["objet"]);
									  $message = ($rows["contenu"]);
									
 }
 
 }
 $messageHTML = "<html><head><title></title></head><body>".stripslashes($message);
 $messageHTML .= "<br><br>"
			."Si vous ne souhaitez plus recevoir de mail publicitaire, cliquez <a href='".$url."?page=suppcourriel'>ici</a>"
			."<br><br>".$signature."</body>";


 
$query = " SELECT * FROM pubcorrespondance WHERE date='".$day."'";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
                              {

									  $numcli = ($row["numcli"]);
									   
$query = " SELECT * FROM baseclient WHERE numero='".$numcli."'";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
                              {
							          $nom = ($row["nom"]);
									  $prenom = ($row["prenom"]);
									  echo $email = ($row["email"]);
 }

 
 
 echo $email,stripslashes($objet),$messageHTML, $headers."<br>";
 
 
 }

echo "<br><center><font color='green' size='4'>Mail de test envoi&eacute; avec succ&egrave;!!!</font></center>";

?>