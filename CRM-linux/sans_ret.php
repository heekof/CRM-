<?php
$a = "0";

// rajout de l'heritage la premiere fois

$query12 = " SELECT * ";
$query12 .= "FROM  argument  ";
$query12 .= "WHERE numcli='$centrex'";

$mysql_result3 = mysql_query($query12) or die ("Erreur : ".mysql_error());
while($row2 = mysql_fetch_array($mysql_result3))
{

    $Vreference = ($row2["reference"]);
	$Vnumero = ($row2["numero"]);
    $Tnumero[$a] = $Vnumero ;
    $Treference[$a] = $Vreference ;


$a++;
	
	}

//  mmmmmm
	
$T = $a - 2; 
$TT = $a - 1 ;


// condition avec retour

//echo '///////////'.$a.'mmmmmm';
	

$n=$p-1;	

// ici j utilise up
{

{$query2 ="UPDATE argument SET heritage='$Treference[$T]' WHERE numero='$Tnumero[$TT]' "; 
$result2 = mysql_query($query2);
}
}
?>