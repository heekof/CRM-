<?php /* credits.php */
require_once('lib/form.php');
require_once('lib/paging.php');
require_once('lib/date.php');


if (isset($_GET['search']))
{

$c=$_GET['c'];
$red = mysql_query("SELECT * FROM credit WHERE  idclient='$c'");

while($r= mysql_fetch_array($red))
            { 
       $num=$r['numero'];
		$credit=$r['credit'];
			  }
	// Crée le tableau
	echo '<table class="form">';
	
	// Crée l'en-tête du tableau
	echo '<thead><tr><td colspan="2">';
	if (!$editable || $update)
		echo 'Crédit n°'.$num;
	else
		echo 'Ajout d\'un crédit';
	echo '</td></tr></thead>';

	// Ecrit le pied du tableau
	echo '<tfoot><tr><td colspan="2">';
	// Soit le formulaire est éditable, on ajoute le bouton modifier
	if ($editable)
	{
		echo '<input type="submit" value="';
		if ($update && !$aug)
			echo 'Modifier';
		elseif($aug)
			echo 'valider';
		else
			echo 'Créer';
		echo '" />';
	}
	// Soit le formulaire n'est pas éditable, on ajoute quatre butons: Editer, Augmenter credit et Supprimer
	else
	{
		echo '<form method="get" action="">'
			.'<input type="hidden" name="page" value="gestioncredits" />'
			.'<input type="hidden" name="spage" value="credits" />'
			.'<input type="hidden" name="c" value="'.$num.'" />'
			.'<input type="hidden" name="a" value="edit" />'
			.'<input type="submit" value="Editer" />'
			.'</form>';
		echo '<form method="get" action="">'
			.'<input type="hidden" name="page" value="gestioncredits" />'
			.'<input type="hidden" name="spage" value="credits" />'
			.'<input type="hidden" name="c" value="'.$num.'" />'
			.'<input type="hidden" name="a" value="augmenter" />'
			.'<input type="submit" value="Augmenter du cr&eacute;dit au client" />'
			.'</form>';
		echo '<form method="get" action="">'
			.'<input type="hidden" name="page" value="gestioncredits" />'
			.'<input type="hidden" name="spage" value="credits" />'
			.'<input type="hidden" name="c" value="'.$num.'" />'
			.'<input type="hidden" name="a" value="del" />'
			.'<input type="submit" value="Supprimer" />'
			.'</form>';
	}
	echo '</td></tr></tfoot>';
	
	// Ajoute le contenu du tableau
	echo '<tbody>';
	insert_form_element('ID client', 'text', 'nom', $c, $editable);
	insert_form_element('crédit', 'text', 'credit', $credit, $editable);
	echo '</tbody>';
	
	// Termine le tableau
	echo '</table>';
}	 
function generate_credit_form($editable, $update,$new=false,$aug=false)
{
	// Variables globales utilisées pour (pré)remplir le formulaire
	global $id, $id_client, $nom_client, $prenom_client, $credit, $etat, $mail, $val_credit;
	
	// Commence le formulaire en haut du tableau si tout est éditable
	if ($editable)
	{
		echo '<form method="post" action="?page=gestioncredits&amp;spage=credits&amp;c='.$id.'&amp;a=';
		if ($update && !$aug)
			echo 'update';
		elseif($aug)
			echo 'valider_aug&ac='.$credit;
		else
			echo 'add';
		
		echo '">';
	}

	// Crée le tableau
	echo '<table class="form">';
	
	// Crée l'en-tête du tableau
	echo '<thead><tr><td colspan="2">';
	if (!$editable || $update)
		echo 'Crédit n°'.$id;
	else
		echo 'Ajout d\'un crédit';
	echo '</td></tr></thead>';
	
	// Ecrit le pied du tableau
	echo '<tfoot><tr><td colspan="2">';
	// Soit le formulaire est éditable, on ajoute le bouton modifier
	if ($editable)
	{
		echo '<input type="submit" value="';
		if ($update && !$aug)
			echo 'Modifier';
		elseif($aug)
			echo 'valider';
		else
			echo 'Créer';
		echo '" />';
	}
	// Soit le formulaire n'est pas éditable, on ajoute quatre butons: Editer, Augmenter credit et Supprimer
	else
	{
		echo '<form method="get" action="">'
			.'<input type="hidden" name="page" value="gestioncredits" />'
			.'<input type="hidden" name="spage" value="credits" />'
			.'<input type="hidden" name="c" value="'.$id.'" />'
			.'<input type="hidden" name="a" value="edit" />'
			.'<input type="submit" value="Editer" />'
			.'</form>';
		echo '<form method="get" action="">'
			.'<input type="hidden" name="page" value="gestioncredits" />'
			.'<input type="hidden" name="spage" value="credits" />'
			.'<input type="hidden" name="c" value="'.$id.'" />'
			.'<input type="hidden" name="a" value="augmenter" />'
			.'<input type="submit" value="Augmenter du cr&eacute;dit au client" />'
			.'</form>';
		echo '<form method="get" action="">'
			.'<input type="hidden" name="page" value="gestioncredits" />'
			.'<input type="hidden" name="spage" value="credits" />'
			.'<input type="hidden" name="c" value="'.$id.'" />'
			.'<input type="hidden" name="a" value="del" />'
			.'<input type="submit" value="Supprimer" />'
			.'</form>';
	}
	echo '</td></tr></tfoot>';
	
	// Ajoute le contenu du tableau
	echo '<tbody>';
	
	if(!(($update && !$aug)||$aug))
	{
		$q_info_client = "SELECT numero,nom, prenom FROM identite ;";
		$result_infos  = @mysql_query($q_info_client);
		echo '<tr><td class="label">Client</td>';
		echo '<td class="input">';
		echo '<select name="id_client" id="id_client"  onchange="chargeInfoPara()">'
			.'<option value="aucun" selected="selected">-choisir un client-</option>';
			while($infos= @mysql_fetch_row($result_infos))
			{
				$num_client	   = $infos[0];
				$nom_client    = $infos[1];
				$prenom_client = $infos[2];
				echo '<option value="'.$num_client.'">'.$nom_client.' '.$prenom_client.'</option>';
			}
		echo '</select>';
		echo '</td></tr>';
			
	}else
	{
		insert_form_element('ID client', 'text', 'id_client', $id_client,$new);
	}
	if($aug)
	{
		insert_form_element('Montant du crédit : '.$credit.'   +', 'text', 'credit', 0, $editable);
		
		echo '<tr>
					<td class="label"><blink><font color="red" size="4">Type de prix :</font></blink></td>
					<td class="input"><input name="type_prix" type="radio" value="ht">H.T.&nbsp;
						<input name="type_prix" type="radio" value="ttc" checked="checked">T.T.C.
					</td>
			 </tr>';
	}
	else     
		insert_form_element('Montant du crédit', 'text', 'credit', $credit, $editable);
	
	if($new)
		echo '<tr>
					<td class="label"><blink><font color="red" size="4">Type de prix :</font></blink></td>
					<td class="input"><input name="type_prix" type="radio" value="ht">H.T.&nbsp;
						<input name="type_prix" type="radio" value="ttc" checked="checked">T.T.C.
					</td>
			 </tr>';
	echo '</tbody>';
	
	// Termine le tableau
	echo '</table>';
	
	// Termine le forumulaire englobant si le tout était éditable
	if ($editable)
		echo '</form>';
}

// Initialisation des variables
$id = 0;
$id_client = '';
$credit = 0;
$etat ='';
$mail = '';
$nom_client ='';
$prenom_client = ''; 

// Id Client
if (isset($_GET['c']))
	$c = (int)$_GET['c'];
else if (isset($c))
	unset($c);

// Action
if (isset($_GET['a']))
	$a = strtolower($_GET['a']);
else
	$a = 'list';

if ($a != 'list' && $a != 'details' && $a != 'edit' && $a != 'update' && $a != 'new' && $a != 'add' && $a != 'toggle' && $a != 'del' && $a != 'augmenter' && $a != 'valider_aug')
	$a = 'list';

if ($a == 'edit' || $a == 'augmenter')
	$editable = true;
else
	$editable = false;

if ($a == 'augmenter')
	$aug = true;
else
	$aug = false;
	
if ($a == 'new')
	$new = true;
else
	$new = false;

if ($a == 'del')
{
	// Test de validité beaucoup plus stricte pour la supression
	// Si la variable a est seulement définie en GET on demande confirmation
	// Si la variable a est aussi définie en POST, et que le numéro de client est présent, on supprime ce client
	if (isset($_POST['a']) && isset($_POST['c']) && $_POST['a'] == 'del' && $_POST['c'] > 0)
	{
		$c = (int)$_POST['c'];
	
		// Efface _toutes_ les données associées au client
		// Modifier cette requete en cas de mise à jour de la base de données
		mysql_query('DELETE FROM credit '
			.'WHERE numero = \''.$c.'\';');
		
		$r_lecli = @mysql_query(" SELECT idclient FROM credit WHERE  numero='$c'");
		$id_client = @mysql_fetch_row($r_lecli);
		//On garde la trace
		$query  = "INSERT INTO historique_credit2 (dateop,idclient,idcredit,typeoperation) "
			      ." VALUES ('".$auj_mysql."','".$id_client[0]."','".$c."','Suppression') ";
		mysql_query($query) or die ("Erreur : ".mysql_error());
		
		unset($c);
		
		$a = 'list';
	}
	else if (!isset($c) || $c <= 0) // Retour direct à la liste pour les numéros invalides
	{
		unset($c);
		$a = 'list';
	}
}
else if ($a == 'update' || $a == 'add' || $a == 'valider_aug')
{
	$id_client =(int) trim($_POST['id_client']);
	$credit =(double) trim($_POST['credit']);
	
	//Vérifier si le client n'a pas encore de credit (en cas d'ajout) ou s'il en a en cas d'update	
	$r_test1 = @mysql_query("SELECT * FROM credit WHERE  idclient='$id_client'");
	$nbr_test1 = @mysql_num_rows($r_test1);
	
	//Vérifie qu'il existe un client avec l'id donné
	$r_test2 = @mysql_query("SELECT * FROM identite WHERE  numero='$id_client'");
	$nbr_test2 = @mysql_num_rows($r_test2);
	
	if($nbr_test1)
		$credit_existe = true;
	else 
		$credit_existe = false;
		
	$errors = array();
	
	if( ($a != 'update') && ($a != 'valider_aug'))
	{
		if($credit_existe) $errors[] = 'Le client avec l\'ID  '.$id_client.' a déjà un credit!';
		if(!$nbr_test2) $errors[] = 'Il n\'existe pas de client avec l\'ID  '.$id_client.' !';
	}
	if (strlen($id_client) <= 0)
		$errors[] = 'ID client incorrect ou manquant';
		if (strlen($credit) <= 0)
		$errors[] = 'Credit incorrect ou manquant';
			
	if (count($errors) > 0) // Erreur
	{
		echo '<p class="error">';
		foreach ($errors as $error)
			echo htmlentities($error).'.<br />';
		echo '</p>';
		if ($a == 'update')
			$a = 'reedit';
		else if ($a == 'add')
			$a = 'new';
	}
	elseif ($a == 'update') // Ou modification
	{
		$r_lecli = @mysql_query(" SELECT idclient FROM credit WHERE  numero='$c'");
		$id_client = @mysql_fetch_row($r_lecli);
		$r_AncienCredit = @mysql_query("SELECT * FROM credit WHERE  idclient='".$id_client[0]."'");
		$ancien = @mysql_fetch_array($r_AncienCredit);
		
		//Mie à jour
		mysql_query('UPDATE credit SET '
			.'credit = "'.$credit.'" '
			.' WHERE numero = \''.$c.'\';');
			
		//On garde la trace
		$query  = "INSERT INTO historique_credit2 (dateop,idclient,idcredit,typeoperation,montant,ancienmontant,nouveaumontant) "
			      ." VALUES ('".$auj_mysql."','".$id_client[0]."','".$c."','Modification','".$credit."','".$ancien['credit']."','".$credit."') ";
		mysql_query($query) or die ("Erreur : ".mysql_error());
		$a = 'details';
	}
	elseif ($a == 'valider_aug') // Ou augmentattion
	{
		//On dertermine le véritable montant à ajouter
		if($type_prix=="ht") 
		{
			$lecredit = $credit ;
			$credit = $lecredit*1.196;
		}
		else if($type_prix=="ttc") $lecredit =  ($credit/1.196);
		//Ajout
		$a_c = $_GET['ac'];
		$new_val = (double)$lecredit + $a_c;
		mysql_query('UPDATE credit SET '
			.'credit = "'.$new_val.'"'
			.' WHERE numero = \''.$c.'\';');
		
		$r_lecli = @mysql_query(" SELECT idclient FROM credit WHERE  numero='$c'");
		$id_client = @mysql_fetch_row($r_lecli);
		//On garde la trace
		$query  = "INSERT INTO historique_credit2 (dateop,idclient,idcredit,typeoperation,montant,ancienmontant,nouveaumontant) "
			      ." VALUES ('".$auj_mysql."','".$id_client[0]."','".$c."','Ajout','".$lecredit."','".$a_c."','".$new_val."') ";
		mysql_query($query) or die ("Erreur : ".mysql_error());
		
		//ICI ON DOIT CRER UNE FACTURE PR LE CLIENT ET LUI ENVOYER UN MAIL
			//Crée la facture
			$query = " INSERT INTO facture (idclient, date, frais,paiement) ".
				" VALUES('".(int)$id_client[0]."', NOW(), '0', '2');";
			mysql_query($query) or die ("Erreur : ".mysql_error());
			$f =  mysql_insert_id();
			
			$r_elt = mysql_query("select id from element where nom = 'credit' and ref = 'credit' ;");
			$elt = @mysql_fetch_row($r_elt);
			//ajoute l'element
			$query = " INSERT INTO elementfacture (idfacture, idelement, quantite, prix) ".
				" VALUES('".(int)$f."', '".(int)$elt[0]."' , '1' , '".(float)$lecredit."');";
			mysql_query($query) or die ("Erreur : ".mysql_error());
			//envoie du mail
			$r_lecli = @mysql_query("SELECT * FROM identite WHERE  numero='".$id_client[0]."'");
			$lecli = @mysql_fetch_array($r_lecli);
			
			$entete  = 'MIME-Version: 1.0' . "\r\n";
			$entete .= 'Content-type: text/html; charset=iso-8859-1'. "\r\n";
			$entete .= 'From: "KALONJI Tony" <info@kt-centrex.com>\n'; 
			$entete .= 'Reply-to: "KALONJI Tony" <info@kt-centrex.com>\n'; 
									
			$subject = 'ktis : Info credit ';
			
			$message='<html><head><title></title></head><body>';
			$message.='Bonjour '.$lecli['prenom'].' '.$lecli['nom'].',<br /><br />';
			$message.='Nous venons de cr&eacute;diter votre compte de '.$lecredit.'€ HT, soit '.$credit.'€ TTC<br />';
			$message.='Votre nouveau solde est actuellement de '.$new_val.' €!<br />';
			$message.='Vous trouverais une facture relative sur votre espace d\'administration kt-centrex, n° de facture : '.$f.'<br /><br />';
			$message.='Merci de votre confiance!<br /><br />';
			$message.='Cordialement!<br /><br />';
			$message.='-- <br> KALONJI Tony  - Ktis   - <a href="http://www.ktis-fr.com">http://www.ktis-fr.com</a><br>'.
						'Tel: 170 819 329 - skype: tommmmy991<br><br>

						Location de serveurs dédiés<br>
						Infogérance et consulting<br>
						Opérateur télécom voip<br>
						Serveurs de jeux<br></body></html>';
			if($lecli['email'])
			$rps = mail($lecli['email'],$subject,$message,$entete);
			if($rps) echo '<font color="green" size="5">Un mail a &eacute;t&eacute; envoi&eacute; au client &agrave; l\'adresse : '.$lecli['email'].'!!!</font><br>';
			else  echo '<font color="red" size="5">Le mail n\'a pas p&uclirc; &ecirc;tre envoi&eacute; au client!!!</font><br>';
		$a = 'details';
	}
	else // Ou insertion
	{
		//On dertermine le véritable montant à attribuer
		if($type_prix=="ht") 
		{
			$lecredit = $credit ;
			$credit = $lecredit*1.196;
		}
		else if($type_prix=="ttc") $lecredit =  ($credit/1.196);
		// Crée un credit
		mysql_query('INSERT INTO credit (idclient, credit) '
			.'VALUES("'.$id_client.'"'
			.', "'.$lecredit.'");');
		$idcredit = mysql_insert_id();
		
		//On garde la trace
		$query  = "INSERT INTO historique_credit2 (dateop,idclient,idcredit,typeoperation,montant,ancienmontant,nouveaumontant) "
			      ." VALUES ('".$auj_mysql."','".$id_client."','".$idcredit."','Creation','".$lecredit."','0','".$lecredit."') ";
		mysql_query($query) or die ("Erreur : ".mysql_error());
		
		//Pour permettre d'afficher une conso par jour
		/*$hier = date('Y-m-d', date_ilya_njours(1, getdate(),0));
		$query  = "INSERT INTO historique_credit (datearchive,idcredit,credit,idclient) "
			      ."VALUES ('".$hier."','".$idcredit."','".$credit."','".$id_client."') ";
		mysql_query($query) or die ("Erreur : ".mysql_error());*/
		
		//ICI ON DOIT CRER UNE FACTURE PR LE CLIENT ET LUI ENVOYER UN MAIL
			//Crée la facture
			$query = " INSERT INTO facture (idclient, date, frais,paiement) ".
				" VALUES('".(int)$id_client."', NOW(), '0', '2');";
			mysql_query($query) or die ("Erreur : ".mysql_error());
			$f =  mysql_insert_id();
			
			$r_elt = mysql_query("select id from element where nom = 'credit' and ref = 'credit' ;");
			$elt = @mysql_fetch_row($r_elt);
			//ajoute l'element
			$query = " INSERT INTO elementfacture (idfacture, idelement, quantite, prix) ".
				" VALUES('".(int)$f."', '".(int)$elt[0]."' , '1' , '".(float)$lecredit."');";
			mysql_query($query) or die ("Erreur : ".mysql_error());
			//envoie du mail
			$r_lecli = @mysql_query("SELECT * FROM identite WHERE  numero='".$id_client."'");
			$lecli = @mysql_fetch_array($r_lecli);
			
			$entete  = 'MIME-Version: 1.0' . "\r\n";
			$entete .= 'Content-type: text/html; charset=iso-8859-1'. "\r\n";
			$entete .= 'From: "KALONJI Tony" <info@kt-centrex.com>\n'; 
			$entete .= 'Reply-to: "KALONJI Tony" <info@kt-centrex.com>\n'; 
									
			$subject = 'ktis : Info credit ';
			
			$message='<html><head><title></title></head><body>';
			$message.='Bonjour '.$lecli['prenom'].' '.$lecli['nom'].',<br /><br />';
			$message.='Nous venons de cr&eacute;diter votre compte de '.$lecredit.'€ HT, soit '.$credit.'€ TTC<br />';
			$message.='Votre nouveau solde est actuellement de '.$lecredit.' €!<br />';
			$message.='Vous trouverez une facture relative sur votre espace d\'administration kt-centrex, n° de facture : '.$f.'<br /><br />';
			$message.='Merci de votre confiance!<br /><br />';
			$message.='Cordialement!<br /><br />';
			$message.='-- <br> KALONJI Tony  - Ktis   - <a href="http://www.ktis-fr.com">http://www.ktis-fr.com</a><br>'.
						'Tel: 170 819 329 - skype: tommmmy991<br><br>

						Location de serveurs dédiés<br>
						Infogérance et consulting<br>
						Opérateur télécom voip<br>
						Serveurs de jeux<br></body></html>';
			if($lecli['email'])
			$rps = mail($lecli['email'],$subject,$message,$entete);
			if($rps) echo '<font color="green" size="5">Un mail a &eacute;t&eacute; envoi&eacute; au client &agrave; l\'adresse : '.$lecli['email'].'!!!</font><br>';
			else  echo '<font color="red" size="5">Le mail n\'a pas p&uclirc; &ecirc;tre envoi&eacute; au client!!!</font><br>';
		
		// On arrive sur la page de détails
		$a = 'list';
		unset($c);
	}
}

// Choisit un titre à la page en fonction de l'affichage
if ($a == 'list')
	$title = 'Liste des crédits';
else if ($a == 'new')
	$title = 'Ajout d\'un nouveau credit';
else
{
	
	if ($a == 'edit' || $a == 'reedit')
		$title = 'Edition ';
	elseif ($a == 'augmenter')
		$title = 'Augmenter ';
	else
		$title = 'Détails ';
	
	if (isset($c))
	{		
		if ($a == 'augmenter') 
		{
			$r_client  = @mysql_query("SELECT idclient FROM credit WHERE  numero='".$c."'");
			$row_ligne = @mysql_fetch_row($r_client);
			$title .= 'du crédit au client n°'.$row_ligne[0];
		}
		else $title .= 'du crédit n°'.$c;
	}
	else
		$title .= 'des crédits';
}

if ($a == 'reedit')
{
	$id = $c;
	generate_credit_form(true, true,$new,$aug);
}
else if ($a == 'new')
	generate_credit_form(true, false,$new,$aug);
else if ($a == 'del')
{
	$title = 'Suppression d\'un crédit';
	
	// Affiche simplement un message dissuasif
	echo '<div class="warning">'
		.'<div class="title">Attention !</div>'
		.'<p>Vous &ecirc;tes sur le point de supprimer le credit numéro '.$c.'.<br />'
		.'Cette op&eacute;ration est irr&eacute;versible.<br />'
		.'&Ecirc;tes vous certain de vouloir continuer ?</p>'
		.'<div class="buttons">'
		.'<form method="post" action="?page=gestioncredits&amp;spage=credits&amp;a=del">'
		.'<input type="hidden" name="a" value="del" />'
		.'<input type="hidden" name="c" value="'.$c.'" />'
		.'<input type="submit" value="Oui" />'
		.'</form>'
		.'<form method="get" action="">'
		.'<input type="hidden" name="page" value="gestioncredits" />'
		.'<input type="hidden" name="spage" value="credits" />'
		.'<input type="hidden" name="a" value="details" />'
		.'<input type="hidden" name="c" value="'.$c.'" />'
		.'<input type="submit" value="Non" />'
		.'</form>'
		.'</div>'
		.'</div>';
}
else
{
	if ($a == 'list' || !isset($c))
	{
		$r = mysql_query('SELECT COUNT(*) FROM credit;');
		if ($row = mysql_fetch_row($r))
			$page_count = page_count($row[0]);
		else
			$page_count = 1;
		$page = page_get($page_count);
		$page_start = ($page - 1) * DEFAULT_PAGE_SIZE;
		
		$navbar = '<div class="navbar">'
			.'<div class="action"><a href="?page=gestioncredits&amp;spage=credits&amp;a=new">Cr&eacute;er un nouveau cr&eacute;dit</a></div>'
			.'<div class="action">'
			.'<form method="get" action="">'
			.'<input type="hidden" name="page" value="gestioncredits" />'
			.'<input type="hidden" name="spage" value="credits" />'
			.'<input type="hidden" name="a" value="details" />'
			.'<input type="hidden" name="search" value="search" />'
			.'Voir le cr&eacute;dit: '
			.'<input type="text" size="4" name="c" value="'.(isset($c)?$c:'').'" />'
			.'<input type="submit" value="Ok" />'
			.'</form>'
			.'</div>'
			.'<div class="pages">Page: '.page_build_menu('?page=gestioncredits&amp;spage=credits&p=', $page, $page_count).'</div>'
			.'<hr />'
			.'</div>';
		
		// On doit prendre en compte le numéro de page
		$paging = true;
	}
	else
	{
		// Pas de barre de navigation
		$navbar = '';
		
		// On ne doit pas prendre en compte le numéro de page
		$paging = false;
	}
	
	$credit_query = 'SELECT numero, idclient, credit, etat, mail '
		.' FROM credit ';

	if (isset($c))
		$credit_query .= 'WHERE numero = '.$c;
	
	if ($paging)
		$credit_query .= 'order by credit desc LIMIT '.$page_start.','.DEFAULT_PAGE_SIZE;
	
	$credit_query .= ';';
	
	if ($r = mysql_query($credit_query))
	{
		echo $navbar;
		
		if ($a == 'list')
			echo '<table class="list"><thead><tr>'
				.'<td>Id</td><td>ID client</td><td>Nom client</td><td>Prenom client</td><td>Cr&eacute;dit</td><td>Action</td>'
				.'</tr></thead><tbody>';
		while ($row = mysql_fetch_row($r))
		{
			$id = (int)$row[0];
			$id_client = $row[1];
			$credit = $row[2];
			$etat = $row[3];
			$mail = $row[4];
			
			//Recupère les infos sur le client (Permet au user de pas se tromper, car le numeros ne sont pas mneumotechniques)
			$q_info_client = "SELECT nom, prenom FROM identite WHERE  numero='$id_client'";
			$result_infos  = @mysql_query($q_info_client);
			$infos         = @mysql_fetch_row($result_infos);
			$nom_client    = $infos[0];
			$prenom_client = $infos[1];
			
			if ($a == 'list')
			{
				echo '<tr class="active"><td class="id">'.$id.'</td>';
				echo '<td>'.htmlentities($id_client).'</td>';
				echo '<td>'.htmlentities($nom_client).'</td>';
				echo '<td>'.htmlentities($prenom_client).'</td>';
				echo '<td>'.htmlentities($credit." €").'</td>';
				echo '<td class="action">';
				echo '<form method="get" action="">'
					.'<input type="hidden" name="page" value="gestioncredits" />'
					.'<input type="hidden" name="spage" value="credits" />'
					.'<input type="hidden" name="c" value="'.$id.'" />'
					.'<input type="hidden" name="a" value="details" />'
					.'<input type="submit" value="D&eacute;tails" />'
					.'</form>'
					.'<form method="get" action="">'
					.'<input type="hidden" name="page" value="gestioncredits" />'
					.'<input type="hidden" name="spage" value="historique_de_credits" />'
					.'<input type="hidden" name="idclient" value="'.$id_client.'" />'
					.'<input type="submit" value="Historique" />'
					.'</form>';
				echo '</td></tr>';
			}
			else
				generate_credit_form($editable, true,$new,$aug);
		}
		if ($a == 'list')
			echo '</tbody></table>';
		
		echo $navbar;
	}
	else
		echo '<p class="error">Erreur lors de la requête MySQL.</p>';
}
?>