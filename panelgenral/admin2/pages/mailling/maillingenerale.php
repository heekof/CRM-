<?php

require("haut.php");
 ?>
</html>
</td>
</table>

<p><br>

<?php
	$query = "select * from mailparametre where numero='$idsignature'";
	//print $query;
	//die('test');
	$email= $_POST['email'];
	$email1= $_POST['email1'];
	$objet= $_POST['objet'];
	$message= $_POST['message'];
	$idsignature= $_POST['id_base'];
	
	if($result = mysql_query($query) or die ("Erreur : ".mysql_error()))
	{
		while($row = mysql_fetch_array($result))
		{
			$numero = $row['numero'];
			$nom = $row['nom'];
			$signature = $row['signature'];
		}
	}
	if(!isset($signature) && !$signature)
		$signature = "-- <br> Service commercial  - Ktis   - <a href='http://www.kt-centrex.com'>http://www.kt-centrex.com</a><br>"
							."<br>Location de serveurs dédiés<br>
							Infogérance et consulting<br>
							Opérateur télécom voip<br>
							Serveurs de jeux<br>";
	
	$Tfile_path = explode('/',$_SERVER['PHP_SELF']);
	$ch = "";
	for($i=0; $i<count($Tfile_path)-1; $i++) $ch .= $Tfile_path[$i]."/";
	$url = "http://".$_SERVER['HTTP_HOST'].$ch."voir.php";
			
	$headers ='From: "KTcentrex.com" <'.$email1.'>'."\n";
	 $headers .='Reply-To: '.$email1.''."\n";
	 $headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
	 $headers .='Content-Transfer-Encoding: 8bit';
	 
	 /*$emaill2='bpatrick@patrick.com';
	 $headers ='From: "patrick.com" <'.$emaill2.'>'."\n";
	 $headers .='Reply-To: '.$emaill2.''."\n";
	 $headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
	 $headers .='Content-Transfer-Encoding: 8bit';*/

	//require("base.php");
	$messageHTML = "<html><head><title></title></head><body>".stripslashes($message);
	
	$etat = $_POST['etat'];
	
	
	if($etat == '3')
	{
		$messageHTML .= "<br><br>"
				."Si vous ne souhaitez plus recevoir de mail publicitaire, cliquez <a href='".$url."?page=suppcourriel'>ici</a>"
				."<br><br>".$signature."</body>";

		//On enregistre le mail
		if(isset($modif) && $modif=="ok")
		{
			/*$query = "update lesmails set "
			."type = 'Membres', "
			."expediteur = '".mysql_real_escape_string($email1)."', "
			."destinataire = 'Tous nos membres', "
			."objet = '".mysql_real_escape_string($objet)."', "
			."message = '".mysql_real_escape_string($message)."', "
			."datemodif = '".date('Y-m-d H:i:s',time())."' where numero='$idmail'";*/
			$query = "update lesmails 
				set type = 'Membres', expediteur = '".mysql_real_escape_string($email1)."',
					destinataire = 'Tous nos membres', objet = '".mysql_real_escape_string($objet)."',
					message = '".mysql_real_escape_string($message)."',, datemodif = '".date('Y-m-d H:i:s',time())."' 
				where numero='$idmail'";
			//print $query."<br/>";
			//exit();
			mysql_query($query) or die ("Erreur : ".mysql_error());
		}
		else
		{
			$query = "insert into lesmails 
					(type,expediteur,destinataire,objet,message,date,datemodif,idsignature)
					values('Membres','".mysql_real_escape_string($email1)."','Tous nos membres',
					'".mysql_real_escape_string($objet)."','".mysql_real_escape_string($message)."',
					'".date('Y-m-d H:i:s',time())."','".date('Y-m-d H:i:s',time())."','$idsignature')";
			//print $query."<br/>";
			mysql_query($query) or die ("Erreur : ".mysql_error());
		}
		//Fin enregistrement
		$query = " SELECT * FROM identite";
		$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
		while($row = mysql_fetch_array($mysql_result))
		{
			//$nomgroupe = ($row["numgroup"]) ;
			$email = ($row["email"]) ;
			$nom = ($row["nom"]) ;
			$prenom = ($row["prenom"]) ;
			//On mets dans la fils de lancement
			//print $idmail3;
			//var_dump($email);
			if(mail($email,stripslashes($objet),$messageHTML, $headers))
			{	//var_dump($email);
				mysql_query("insert into mailstosend(email,objet,message,entete,idsignature) "
				."values('".mysql_real_escape_string($email)."','".stripslashes($objet)."','".mysql_real_escape_string($messageHTML)."','".mysql_real_escape_string($headers)."','$idsignature'"
				.") ") or die ("Erreur : ".mysql_error());
			}
		}
		echo "<br><center><font color='green' size='4'>Mails de Membres envoi&eacute;s avec succ&egrave;s!!!</font></center>";

	}
	if($etat == '2')
	{
		$messageHTML .= "<br><br>"
				."Si vous ne souhaitez plus recevoir de mail publicitaire, cliquez <a href='".$url."?page=suppcourriel'>ici</a>"
				."<br><br>".$signature."</body>";

		//On enregistre le mail
		if(isset($modif) or $modif=="ok")
		{
			$query = "update lesmails set "
			."type = 'Production', "
			."expediteur = '".mysql_real_escape_string($email1)."', "
			."destinataire = '".mysql_real_escape_string($email)."', "
			."objet = '".mysql_real_escape_string($objet)."', "
			."message = '".mysql_real_escape_string($message)."', "
			."datemodif = '".date('Y-m-d H:i:s',time())."' where numero='$idmail' ;";//problème avec cet id
			//print $query.'<br/>';
			mysql_query($query) or die ("Erreur : ".mysql_error());
		}
		else
		{
			$query = "insert into lesmails (type,expediteur,destinataire,objet,message,date,datemodif,idsignature) "
					." values('Production','".mysql_real_escape_string($email1)."','".mysql_real_escape_string($email)."','".mysql_real_escape_string($objet)."','".mysql_real_escape_string($message)."','".date('Y-m-d H:i:s',time())."','".date('Y-m-d H:i:s',time())."','$idsignature')";
			//print $query.'<br/>';
			mysql_query($query) or die ("Erreur : ".mysql_error());
		}
		//Fin enregistrement
		$query = " SELECT * ";
		$query .= " FROM baseclient  where nombase = '$idsignature' ";
		$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
		while($row = mysql_fetch_array($mysql_result))
		{
			//$nomgroupe = ($row["numgroup"]) ;
			$email = ($row["email"]) ;
			$nom = ($row["nom"]) ;
			$prenom = ($row["prenom"]) ;
			//var_dump($email);
			//print $idmail3;
			//On mets dans la fils de lancement
			if(mail($email,stripslashes($objet),$messageHTML, $headers))
			{	//var_dump($email);
				mysql_query("insert into mailstosend(email,objet,message,entete,idsignature) "
				."values('".mysql_real_escape_string($email)."','".stripslashes($objet)."','".mysql_real_escape_string($messageHTML)."','".mysql_real_escape_string($headers)."','$idsignature'"
				.") ") or die ("Erreur : ".mysql_error());
			}
		}
		echo "<br><center><font color='green' size='4'>Mails de Production envoi&eacute;s avec succ&egrave;s!!!</font></center>";
	}
	
	if($etat == '1')
	{	//print 'slt';
		//On enregistre le mail   mysql_real_escape_string()
		if(isset($modif) && $modif=="ok")
		{
			
			
			$query = "update lesmails set 
				type = 'Test', expediteur = '".mysql_real_escape_string($email1)."',
				destinataire = '$id_base', objet = '".mysql_real_escape_string($objet)."',
				message = '".mysql_real_escape_string($message)."', datemodif = '".date('Y-m-d H:i:s',time())."'
				where numero='$idmail'";
			
			//print $query;
			//die('test4');
			mysql_query($query) or die ("Erreur : ".mysql_error());
		}
		else
		{
			$messageHTML .= "<br><br>".$signature."</body>";
			$query = "insert into lesmails (type,expediteur,destinataire,objet,message,date,datemodif,idsignature) "
					." values('Test','".mysql_real_escape_string($email1)."' ,'".mysql_real_escape_string($email)."', '".mysql_real_escape_string($objet)."','".mysql_real_escape_string($message)."','".date('Y-m-d H:i:s',time())."','".date('Y-m-d H:i:s',time())."','$idsignature')";
			//print $query."<br/>";
			//print "Coucou world<br/>";
			mysql_query($query) or die ("Erreur : ".mysql_error());
		}
		//print $query;
		//die('test4');
		//Fin enregistrement
		$query = " SELECT distinct * ";
		$query .= " FROM baseclient  where nombase = '$idsignature' ";
		$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
		/*$e = 'test@patrick.com';
		echo $e.' | '.$objet.' | '.$messageHTML.' <br/>'.$headers.'<br/>';
		mail($e,stripslashes($objet),$messageHTML, $headers);
		var_dump($messageHTML);
		echo "cool";
		if(mail($e,stripslashes($objet),$messageHTML, $headers)){
			echo '<br/>	message send';
		}else{
			echo '<br/>sorry';
		}*/
		//print $query;
		while($row = mysql_fetch_array($mysql_result))
		{
			//$nomgroupe = ($row["numgroup"]) ;
			$e = ($row["email"]) ;
			$nom = ($row["nom"]) ;
			$prenom = ($row["prenom"]) ;
			//echo $e.' '.$objet.' '.$messageHTML.' \n'.$headers;
			
			//Fin enregistrement
			mail($e,stripslashes($objet),$messageHTML, $headers);
			//var_dump($e);
			
		}
		echo "<br><center><font color='green' size='4'>Mail de test envoi&eacute; avec succ&egrave;s!!!</font></center>";
	}
?>

</html>
