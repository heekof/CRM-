<?php
$c=$_GET['c'];
$red = mysql_query("SELECT * FROM credit WHERE  idclient='$c'");
$total = mysql_fetch_array($red);
while($r= mysql_fetch_array($total))
            { 
             echo  $num=$r['numero'];
			echo   $credit=$r['credit'];
			  }
	// Cr�e le tableau
	echo '<table class="form">';
	
	// Cr�e l'en-t�te du tableau
	echo '<thead><tr><td colspan="2">';
	if (!$editable || $update)
		echo 'Cr�dit n�'.$id;
	else
		echo 'Ajout d\'un cr�dit';
	echo '</td></tr></thead>';
	
	// Ecrit le pied du tableau
	echo '<tfoot><tr><td colspan="2">';
	// Soit le formulaire est �ditable, on ajoute le bouton modifier
	if ($editable)
	{
		echo '<input type="submit" value="';
		if ($update && !$aug)
			echo 'Modifier';
		elseif($aug)
			echo 'valider';
		else
			echo 'Cr�er';
		echo '" />';
	}
	// Soit le formulaire n'est pas �ditable, on ajoute quatre butons: Editer, Augmenter credit et Supprimer
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
	