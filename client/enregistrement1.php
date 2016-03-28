<?php
require("connecte/base.php");
require("lib/date.php");
$valeur1 = "oui";
$valeur1 = trim($valeur1);
$rdvtel = trim($rdvtel);
// print("redvtel $rdvtel et valeur $valeur1 ");
$longchaine1 = strlen($valeur1);
$longchaine = strlen($rdvtel);

$qualification1 = trim($qualification1);
$valeurb = "A";
$valeurb = trim($valeurb);





if(strcasecmp($rdvtel, $valeur1) == 0 ) {
         //          print("ouiiiiiiiiiiiiiii numero $numero  "); 
                  
                        $r = mysql_query("SELECT * FROM ficherdv1 WHERE idclientapp <> '0' and idclientapp='$numeroe' ;") or die ("Erreur : ".mysql_error());
                        $deja2 = mysql_num_rows($r);
                        $date_heure_rdvt  = date('y-m-d H:i:s',mktime($hrdvt, $minrdvt, $secrdvt, $mrdvt, $jrdvt, $ardvt));
                        $date_seconde = mktime($hrdvt, $minrdvt, $secrdvt, $mrdvt, $jrdvt, $ardvt); 
                        if(!$deja2)
                        {
                    //          print(" insertion "); 
                                $query = " INSERT INTO ficherdv1 (numcrm,idcommercial,idcamp,idclientapp,dateheure,lieu) ";
                                $query .= " VALUES ('$centrex2','$commercial','$idcamp','$numeroe','$date_heure_rdvt','$lieurdvt') ";
                                $result = mysql_query($query) or die ("Erreur : ".mysql_error());
                     
                     require("connecte/base.php");
                     $query = " INSERT INTO rpltard (etat,numebase,numeagent,heureappel,nomcampagne) ";
                     $query .= " VALUES ('off','$numeroe','$centrex2','$date_seconde','$idcamp') ";
                     $result = mysql_query($query) or die ("Erreur : ".mysql_error());
                     
                    $madate1 = date("d-m-Y");
                     require("connecte/base.php");
                  $query = " INSERT INTO mestat (numebase,numeagent,date,nomcampagne,action) ";
                  $query .= " VALUES ('$numeroe','$centrex2','$madate1','$iddelabase','rdvtel') ";
                  $result = mysql_query($query) or die ("Erreur : ".mysql_error());



                       
                      $query = " update base_client set etat='rdv'  "; 
                                $query  .= " where numero = '$numeroe' ";
                                $result = mysql_query($query) or die ("Erreur : ".mysql_error());



                         }else{
                                $query = " update ficherdv1 set dateheure='$date_heure_rdvt', lieu='$lieurdvt',numcrm='$centrex2', ".
                                         " idcommercial='$commercial',idclientapp='$numeroe' ";
                                $query  .= " where idclientapp = '$numeroe' ";
                                $result = mysql_query($query) or die ("Erreur : ".mysql_error());
                        }



}
                       else
                        {
                          

$auj_fr  = date('y-m-d',mktime(0, 0, 0, $auj_m, $auj_j, $auj_a));

$query = " SELECT p.fiches as fiches, p.qcm as qcm, p.qb as qb ,p.numero as idcamp ";
$query .= " FROM crm as c , preview as p ";
$query .= " WHERE  c.numero = '$centrex2'  and p.numero=c.id_base ";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
	$lesfiches = $row['fiches'];
	$laqcm = $row['qcm'];
	$laqb = $row['qb'];
	$idcamp = $row['idcamp'];
}
$fiche = explode('-',$lesfiches);
$qcmTemp = explode('::',$laqcm);
$qb = $laqb;





  
$ri = mysql_query("SELECT * FROM ficheliaison WHERE idclientapp='$numero' ;") or die ("Erreur : ".mysql_error());
        $dejas = mysql_num_rows($ri);
        if(!$dejas)
        {
                $query = "INSERT INTO ficheliaison(idcrm,idclientapp,numerosip,nomagent) ";
                $query .= " VALUES ('$idcamp','$numero','$numerosip','$nomagent') ;";
                $result = mysql_query($query) or die ("Erreur : ".mysql_error());
        }else{
                $query = "update ficheliaison set idcrm='$idcamp',numerosip='$numerosip',nomagent='$nomagent' ";
                $query  .= " where idclientapp = '$numero' ";
                $result = mysql_query($query) or die ("Erreur : ".mysql_error());
        }


// fiche qualification

 
if(strcasecmp($valeurb, $qualification1) == 0 ) {
// comptage de marquage

            }
              else
                    {


if(strcasecmp("pinteresse", $qualification1) == 0 ) {

$heursup = "2592000" ;
}

if(strcasecmp("horscible", $qualification1) == 0 ) {

$heursup = "155552000";
}


if(strcasecmp("dejaeqp", $qualification1) == 0 ) {

$heursup = "155552000";

}


if(strcasecmp("repondeur", $qualification1) == 0 ) {

$heursup = "7200";
}


$rdvtime = time() + $heursup  ;
$madate1 = date("d-m-Y");

// insertion pour le rappel

                  require("connecte/base.php");
                  $query = " INSERT INTO rpltard (etat,numebase,numeagent,heureappel,nomcampagne) ";
                  $query .= " VALUES ('off','$numeroe','$centrex2','$rdvtime','$idcamp') ";
                  $result = mysql_query($query) or die ("Erreur : ".mysql_error());


                   require("connecte/base.php");
                   $query = " update base_client set etat='off'  where numero = '$numeroe' ";
                   $result = mysql_query($query) or die ("Erreur : ".mysql_error());

// insertion pour les stat

                  require("connecte/base.php");
                  $query = " INSERT INTO mestat (numebase,numeagent,date,nomcampagne,action) ";
                  $query .= " VALUES ('$numeroe','$centrex2','$madate1','$idcamp','$qualification1') ";
                  $result = mysql_query($query) or die ("Erreur : ".mysql_error());


}






// fin fiche qualification








if(count($qcmTemp))
{
	$r = mysql_query("SELECT * FROM ficheqcm WHERE idclientapp <> '0' and idclientapp='$numero' ;") or die ("Erreur : ".mysql_error());
	$deja = mysql_num_rows($r);
	if(!$deja)
	{
		$query = "INSERT INTO ficheqcm (idcamp,numcrm,idclientapp,dateapp,choix) ";
		$query .= " VALUES ('$idcamp','$centrex2','$numero','$auj_fr','$choixqcm') ;";
		$result = mysql_query($query) or die ("Erreur : ".mysql_error());
	}else{
		$query = "update ficheqcm set choix='$choixqcm',numcrm='$centrex2' ";
		$query  .= " where idclientapp = '$numero' ";
		$result = mysql_query($query) or die ("Erreur : ".mysql_error());
	}
?>

<?php
}

if($qb)
{
	$r = mysql_query("SELECT * FROM ficheqbinaire WHERE idclientapp <> '0' and idclientapp='$numero' ;") or die ("Erreur : ".mysql_error());
	$deja = mysql_num_rows($r);
	if(!$deja)
	{
		$query = " INSERT INTO ficheqbinaire (numcrm,idcamp,idclientapp,reponse) ";
		$query .= " VALUES ('$centrex2','$idcamp','$numero','$choixqb') ";
		$result = mysql_query($query) or die ("Erreur : ".mysql_error());
	}else{
		$query = " update ficheqbinaire set reponse='$choixqb',numcrm='$centrex2' ";
		$query  .= " where idclientapp = '$numero' ";
		$result = mysql_query($query) or die ("Erreur : ".mysql_error());
	}
?>

<?php

}

		$fiche[2]='rdv';
if(count($fiche))
{
	for($i=0; $i<count($fiche); $i++)
	{


           //  print("fiche $fiche[$i] : ");
//fiche rdv1 ********************************************************************************************
		if($fiche[$i] == 'rdv')
		{
		echo '<br> année='.$ardv.'<br>';
		echo '<br> mois='.$mrdv.'<br>';
		echo '<br> jour='.$jrdv.'<br>';
		echo '<br> heure='.$hrdv.'<br>';
		echo '<br> minute='.$minrdv.'<br>';
		
$date_heure_rdv1  = mktime($hrdv,$minrdv,0, $mrdv ,$jrdv, $ardv);
//$date_heure_rdv2  = mktime($hfrdv, $minfrdv, $secfrdv);

echo "<br> RENDEZ VOUS CHOISIE :".$date_heure_rdv1."la date est ".date('H:i:s m/d/y  ',$date_heure_rdv1 );//mktime($hrdv, $minrdv, $secrdv, $mrdv, $jrdv, $ardv));
echo "<br> L'heure EST :".date('H',$date_heure_rdv1 );

				$query = " INSERT INTO ficherdv1 (numcrm,idcommercial,idcamp,idclientapp,dateheure,dateheuref,lieu) ";
				$query .= " VALUES ('$centrex2','$commercial','$idcamp','$numero','$date_heure_rdv1','$date_heure_rdv2 ','$lieurdv') ";
				$result = mysql_query($query) or die ("Erreur : ".mysql_error());



			
		}
?>


		<?php
		if($fiche[$i] == 'rmq')
		{
             // print("rmq rmq numero $numeroe f "); 	
 		$r = mysql_query("SELECT * FROM fichermq WHERE idclientapp <> '0' and idclientapp='$numeroe' ;") or die ("Erreur : ".mysql_error());
			$deja = mysql_num_rows($r);
			if(!$deja)
			{
				$query = " INSERT INTO fichermq (numcrm,idcamp,idclientapp,remarque1,remarque2) ";
				$query .= " VALUES ('$centrex2','$idcamp','$numeroe','$rmq1','$rmq2') ";
				$result = mysql_query($query) or die ("Erreur : ".mysql_error());
			}else{
				$query = " update fichermq set remarque1='$rmq1', remarque2='$rmq2', numcrm='$centrex2' ";
				$query  .= " where idclientapp = '$numeroe' ";
				$result = mysql_query($query) or die ("Erreur : ".mysql_error());
			}
		}
		if($fiche[$i] == 'contrat')
		{

 //            print("contrat contrat f "); 
			$r = mysql_query("SELECT * FROM fichecontrat WHERE idclientapp <> '0' and idclientapp='$numero' ;") or die ("Erreur : ".mysql_error());
			$deja = mysql_num_rows($r);
			$date_heure_rappel  = date('y-m-d H:i:s',mktime($hrappel, $minrappel, $secrappel, $mrappel, $jrappel, $arappel));
			if(!$deja)
			{
				$query = " INSERT INTO fichecontrat (numcrm,idcamp,idclientapp,conclu,dateheurerappel) ";
				$query .= " VALUES ('$centrex2','$idcamp','$numero','$etatcontrat','$date_heure_rappel') ";
				$result = mysql_query($query) or die ("Erreur : ".mysql_error());
			}else{
				$query = " update fichecontrat set conclu='$etatcontrat', dateheurerappel='$date_heure_rappel',numcrm='$centrex2' ";
				$query  .= " where idclientapp = '$numero' ";
				$result = mysql_query($query) or die ("Erreur : ".mysql_error());
			}
		}
	}



}
{
// print("rdv rdv f "); 		
 	$r = mysql_query("SELECT * FROM ficherdv WHERE idclientapp <> '0' and idclientapp='$numero' ;") or die ("Erreur : ".mysql_error());
			$deja = mysql_num_rows($r);
			$date_heure_rdv  = date('y-m-d H:i:s',mktime($hrdv, $minrdv, $secrdv, $mrdv, $jrdv, $ardv));
			if(!$deja)
			{
				$query = " INSERT INTO ficherdv (numcrm,idcommercial,idcamp,idclientapp,dateheure,lieu) ";
				$query .= " VALUES ('$centrex2','$commercial','$idcamp','$numero','$date_heure_rdv','$lieurdv') ";
				$result = mysql_query($query) or die ("Erreur : ".mysql_error());


                             $madate1 = date("d-m-Y");
                     require("connecte/base.php");
                  $query = " INSERT INTO mestat (numebase,numeagent,date,nomcampagne,action) ";
                  $query .= " VALUES ('$numeroe','$centrex2','$madate1','$iddelabase','rdvc') ";
                  $result = mysql_query($query) or die ("Erreur : ".mysql_error());







			}else{
				$query = " update ficherdv set dateheure='$date_heure_rdv', lieu='$lieurdv',numcrm='$centrex2', ".
				         " idcommercial='$commercial',idclientapp='$numero' ";
				$query  .= " where idclientapp = '$numero' ";
				$result = mysql_query($query) or die ("Erreur : ".mysql_error());
			}
		}
?>
<?php


// print("nom $nome prenom $prenome numero $numeroe "); 

	$query = "update base_client set nom='$nome', prenom='$prenome', nombase='$nombase',telephone1='$telephone1', email='$email1'";
	//Récupération des champs optionnels 
	$r_opt = mysql_query(" SELECT *  from base_client where nombase = '".$labase."' LIMIT 0,1 ; ")or die ("Erreur : ".mysql_error());
/*
	$row_opt = mysql_fetch_array($r_opt);
	$Toptions = explode('-',$row_opt['options_choisis']);
	if(count($Toptions)&&$Toptions[0])
	{
		for($i=0;$i<count($Toptions); $i++)
		{
			$lop = $Toptions[$i];
			if($lop)
			$query .= " option".$lop."='".${"option".$lop}."' ";
		}
	}
	
	$query  .= " where numero = '$numeroe' ";
	$result = mysql_query($query) or die ("Erreur : ".mysql_error());
*/

 }

?>
<br>
<br>
<br>
<center>
<b>Enregistrement avec succès  !!
</b>
</center>


<table border="1" bgcolor="yellow" align="center" width="90%"  >
<tr align="center">
<td><b>
<br>

<form action="ficheclient2.php">
	<input type="hidden" name="page" value="ficheclient2" >
	<INPUT type="submit" value="Retour">
</FORM>
</td>
</tr>
</table>
