
<?php




if($centrex)
	{
          // http://localhost/csboost7/panel/panelmembre.php
          //header("Location: http://localhost/csboost7/panel/panelmembre.php");
	}
else
 {
 // header("Location: http://admin.kt-centrex.com/login.php");
 header("Location: http://localhost/panel-centrex/login.php");
 }
 
//echo '<br> Pcrm ='.$p;
$argument_crm=$argument;// jaafar
$xy=$p;// jaafar
 
 

 
 
 
 ?>

 
 
<html>
<head>
<script type="text/javascript" src="js/js.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/effects.js"></script>
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css"></style>
</head>
<?php
require("connecte/base.php");

$query = " SELECT  * ";
$query .= " FROM identite  where numero = '$centrex' ";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{

    $credit = ($row["credit"]) ;
}

//Pour la navigation entre les pages du CRM ( Système de Gestion de la Relation Client : Customer Relationship Management)
$nav = array();

$nav[0] = 	array(nompage=>'Outil crm',page=>'crm',lien=>'panel.php?page=crm') ;
$nav[1] = 	array(
				array(nompage=>'Activation d’émission d\'appel',page=>'preview',lien=>'crm1.php?page=preview',prev=>'crm'),
				array(nompage=>'Import & Base & Gestion',page=>'import',lien=>'crm1.php?page=import',prev=>'crm'),
				array(nompage=>'Montée de fiche (appel entrant)',page=>'sgrc',lien=>'crm1.php?page=sgrc',prev=>'crm'),
				array(nompage=>'Administration Compte crm',page=>'gcode',lien=>'crm1.php?page=gcode',prev=>'crm'),
				array(nompage=>'Enregistrement & Ecoute',page=>'ecoute',lien=>'crm1.php?page=ecoute',prev=>'crm')
			) ;
$nav[2] =	array(
				array(nompage=>'Création d\'une campagne',page=>'activation_prev',lien=>'crm1.php?page=activation_prev',prev=>'preview'),
				array(nompage=>'Activer/Desactiver/Effacer une campagne',page=>'mpredictif',lien=>'crm1.php?page=mpredictif',prev=>'preview'),
				array(nompage=>'Ajout de commerciaux',page=>'ajout_comcial',lien=>'crm1.php?page=ajout_comcial',prev=>'preview'),
				array(nompage=>'Ajout de commerciaux',page=>'ajout_comcioDone',lien=>'crm1.php?page=ajout_comcioDone',prev=>'preview'),
				array(nompage=>'Liste des commerciaux',page=>'liste_comcio_camp',lien=>'crm1.php?page=liste_comcio_camp',prev=>'preview'),
				array(nompage=>'Modification des infos d\'un commercial',page=>'modif_info_comcial',lien=>'crm1.php?page=modif_info_comcial',prev=>'preview'),
				array(nompage=>'Liste des rendez-vous des commerciaux',page=>'rdv',lien=>'crm1.php?page=rdv',prev=>'preview'),
				array(nompage=>'Modification d\'un rendez-vous',page=>'rdv_modifs',lien=>'crm1.php?page=rdv_modifs',prev=>'preview'),
				array(nompage=>'Modification de base',page=>'basemodif',lien=>'crm1.php?page=basemodif',prev=>'import'),
				array(nompage=>'Configuration des champs de la base externe',page=>'import_csv_conf',lien=>'crm1.php?page=import_csv_conf',prev=>'import'),
				array(nompage=>'Importation de la base externe',page=>'import0',lien=>'crm1.php?page=import0',prev=>'import'),
				array(nompage=>'Enregistrement de la base externe',page=>'import1',lien=>'crm1.php?page=import1',prev=>'import'),
				array(nompage=>'Importation base interne',page=>'importeinterne',lien=>'crm1.php?page=importeinterne',prev=>'import'),
				array(nompage=>'Création d\'une fiche client',page=>'fiche',lien=>'crm1.php?page=fiche',prev=>'sgrc'),
				array(nompage=>'Visu client',page=>'visucrm',lien=>'crm1.php?page=visucrm',prev=>'gcode'),
				array(nompage=>'Liste des comptes client',page=>'gmodifier',lien=>'crm1.php?page=gmodifier',prev=>'gcode'),
				array(nompage=>'Enregistrement compte crm',page=>'enregistrement2',lien=>'crm1.php?page=enregistrement2',prev=>'gcode'),
				array(nompage=>'Statistiques crm',page=>'statcrm',lien=>'crm1.php?page=statcrm',prev=>'gcode'),
				array(nompage=>'Modification compte client crm',page=>'lamodif',lien=>'crm1.php?page=lamodif',prev=>'gcode'),
				array(nompage=>'Modification compte client crm',page=>'modifclientcrm',lien=>'crm1.php?page=modifclientcrm',prev=>'gcode'),
				array(nompage=>'Suppression client crm',page=>'supprimclientcrm',lien=>'crm1.php?page=supprimclientcrm',prev=>'gcode'),
				array(nompage=>'Enregistrement nouveau compte',page=>'statcrm',lien=>'crm1.php?page=enregistrement2',prev=>'gcode')
			); 
$nav[3] =	array(
				array(nompage=>'Formulaires de r&eacute;ponses clients',page=>'visucrm2',lien=>'crm1.php?page=visucrm2',prev=>'visucrm'),
				array(nompage=>'Lecture d\'une base',page=>'voirbase',lien=>'crm1.php?page=voirbase',prev=>'basemodif'),
				array(nompage=>'Suppression de base',page=>'supprimeg',lien=>'crm1.php?page=supprimeg',prev=>'basemodif'),
				array(nompage=>'Ajouter une entrée à la base',page=>'ajoutItemBase',lien=>'crm1.php?page=ajoutItemBase',prev=>'basemodif'),
				array(nompage=>'Enregistrement',page=>'ajoutItemBaseDone',lien=>'crm1.php?page=ajoutItemBaseDone',prev=>'basemodif'),
				array(nompage=>'Modifier une entrée de la base',page=>'editebase',lien=>'crm1.php?page=editebase',prev=>'basemodif'),
				array(nompage=>'Modifier une entrée de la base',page=>'editebaseUpdate',lien=>'crm1.php?page=editebaseUpdate',prev=>'basemodif'),
				array(nompage=>'Suppression d\'une entrée',page=>'supprbase',lien=>'crm1.php?page=supprbase',prev=>'basemodif'),
				array(nompage=>'Remplissage des formulaires',page=>'activapreview',lien=>'crm1.php?page=activapreview',prev=>'activation_prev'),
				array(nompage=>'Enregistrement de le campagne',page=>'activapreview2',lien=>'crm1.php?page=activapreview2',prev=>'activation_prev'),
				// ligne ajoutée par jaafar
				array(nompage=>'Remplissage de l\'arbre',page=>'jaafar',lien=>'crm1.php?page=jaafar',prev=>'activation_prev'),
				array(nompage=>'Visualisation de l\'arbre',page=>'arbre',lien=>'crm1.php?page=arbre',prev=>'activation_prev')
			); 
?>

<table border="0" style="background-repeat:no-repeat" align="center" width="854" background="images/menu_r1_c1.gif">

<tr> <td>
<table width="100%" height="70" border="0" align="right" cellpadding="0" cellspacing="0">
    <tr>
      <td width="624" height="61"></td>
      <td width="110" valign="bottom"><img src="images/contact.gif" width="110" height="27"></td>
    </tr>
  </table>
         </td>
         </tr>


<table border="0"  align="center" width="80%" >
<tr> <td align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <a href="panel.php?page=ajout"><img title="cliquer ici pour rajouter des minutes à votre crédit" src="images/ajouter.gif" border="0" height="27"></a>
  &nbsp;&nbsp; &nbsp;&nbsp;
   <a href="logout.php"> <img title="cliquer ici pour vous déconnecter" src="images/deconnexion.gif" border="0" height="27"> </a>
   <br>  <br>
</td>

</tr>

<tr>
<br>
<td style="background-repeat:repeat" background="images/hauttableaux.gif" width="70%" height="30">
<div align="center">
<a href="panel.php" title="texte bulles"> Acceuil </a>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="panel.php?page=preference" title="texte bulles" > Préférences générales </a>

&nbsp;&nbsp;
|
&nbsp;&nbsp;
<a href="panel.php?page=historique" title="texte bulles" >
Historique D'appel
</a>

     &nbsp;&nbsp;   |
    &nbsp;&nbsp;

<a href="panel.php?page=consomation" title="texte bulles" >
Consommation
</a>
  &nbsp;&nbsp;
    |    &nbsp;&nbsp;


<a href="panel.php?page=facturation" title="texte bulles" >
Facturation
</a>
  &nbsp;&nbsp;
    |    &nbsp;&nbsp;

    <a href="panel.php?page=compte" title="texte bulles" >
Compte associé
</a>
  &nbsp;&nbsp;
    |    &nbsp;&nbsp;



     <a href="panel.php?page=crm" title="texte bulles" >
Outil crm
</a>
  &nbsp;&nbsp;
    |    &nbsp;&nbsp;


 &nbsp;&nbsp; &nbsp;&nbsp;
 <a href="panel.php?page=technique" title="texte bulles" >
<b> Support-Technique </b> 
</a>
 &nbsp;&nbsp;
  &nbsp;&nbsp;
    |    &nbsp;&nbsp;












</div>

 </td> </tr>

<tr> <td>

<?php 


//echo 'la page='.$page;
if(!isset($page)) $page="access";
$page= $lurl.$page;
// c'est ca le probleme $page= "activapreview";
if(file_exists($page.".php")){
// $page= $lurl.$page;
$level = 1;
//*********************** Jaafar: pour résoudre le probleme de navigation il faut rajouter dans le tableau en haut le nom de la page
echo 'Navigation : ';
echo '<a href="'.$nav[0]['lien'].'"  title="ceci est un outil CRM" class="nav" style="color:#636469;font-size:14">'.$nav[0]['nompage'].'</a> ->';
for($i=1; $i<count($nav); $i++)
{
	foreach($nav[$i] as $p)
	{
		if($p['page']!=$page) continue;
		$temp = $p;
		$nav_suite = '';
		if($i > 1)
		for($j=$i-1; $j>=1; $j--)
		{
		foreach($nav[$j] as $q)
		{
			if($temp['prev']!=$q['page']) continue;
			$nav_suite = ' <a href="'.$q['lien'].'" class="nav" title="mettre ici des explications" style="color:#636469;font-size:14">'.$q['nompage'].'</a> -> '.$nav_suite;
			$temp = $q;
			break;
		}
		}
		$nav_suite .= '<font size="4" color="green" >'.$p['nompage'].'</font>';
		echo $nav_suite;
		$i = count($nav);
		break;
	}
}

include($page.".php");
}
else {
echo "Erreur 404 la page ou le fichier demand&eacute; n'a pas &eacute;t&eacute; trouv&eacute; sur le serveur.";

}
?>

 </td> </tr>

</table>

  </tr>
  </td>
  </table>
<?php include('basdepage.php') ; ?>
</body>
</html>
