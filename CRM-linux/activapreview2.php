<?php

// print("<br> mbase $mbase <br> ");

require("connecte/base.php");
/*
//Garde le conseil avec son format
$nb_ligne_conseil = explode("\n",$conseil);
if(count($nb_ligne_conseil))
	$leconseil = implode('<br />',$nb_ligne_conseil);
*/

//determine les fiche (fiche sans question) choisis
$fiche = "";
if(isset($rdv))
	$fiche .= $rdv."-";
if(isset($rmq))
	$fiche .= $rmq."-";
if(isset($contrat))
	$fiche .= $contrat."-";
	









/* recupere les variables   ++++++++++++++++++++++++++++++++++++++++      
$var="qcm";
$var2="repQcm";
echo 'valeuuuuuuuuuuuuuuuur'.$count;
for($i=0;$i<$count ;$i++)
for($j=0;$j<2; $j++)
{
$f=$i+1;
//echo $qcm0;
echo  ' <br>  ++++++++'.${$var.$i}.'  +++++  </br>' ;

//echo ' +++++ '.$repQcm10.'+++++';
echo  ' <br> ++++++++ '.${$var2.$f.$j}.' +++++++++   </br>' ;
	}
/*    ++++++++++++++++++++++++++++++++++++++++++++++++   */








//echo '+++++++'.choix[1].'+++++++';





	

if(isset($qcm))  // continuer ici la prochaine fois ++++++++++++++++++++++++++++++++
{

$var="qcm";
$var2="repQcm";
$nb = 2;
    for($i=0;$i<$count ;$i++)
	{
	$leqcm .= 'qcm:'.${$var.$i}.'::';	
	
	for($j=0; $j<${"choixj".$i}; $j++)
	{
	
      if(i!=0){
		//echo ' </br> je suis '.$i.'j ecris dans choix </br>  nombre de choix est :'.${"choixj".$j}.'</br>';
		$f=$i+1;
		$leqcm.=${$var2.$f.$j};
		
		//echo '</br> la valeur est'.${$var2.$f.$j}.'</br>';
		}
		else {
		
		//echo ' </br> je suis '.$i.'j ecris dans choix </br>  nombre de choix est :'.${"choixj".$j}.'</br>';
		$f=$i+1;
		$leqcm.=${$var2.$f.$j};
		
		//echo '</br> LA VAleur est'.${$var2.$f.$j}.'</br>';
		
		
		
		}
	}
	}
	
	
	
}
if(isset($qbinaire))
{ 
$vor="qbinaire";
//echo '++++++++++++'.$counter.'++++++++++';

	for($i=0;$i<$counter;$i++)
{	
     $laqb .= "qb::".$i." ".${$vor.$i}.":";
    	
}
}	

	
	
$query = "INSERT INTO preview (numcli,etat,matable,numetranger,nomchamp,datedebut,datefin,nomproduit,fiches,qcm,qb,conseil) ";
$query  .= " VALUES ('$centrex','ok','$mbase','$numetrang','$nomcampagne','$debut','$fin','$nomproduit','$fiche','$leqcm','$laqb','$conseil') ";
$result = mysql_query($query) or die ("Erreur : ".mysql_error());

mysql_close();



?>
<br> <br> <br>
<center><b> Enregistrement avec succés </b> </center>