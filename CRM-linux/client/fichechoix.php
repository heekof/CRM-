<head>
<style>

a{color:#996600}

</style>
</head>
<?php
if($centrex2)
{
    // http://localhost/csboost7/panel/panelmembre.php
    //header("Location: http://localhost/csboost7/panel/panelmembre.php");
}
else
{
	// header("Location: http://admin.kt-centrex.com/login.php");
	header("Location: ficheclient.php");
}

require("connecte/base.php");

$rEtat = mysql_query(" select ca.etat,ca.nomchamp from preview AS ca, crm AS c where ca.nomchamp=c.nomcampagne AND c.numero='$centrex2'");
$etat = mysql_fetch_row($rEtat);

include("menu_haut.php");
?>

<table border="0" align="center" width="90%" background="images/bg-main-bottom.gif">

<table border="0"  align="center" width="90%" >
<tr> <td align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

   <br>  <br>
</td>

</tr>

<?php

  // print(" <br> page $page <br> ");
if($etat[0]=='ok')
{
	if(!isset($page)) $page="fichechoix2";
	$page= $lurl.$page;

	if(file_exists($page.".php")){

		include($page.".php");
	}
	else {
		
		echo "Erreur 404 la page ou le fichier demand&eacute; n'a pas &eacute;t&eacute; trouv&eacute; sur le serveur.";
	}
}
else
{
	echo '<br><center><font color="red" size="6" weight="bold">Votre campagne "<i>'.$etat[1].'</i>" a &eacute;t&eacute; desactiv&eacute;e!</font></center>';
}
?>

 </td> </tr>

</table>

  </tr>
  </td>
  </table>
