<html>
<?php //require("traitement_argument.php");
require("connecte/base.php"); 
if($p==NULL) $p=1;


?>
<head>
<title>Questions avec arguments</title>
</head>
<body>

</body>

<?php //ce code doit etre dans le fichier traitement_argument !!
 //commandes sql pour recuperer la premiere question
$query1 = " SELECT  commentaire ";
$query1 .= "FROM  argument  ";
$query1 .= "WHERE numcli='1' ";

$mysql_result = mysql_query($query1) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
    $Targument = ($row["commentaire"]);
}

?>
<!-- form principale -->
<form method="POST" action="arguments.php"> 
<!-- declaration du label d'affichage  -->
<input type="label"  name="label_texte" value=<?php echo $Targument; ?> > <br>
<!-- declaration des boutons  -->
<input type="submit" name="bouton1" value="oui">
<input type="submit" name="bouton1" value="non">
<input type="submit" name="bouton1" value="indecie">
<!-- variable d'incrementation -->
<input type="hidden" id="p" name="p" value=<?php echo $p+1;?> >
</form>
<?php
//test valeur de p :
echo '<br> la valeur de p='.$p;
//si je clique sur oui 
if($bouton1=="oui")
{echo '<br> vous avez selectionnez oui <br>' ;
$query1 = " SELECT  commentaire ";
$query1 .= "FROM  argument  ";
$query1 .= "WHERE reference='oui' ";

$mysql_result = mysql_query($query1) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
    $Targument = ($row["commentaire"]);
}
}
//si je clique sur non 
if($bouton1=="non")
echo '<br> vous avez selectionnez non <br>' ;
// sinon
if($bouton1=="indecie")
echo '<br> vous avez selectionnez indecie <br>' ;
 //commandes sql pour recuperer les questions à afficher






mysql_close();

?>
</html>