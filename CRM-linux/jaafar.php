
<head>
<script>
function pop() {
window.open('arbre.php','height="500",width="500",top="500",left="500",resible=no');
}
</script>
</head>


<?php require("connecte/base.php"); 

//$centrex=1;

$p=$xy;

if($xy==NULL) $p=1;

// si je ne fais pas de retour 
if(!isset($ret1) && $lolo!=1  )
{//$test1.=$mavar4;

}



$Tnumero  = array() ;
    $Treference=array();

 


// declaration et initialisation de variables
//if($p==NULL) {
  //              $p=1; $tab=array();
			 //}
			 
// quand on click sur le bouton retour 			 

?>
<BR><BR>
<p align="center"><img align="center" src="info2.png" ></p>
<?php
if(isset($ret1) )
{
if($xret>=1)
{
//a chaque fois que je fais un retour j'efface 3 caracteres


$test1=substr($test1, 0, -3);
//echo 'caractere supprimés ! '.$test1;

// decrementation de p 
$p=$xret;
$numero--;
//echo '<br> je suis le code retour <br>';
/* code retour */
if($p==1){
$queryr = " SELECT  * ";
$queryr .= "FROM  argument  ";
$queryr .= "WHERE    numcli='$centrex' and niveau='$p'  ";
$Vheritager="";
}

else 
{
$query11 = " SELECT  * ";
$query11 .= "FROM  argument  ";
$query11 .= "WHERE    numcli='$centrex' and  reference='$test1'  "; //niveau='$p' 

//requete pour afficher le commentaire precedent
$test3=substr($test1, 0, -3);
$queryr = " SELECT  * ";
$queryr .= "FROM  argument  ";
$queryr .= "WHERE    numcli='$centrex' and reference='$test3' ";

$mysql_result11 = mysql_query($query11) or die ("Erreur : ".mysql_error());
while($row11 = mysql_fetch_array($mysql_result11))
{

    $Vheritage = ($row11["commentaire"]);
	
}

$mysql_resultr = mysql_query($queryr) or die ("Erreur : ".mysql_error());
while($rowr = mysql_fetch_array($mysql_resultr))
{

    $Vheritager = ($rowr["commentaire"]);
	
}


}
$mysql_resultr = mysql_query($queryr) or die ("Erreur : ".mysql_error());
while($rowr = mysql_fetch_array($mysql_resultr))
{

    $Vheritager = ($rowr["commentaire"]);
	
}

$monretour=1;
// commentaire precedent 





}
else echo "<br> vous ne pouvez pas aller au dela du niveau 0 !";
/* fin code retour */
}
// si je ne suis pas en retour 
else {

{
require("memorisation.php");
}
?>

<?php


}

//affichage x et p
//echo '<br> variable x='.$x.'p='.$p;


// boucle principale
for ($j=0; $j<1; $j++){




?>
<table  align="right" border="0" width="100%"  height="100%">
<!-- form principale -->
<?php   include("maform1.php"); ?>

<?php 
//echo "<br><br> La variable que je viens de creer =".$test1.'<br><br>' ;


/*
//+++++++++++++++++++++++++++++++++++++++++++ refe ici 

// 'l' indice de reponse
$l=$p-1;

$vari="clik";
// 'oui' ou 'non'
$reponse=${$vari.$l};
// condition de reponse
// mavar4 contient la reference !
if($reponse=="oui") {
	$mavar4 ="question".$l;
       $mavar4.=".oui";
	   }
else if($reponse=="non"){
$mavar4="question".$l;
$mavar4.=".non";
}
else if($reponse=="indecie"){
$mavar4="question".$l;
$mavar4.=".jesaispas";
}
//else echo 'erreur reference non modifiée !';
//+++++++++++++++++++++++++++++++++++++++++++ refe ici  */
 
?>
<?php if($p!=1) {//!(isset($ret1) && $x==0)){ ?>
<!-- deuxieme form pour le retour -->
<?php include("maform2.php"); ?>
</table>

<?php } ?>
<?php



//echo "<br> mavar4=".$mavar4."<br>";

// mavar3 contient le commentaire
$e=$p-1;
$mavar="entry";
$mavar2="question";
$mavar3=${$mavar.$e};
//echo '<br>  p='.$p;



////////////////////





$query1 = " SELECT  commentaire ";
$query1 .= "FROM  argument  ";
$query1 .= "WHERE reference='$mavar4' ";

$mysql_result = mysql_query($query1) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
    $Targument = ($row["commentaire"]);
}
///////


///////

//require("test_identique.php");

// je mets le commentaire dans la base si il n'est pas null ou vide !
// je met Vheritage dans la base si ce dernier est null !
if( ( $mavar3!="" || $mavar3!= NULL ) && ($Vheritage==""  || $Vheritage==NULL ) && ($Vcommentairey==NULL) )
{

//echo '<br> je rentre dans la condition est:  Vcommentairey:'.$Vcommentairey.'<br>';

$l=$p-1;
$test1=substr($test1, 0, -3);
$query ="INSERT INTO argument (numcli,commentaire,reference,niveau) ";
$query .=" VALUES ('$centrex','$mavar3','$test1','$l')";
$result = mysql_query($query) or die ("Erreur : ".mysql_error()) ;
echo '<br> ajout avec succès <bsr>';


// condition sans retour
//echo "<br><br> LE RETOUR AVANT LABOUCLE =".$lolo.'<br><br>' ;
if($lolo!=1)
{
//ajout de l heritage
require("sans_ret.php");


}
else{
require("ret.php");

//echo '<br> Je N UTILISE PAS LE REQUIRE !! <br>';
}


}
else '<br> erreur ajout impossible';

//************************La modification***********************//
// pour le modification $Vheritage==commentaire est non null !
if( ( $mavar3!="" || $mavar3!= NULL ) && ($Vheritage!=""  || $Vheritage!=NULL ) )
{
require("modification.php");

}
//require("arbre.php");
mysql_close();
}

?>
