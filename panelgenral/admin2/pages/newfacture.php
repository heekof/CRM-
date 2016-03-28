<?php
require_once('lib/form.php');
require_once('lib/check.php');
require_once('lib/paging.php');
//require_once('lib/date.php');

//Titre
$title = 'Création d\'une facture/d\'un devis';

global  $nom, $prenom, $societe,
		$adresse, $ville, $codepostal, $pays,
		$email, $telephonef, $telephonep, $telephoneb,
		$liv_adresse, $liv_codepostal, $liv_ville, $liv_pays, $idSansCpt, $tva, $nomDuDevis;
		
$errors = array();
	if (strlen($nom) <= 0)
		$errors[] = 'Nom incorrect ou manquant';
	if (strlen($prenom) <= 0)
		$errors[] = 'Prénom incorrect ou manquant';
	if (!check_mail($email))
		$errors[] = 'E-mail incorrect ou manquant';
	//if (strlen($societe) <= 0)
	//	$errors[] = 'Nom de société incorrect ou manquant';
	/*if (strlen($adresse) <= 0)
		$errors[] = 'Adresse incorrect ou manquante';
	if (strlen($ville) <= 0)
		$errors[] = 'Ville incorrecte ou manquante';
	if (!check_postal($codepostal))
		$errors[] = 'Code postal incorrect ou manquant';
	if (strlen($pays) <= 0)
		$errors[] = 'Pays incorrect ou manquant';
	if (!check_phone($telephonef))
		$errors[] = 'Téléphone fixe incorrect ou manquant';
	if (!check_phone($telephonep))
		$errors[] = 'Téléphone portable incorrect ou manquant';
	if (strlen($telephoneb) > 0 && !check_phone($telephoneb))
		$errors[] = 'Téléphone bureau incorrect';*/
if(($r_cli = @mysql_query(" SELECT * FROM identite where numero='".$idclient."' ")) && $idclient)
{
	$cli = mysql_fetch_array($r_cli);

$nom =$cli['nom']; $prenom =$cli['prenom']; $societe =$cli['societe'];
$adresse =$cli['adresse']; $ville =$cli['ville']; $codepostal =$cli['codepostal']; $pays =$cli['pays'];
$email =$cli['email']; $telephonef =$cli['telephonef']; $telephonep =$cli['telephonep']; 
$telephoneb =$cli['telephoneb'];$liv_adresse =$cli['liv_adresse']; $liv_codepostal =$cli['liv_codepostal']; 
$liv_ville =$cli['liv_ville']; $liv_pays =$cli['liv_pays'];
}
if(!isset($a)) $a="new";

if(isset($a) && ($a=='new' || $a=='Ajouter un élément'))
{

?>
<form method="POST" action="?page=facturation&amp;spage=newfacture" onsubmit="return checkFormFact();">
<table class="form">
<thead><td colspan="2">Création d'une facture<?php if($nbElt) echo ' : d&eacute;j&agrave; '.$nbElt.' &eacute;l&eacute;ment(s) dans la facture' ?></td></thead>
<tfoot><td colspan="2">
<input type="submit" value="Ajouter un élément" name="a">
<input type="submit" value="Terminer" name="a">
<input type="hidden" value="<?php if($a=='new') echo '1';else echo ($nbElt+1);?>" name="nbElt">
<?php?>
</td></tfoot>

<tr>
	<td class="label">&Eacute;l&eacute;ment</td>
	<td class="input">
	<?php
	
	//Récupère les éléments disponibles
	if($r_elt = @mysql_query(" SELECT * FROM element "))
	{
		echo '<select name="reference" id="elements" onchange="getPrixElement();">'
			.'<option value="0">-&nbsp;&nbsp;&nbsp;&nbsp;Choisir un &eacute;l&eacute;ment&nbsp;&nbsp;&nbsp;-</option>';
		
		while($elt = mysql_fetch_array($r_elt))
		{
			echo '<option value="'.$elt['id'].'" title="'.$elt['description'].'">'.$elt['nom'].'</option>';
		}
		echo '</select>';
	}
	?>
	</td>
</tr>
<tr>
	<td class="label">Prix unitaire</td>
	<td class="input"><input type="text" name="prixU" id="prixU"></td>
</tr>
<tr>
	<td class="label">Quantit&eacute;</td>
	<td class="input"><input type="text" name="qte" value="1"></td>
</tr>
<tr <?php if($a!='new') echo 'style="display:none;"';?>>
	<td colspan="2" bgcolor="#DFDFDF" >Type de client :&nbsp;&nbsp;
	<input <?php if($a=='new' || $typecli=="acompte") echo 'checked="checked"'; ?> type="radio" name="typecli" value="acompte"  onclick="openHideInfoCli('0');" >Client ayant un compte
	<input <?php if(isset($typecli) && $typecli=="sanscompte") echo 'checked="checked"'; ?> type="radio" name="typecli" value="sanscompte"  onclick="openHideInfoCli('1');">Client sans compte
	</td>
</tr>
<tr id="clicpt" <?php if(isset($typecli) && $typecli=="sanscompte") echo 'style="display:none;"';?>>
	<td class="label">Client</td>
	<td class="input">
	<?php
	
	//Récupère les éléments disponibles
	if($a=='Ajouter un élément')
	{
		if($r_cli = @mysql_query(" SELECT * FROM identite where numero='".$idclient."' "))
		{
			$cli = mysql_fetch_array($r_cli);
		}
		echo $cli['prenom'].' '.$cli['nom'];
		
		echo '<input type="hidden" name="idclient" value="'.$idclient.'">';
	}else
	{
		if($r_cli = @mysql_query(" SELECT * FROM identite "))
		{
			echo '<select name="idclient" onchange="">'
				.'<option value="0">-&nbsp;&nbsp;&nbsp;&nbsp;Choisir le client&nbsp;&nbsp;-</option>';
			
			while($cli = mysql_fetch_array($r_cli))
			{
				echo '<option value="'.$cli['numero'].'" >'.$cli['prenom'].' '.$cli['nom'].'</option>';
			}
			echo '</select>';
		}
	}
	?>
	</td>
</tr>
<tr id="cliSansCpt" <?php if($a=='new' || $typecli=="acompte") echo 'style="display:none;"'; ?>>
<td colspan="2">
<table>
<?php
if($a=='new')
{
	insert_form_element('Nom', 'text', 'nom', $nom, true);
	insert_form_element('Prénom', 'text', 'prenom', $prenom, true);
	insert_form_element('Société', 'text', 'societe', $societe, true);
	insert_form_element('Adresse', 'text', 'adresse', $adresse, true);
	insert_form_element('Ville', 'text', 'ville', $ville, true);
	insert_form_element('Code Postal', 'text', 'codepostal', $codepostal, true);
	insert_form_element('Pays', 'text', 'pays', $pays, true);
	insert_form_element('E-Mail', 'text', 'email', $email, true);
	insert_form_element('Téléphone fixe', 'text', 'telephonef', $telephonef, true);
	insert_form_element('Téléphone portable', 'text', 'telephonep', $telephonep, true);
	insert_form_element('Téléphone bureau', 'text', 'telephoneb', $telephoneb, true);
	insert_form_element('Livraison: Adresse', 'text', 'liv_adresse', $liv_adresse, true);
	insert_form_element('Livraison: Code postal', 'text', 'liv_codepostal', $liv_codepostal, true);
	insert_form_element('Livraison: Ville', 'text', 'liv_ville', $liv_ville, true);
	insert_form_element('Livraison: Pays', 'text', 'liv_pays', $liv_pays, true);
}else
{
	insert_form_element('Client (sans compte)', 'text', 'nom', $prenom.' '.$nom, false);
	echo '<input type="hidden" name="nom" value="'.$nom.'">';
	echo '<input type="hidden" name="prenom" value="'.$prenom.'">';
	echo '<input type="hidden" name="societe" value="'.$societe.'">';
	echo '<input type="hidden" name="ville" value="'.$ville.'">';
	echo '<input type="hidden" name="codepostal" value="'.$codepostal.'">';
	echo '<input type="hidden" name="pays" value="'.$pays.'">';
	echo '<input type="hidden" name="email" value="'.$email.'">';
	echo '<input type="hidden" name="telephonef" value="'.$telephonef.'">';
	echo '<input type="hidden" name="telephonep" value="'.$telephonep.'">';
	echo '<input type="hidden" name="telephoneb" value="'.$telephoneb.'">';
	echo '<input type="hidden" name="liv_adresse" value="'.$liv_adresse.'">';
	echo '<input type="hidden" name="liv_codepostal" value="'.$liv_codepostal.'">';
	echo '<input type="hidden" name="liv_ville" value="'.$liv_ville.'">';
	echo '<input type="hidden" name="liv_pays" value="'.$liv_pays.'">';
}
?>
</table>
</td>
</tr>
<?php
if($a=="new")
{	
?>
<tr>
	<td class="label">Frais d'envoie/Préparation/Divers...</td>
	<td class="input"><input type="text" name="frais" value="0"></td>
</tr>
<tr>
	<td class="label">TVA(en %)</td>
	<td class="input"><input id="tva" type="text" name="tva" value="19.6"></td>
</tr>
<?php
}else echo '<input type="hidden" name="tva" value="'.$tva.'">';
?>
</table>
<?php
	if($a=='Ajouter un élément')
	{
		if($nbElt==1)
		{
			//Vérifie qu'il existe un client avec l'id donné
			if(!$reference || (!$idclient && $typecli=="acompte") || ($typecli=="sanscompte" && count($errors) > 0))
			{
				echo '<center><font color="red" size="4">';
				
				if(!$idclient && $typecli=="acompte")
				echo 'Veuillez choisir un client!<br>';
				
				if(!$reference)
				echo 'Veuillez choisir un &eacute;l&eacute;ment!<br>';
				
				if($typecli=="sanscompte" && count($errors) > 0)
				{
					echo '<p class="error">';
					foreach ($errors as $error)
						echo htmlentities($error).'.<br />';
					echo '</p>';
				}
				echo '<input type="button" onclick="history.back();" value="Retour"></font></center>';
			}
			else
			{
				if($typecli=="sanscompte")//Client sans compte
				{
					$idclient = 0;
					//$r_dejaVu = mysql_query('SELECT * FROM identite_sans_compte where email="'.$email.'" ;');
					$r_dejaVu = mysql_query('SELECT * FROM identite where email="'.$email.'" ;');
					$dejaVu = mysql_num_rows($r_dejaVu);
					$infoCliSansCpt = mysql_fetch_array($r_dejaVu);
					//if($dejaVu) $idSansCpt = $infoCliSansCpt['numero'];
					if($dejaVu) $idclient = $infoCliSansCpt['numero'];
					else
					{
						//mysql_query('insert into identite_sans_compte (nom, prenom, societe, adresse, ville, codepostale, pays, email, telephonef, telephonep, telephoneb, liv_adresse, liv_codepostal, liv_ville, liv_pays) '
						mysql_query('insert into identite (nom, prenom, societe, adresse, ville, codepostale, pays, email, telephonef, telephonep, telephoneb, liv_adresse, liv_codepostal, liv_ville, liv_pays) '
						.' value ("'.$nom.'","'.$prenom.'","'.$societe.'","'.$adresse.'" ,"'.$ville.'" ,"'.$codepostal.'" ,"'.$pays.'" ,"'.$email.'","'.$telephonef.'","'.$telephonep.'","'.$telephoneb.'" ,"'.$liv_adresse.'","'.$liv_codepostal.'","'.$liv_ville.'","'.$liv_pays.'") ');
						//$idSansCpt = mysql_insert_id();
						$idclient = mysql_insert_id();
					}
				}
				//Création de la facture
				/*$query = " INSERT INTO facture (idclient,idclientSansCpt, date, frais, tva) ".
					" VALUES('".(int)$idclient."','".(int)$idSansCpt."', NOW(), '".$frais."','".($tva/100)."');";*/
					
					$query = " INSERT INTO facture (idclient, date, frais, tva,paiement) ".
					" VALUES('".(int)$idclient."', NOW(), '".$frais."','".($tva/100)."','1');";
				mysql_query($query) or die ("Erreur : ".mysql_error());
				$f =  mysql_insert_id();
				//ajoute l'element
				$query = " INSERT INTO elementfacture (idfacture, idelement, quantite, prix) ".
					" VALUES('".(int)$f."', '".(int)$reference."' , '".(int)$qte."' , '".($qte*$prixU)."');";
				mysql_query($query) or die ("Erreur : ".mysql_error());
			//echo $prixU;
				echo '<input type="hidden" value="'.$f.'" name="f">';
			}
		}
		else if($nbElt > 1)
		{
			if(!$reference)
			{
				echo '<center><font color="red" size="4">Veuillez choisir un &eacute;l&eacute;ment!<br><input type="button" onclick="history.back();" value="Retour"></font></center>';
			}else
			{
				//ajoute l'element
				$query = " INSERT INTO elementfacture (idfacture, idelement, quantite, prix) ".
					" VALUES('".(int)$f."', '".(int)$reference."' , '".(int)$qte."' , '".($qte*$prixU)."');";
				mysql_query($query) or die ("Erreur : ".mysql_error());
			//echo $prixU;
				echo '<input type="hidden" value="'.$f.'" name="f">';
			}
		}
	}

?>
</form>
<?php
	
}else if(isset($a) && $a=='Terminer')
{	
	if($nbElt==1)
		{
			//Vérifie qu'il existe un client avec l'id donné
			if(!$reference || (!$idclient && $typecli=="acompte") || ($typecli=="sanscompte" && count($errors) > 0))
			{
				echo '<center><font color="red" size="4">';
				
				if(!$idclient && $typecli=="acompte")
				echo 'Veuillez choisir un client!<br>';
				
				if(!$reference)
				echo 'Veuillez choisir un &eacute;l&eacute;ment!<br>';
				
				if($typecli=="sanscompte" && count($errors) > 0)
				{
					echo '<p class="error">';
					foreach ($errors as $error)
						echo htmlentities($error).'.<br />';
					echo '</p>';
				}
				echo '<input type="button" onclick="history.back();" value="Retour"></font></center>';
			}else
			{
				if($typecli=="sanscompte")//Client sans compte
				{
					$idclient = 0;
					//$r_dejaVu = mysql_query('SELECT * FROM identite_sans_compte where email="'.$email.'" ;');
					$r_dejaVu = mysql_query('SELECT * FROM identite where email="'.$email.'" ;');
					$dejaVu = mysql_num_rows($r_dejaVu);
					$infoCliSansCpt = mysql_fetch_array($r_dejaVu);
					//if($dejaVu) $idSansCpt = $infoCliSansCpt['numero'];
					if($dejaVu) $idclient = $infoCliSansCpt['numero'];
					else
					{
						//mysql_query('insert into identite_sans_compte (nom, prenom, societe, adresse, ville, codepostale, pays, email, telephonef, telephonep, telephoneb, liv_adresse, liv_codepostal, liv_ville, liv_pays) '
						mysql_query('insert into identite (nom, prenom, societe, adresse, ville, codepostale, pays, email, telephonef, telephonep, telephoneb, liv_adresse, liv_codepostal, liv_ville, liv_pays) '
						.' values ("'.$nom.'","'.$prenom.'","'.$societe.'","'.$adresse.'" ,"'.$ville.'" ,"'.$codepostal.'" ,"'.$pays.'" ,"'.$email.'","'.$telephonef.'","'.$telephonep.'","'.$telephoneb.'" ,"'.$liv_adresse.'","'.$liv_codepostal.'","'.$liv_ville.'","'.$liv_pays.'") ') or die ("Erreur : ".mysql_error());
						//$idSansCpt = mysql_insert_id();
						$idclient = mysql_insert_id();
					}
				}
			
				//Création de la facture
				/*$query = " INSERT INTO facture (idclient,idclientSansCpt, date, frais, tva) ".
					" VALUES('".(int)$idclient."','".(int)$idSansCpt."', NOW(), '".$frais."','".($tva/100)."');";*/
					
					$query = " INSERT INTO facture (idclient, date, frais, tva,paiement) ".
					" VALUES('".(int)$idclient."', NOW(), '".$frais."','".($tva/100)."','1');";
				mysql_query($query) or die ("Erreur : ".mysql_error());
				$f =  mysql_insert_id();
				//ajoute l'element
				$query = " INSERT INTO elementfacture (idfacture, idelement, quantite, prix) ".
					" VALUES('".(int)$f."', '".(int)$reference."' , '".(int)$qte."' , '".($qte*$prixU)."');";
				mysql_query($query) or die ("Erreur : ".mysql_error());
				//secho $prixU;
			}
		}
		else if($nbElt > 1)
		{
			if(!$reference)
			{
				echo '<center><font color="red" size="4">Veuillez choisir un &eacute;l&eacute;ment!<br><input type="button" onclick="history.back();" value="Retour"></font></center>';
			}else
			{
				//ajoute l'element
				$query = " INSERT INTO elementfacture (idfacture, idelement, quantite, prix) ".
					" VALUES('".(int)$f."', '".(int)$reference."' , '".(int)$qte."' , '".($qte*$prixU)."');";
				mysql_query($query) or die ("Erreur : ".mysql_error());
				//echo $prixU;
			}
		}
	
	//Si nous sommes en présence d'un client sans compte on lui crée un dévis qu'on enregistre et on lui envoie une copie par mail
	if(check_mail($email) && $reference)
	{
		$Tfile_path = explode('/',$_SERVER['PHP_SELF']);
		$ch = "";
		for($i=0; $i<count($Tfile_path)-1; $i++) $ch .= $Tfile_path[$i]."/";
		$logo = "http://".$_SERVER['HTTP_HOST'].$ch."images/logoktis.jpg";
		$nomDuDevis = "devisC".$idclient.'f'.$f;
		include("scripts/devisClientSansCompte.php");
		//echo 'client sans compte';
		
		echo '<center><font color="green" size="4" weight="bold">Devis enregistré avec succ&egrave;!!!</font></center>';
		echo '<br><br><center><form action="les_devis/'.$nomDuDevis.'.pdf" target="_window" method="POST">'
		    .'<input type="submit" value="Voir le dévis">'
		    .'</form>';
		echo '<form action="?page=facturation&amp;spage=newfacture" method="POST">'
		    .'<input type="hidden" name="email" value="'.$email.'">'
		    .'<input type="hidden" name="nomDuDevis" value="'.$nomDuDevis.'">'
		    .'<input type="hidden" name="desc" value="'.$desc.'">'
		    .'<input type="hidden" name="prenom" value="'.$prenom.'">'
		    .'<input type="hidden" name="nom" value="'.$nom.'">'
			.'<input type="hidden" value="'.$f.'" name="f">'
		    .'<input type="submit" name="a" value="Envoyer le devis au client">'
		    .'</form></center>';
		
	}else if($reference)
	echo '<center><font color="green" size="4" weight="bold">Facture enregistrée avec succ&egrave;!!!</font></center>';
}
else if(isset($a) && $a=='Envoyer le devis au client')
{
		$entete  = 'MIME-Version: 1.0' . "\r\n";
		$entete .= 'Content-type: text/html; charset=iso-8859-1'. "\r\n";
		$entete .= 'From: "KALONJI Tony" <info@kt-centrex.com>\n'; 
		$entete .= 'Reply-to: "KALONJI Tony" <info@kt-centrex.com>\n'; 
		
		$subject = "Devis : ".$desc;
		
		$message = '<html><head><title></title></head><body>
				<p>Bonjour '.$prenom.' '.$nom.',</p>

				<br>Nous vous envoyons ce mail suite &agrave; votre demande de devis concernant nos produits.<br>
				Pour voir les d&eacute;tails du devis et les modalités de paiement, veuillez cliquer 
				<a href="http://admin.kt-centrex.com/voir.php?page=recapfacture&f='.$f.'">ICI</a> </p>

				<br /><br />Merci de votre confiance!<br /><br />
				Cordialement!<br /><br />';
		$message.='-- <br> KALONJI Tony  - Ktis   - <a href="http://www.ktis-fr.com">http://www.ktis-fr.com</a><br>'.
				'Tel: 170 819 329 - skype: tommmmy991<br><br>
				Location de serveurs dédiés<br>
				Infogérance et consulting<br>
				Opérateur télécom voip<br>
				Serveurs de jeux<br></body></html>';
	
	$rps = mail($email,$subject,$message,$entete);
			if($rps) echo '<center><font color="green" size="5">Mail a &eacute;t&eacute; envoi&eacute; avec succ&egrave;s!</font></center><br>';
			else  echo '<center><font color="red" size="5">Le mail n\'a pas p&ucirc; &ecirc;tre envoi&eacute;!</font></center><br>';
}

?>
