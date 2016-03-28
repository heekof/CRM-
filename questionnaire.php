<?php require("connecte/base.php"); 
//declaration des variables 

$centrex=5;
if($p==NULL) 
	$p=1;

// quand on click sur le bouton retour 			 
if(isset($ret1))// decrementation de p    
    $p=$x;

//affichage x et p
echo '<br> variable x='.$x.'p='.$p;

// indicateur de niveau :
echo '<br> Niveau :'.$p;

?>
<table>
<!-- form principale -->
<form method="POST" action="questionnaire.php"> 
<!-- declaration de p de type hidden pour la sauvegarde et l'envoi -->
<input type="hidden" id="p" name="p" value=<?php echo $p+1;?> >
<!-- affichage de la requete mysql -->
<tr>
<td>
<input type="text" name="<?php echo 'entry'.$p; ?>" value="" >
</td>
<!-- variable i -->


<td>
<!-- deux boutons oui et non leurs noms est clicki --> 
<input type="submit" name=<?php echo 'clik'.$p; ?> value="oui">
<input type="submit" name=<?php echo 'clik'.$p; ?> value="non">
<!-- compte le nombre de reponses -->
<input type="submit" name=<?php echo 'clik'.$p; ?> value="indecie" >
<!-- envoie de la variable reference -->
<input type="hidden" name="reference" value="<?php echo $_POST['reference']; ?>" >


</td>
 </tr>

</form>
</table>

<?php

// 'l' indice de reponse
$i=$p-1;
$vari="clik";
// 'oui' ou 'non'
$reponse=${$vari.$i};
// condition de reponse
// reference contient la reference !
if($reponse=="oui") {
	$reference ="question".$i;
       $reference.=".oui";
	   }
else if($reponse=="non"){
$reference="question".$i;
$reference.=".non";
}
else if($reponse=="indecie"){
$reference="question".$i;
$reference.=".jesaispas";
}
echo "<br> La reference est =".$reference."<br>";

$e=$p-1;
$var_tmp="entry";
$commentaire=${$var_tmp.$e};

if($commentaire!="" || $commentaire!= NULL)
{

$query ="INSERT INTO argument (numcli,commentaire,reference) ";
$query .=" VALUES ('$centrex','$commentaire','$reference')";
$result = mysql_query($query) or die ("Erreur : ".mysql_error()) ;

echo 'commentaire '.$commentaire.'rajouté avec succes';
}
//else echo 'attention commentaires null ou vides  !!';








mysql_close();





?>

