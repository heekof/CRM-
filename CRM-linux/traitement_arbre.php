<?php
//$centrex=1;
require("connecte/base.php"); 



//$test1="";

// concatenation de test1 grace � la variable contenaire -->
$test1=$contenaire;
// detection du bouton retour 
if($retour=="retour")
{$test1=substr($test1, 0, -6);
$contenaire=$test1;
$temoin=$temoin+1;
}
//if($temoin==1)$contenaire=substr($test1, 0, -6);


//*****************ci dessous code de recherche mysql des valeurs que l'on doit afficher **********************//

//recherche de vheritage 
$var=$test1;
$tmp=substr($var, 0, -3);
$testoui=$test1."oui";
$queryoui = " SELECT  commentaire ";
$queryoui .= "FROM  argument  ";
$queryoui .= "WHERE numcli='$centrex' and reference='$tmp' ";

$mysql_resultoui = mysql_query($queryoui) or die ("Erreur : ".mysql_error());
while($rowoui = mysql_fetch_array($mysql_resultoui))
{
    $Vheritager = ($rowoui["commentaire"]);
}

// recherche du oui 
$testoui=$test1."oui";
$queryoui = " SELECT  commentaire ";
$queryoui .= "FROM  argument  ";
$queryoui .= "WHERE numcli='$centrex' and reference='$testoui' ";

$mysql_resultoui = mysql_query($queryoui) or die ("Erreur : ".mysql_error());
while($rowoui = mysql_fetch_array($mysql_resultoui))
{
    $Voui = ($rowoui["commentaire"]);
}
// recherche du non
$testnon=$test1."non";
$querynon = " SELECT  commentaire ";
$querynon .= "FROM  argument  ";
$querynon .= "WHERE  numcli='$centrex' and reference='$testnon' ";

$mysql_resultnon = mysql_query($querynon) or die ("Erreur : ".mysql_error());
while($rownon = mysql_fetch_array($mysql_resultnon))
{
    $Vnon = ($rownon["commentaire"]);
}
// recherche du indecis 
$testind=$test1."ind";
$queryind = " SELECT  commentaire ";
$queryind .= "FROM  argument  ";
$queryind .= "WHERE numcli='$centrex' and  reference='$testind' ";

$mysql_resultind = mysql_query($queryind) or die ("Erreur : ".mysql_error());
while($rowind = mysql_fetch_array($mysql_resultind))
{
    $Vind = ($rowind["commentaire"]);
}
// recherche actuel

$query = " SELECT  commentaire ";
$query .= "FROM  argument  ";
$query .= "WHERE  numcli='$centrex' and reference='$test1' ";

$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
    $Vactuel = ($row["commentaire"]);
}
// recherche du oui oui  
$testouioui=$test1."ouioui";
$queryouioui = " SELECT  commentaire ";
$queryouioui .= "FROM  argument  ";
$queryouioui .= "WHERE  numcli='$centrex' and reference='$testouioui' ";

$mysql_resultouioui = mysql_query($queryouioui) or die ("Erreur : ".mysql_error());
while($rowouioui = mysql_fetch_array($mysql_resultouioui))
{
    $Vouioui = ($rowouioui["commentaire"]);
}
// recherche du oui non
$testouinon=$test1."ouinon";
$queryouinon = " SELECT  commentaire ";
$queryouinon .= "FROM  argument  ";
$queryouinon .= "WHERE  numcli='$centrex' and reference='$testouinon' ";

$mysql_resultouinon = mysql_query($queryouinon) or die ("Erreur : ".mysql_error());
while($rowouinon = mysql_fetch_array($mysql_resultouinon))
{
    $Vouinon = ($rowouinon["commentaire"]);
}
// recherche du oui ind
$testouiind=$test1."ouiind";
$queryouiind = " SELECT  commentaire ";
$queryouiind .= "FROM  argument  ";
$queryouiind .= "WHERE numcli='$centrex' and reference='$testouiind' ";

$mysql_resultouiind = mysql_query($queryouiind) or die ("Erreur : ".mysql_error());
while($rowouiind = mysql_fetch_array($mysql_resultouiind))
{
    $Vouiind = ($rowouiind["commentaire"]);
}
// recherche du non oui
$testnonoui=$test1."nonoui";
$querynonoui = " SELECT  commentaire ";
$querynonoui .= "FROM  argument  ";
$querynonoui .= "WHERE  numcli='$centrex' and reference='$testnonoui' ";

$mysql_resultnonoui = mysql_query($querynonoui) or die ("Erreur : ".mysql_error());
while($rownonoui = mysql_fetch_array($mysql_resultnonoui))
{
    $Vnonoui = ($rownonoui["commentaire"]);
}
// recherche du non non
$testnonnon=$test1."nonnon";
$querynonnon = " SELECT  commentaire ";
$querynonnon .= "FROM  argument  ";
$querynonnon .= "WHERE  numcli='$centrex' and reference='$testnonnon' ";

$mysql_resultnonnon = mysql_query($querynonnon) or die ("Erreur : ".mysql_error());
while($rownonnon = mysql_fetch_array($mysql_resultnonnon))
{
    $Vnonnon = ($rownonnon["commentaire"]);
}
// recherche du non ind
$testnonind=$test1."nonind";
$querynonind = " SELECT  commentaire ";
$querynonind .= "FROM  argument  ";
$querynonind .= "WHERE numcli='$centrex' and reference='$testnonind' ";

$mysql_resultnonind = mysql_query($querynonind) or die ("Erreur : ".mysql_error());
while($rownonind = mysql_fetch_array($mysql_resultnonind))
{
    $Vnonind= ($rownonind["commentaire"]);
}
// recherche du indecis oui 
$testindoui=$test1."indoui";
$queryindoui = " SELECT  commentaire ";
$queryindoui .= "FROM  argument  ";
$queryindoui .= "WHERE numcli='$centrex' and reference='$testindoui' ";

$mysql_resultindoui = mysql_query($queryindoui) or die ("Erreur : ".mysql_error());
while($rowindoui = mysql_fetch_array($mysql_resultindoui))
{
    $Vindoui = ($rowindoui["commentaire"]);
}
// recherche du indecis non 
$testindnon=$test1."indnon";
$queryindnon = " SELECT  commentaire ";
$queryindnon .= "FROM  argument  ";
$queryindnon .= "WHERE numcli='$centrex' and reference='$testindnon' ";

$mysql_resultindnon = mysql_query($queryindnon) or die ("Erreur : ".mysql_error());
while($rowindnon = mysql_fetch_array($mysql_resultindnon))
{
    $Vindnon = ($rowindnon["commentaire"]);
}
// recherche du indecis ind 
$testindind=$test1."indind";
$queryindind = " SELECT  commentaire ";
$queryindind .= "FROM  argument  ";
$queryindind .= "WHERE numcli='$centrex' and reference='$testindind' ";

$mysql_resultindind = mysql_query($queryindind) or die ("Erreur : ".mysql_error());
while($rowindind = mysql_fetch_array($mysql_resultindind))
{
    $Vindind = ($rowindind["commentaire"]);
}






mysql_close();
?>