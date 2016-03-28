<?php
$c=$_GET['c'];
$red = mysql_query("SELECT * FROM credit WHERE  idclient='$c'");
$total = mysql_fetch_array($red);
while($r= mysql_fetch_array($total))
            { 
             echo  $num=$r['numero'];
			echo   $credit=$r['credit'];
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
		echo '<table>';
	