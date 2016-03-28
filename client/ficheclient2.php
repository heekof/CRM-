<head>
<!--META HTTP-EQUIV="refresh" CONTENT="5; URL=ficheclient2.php"-->
	<script type="text/javascript" src="agenda/functions.js"></script>
	<link rel="stylesheet" type="text/css" href="agenda/style.css" />
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="js/js.js"></script>
	<script type="text/javascript" src="js/prototype.js"></script>
	<script type="text/javascript" src="js/effects.js"></script>
</head>
<body onload="chargement('<?php echo $centrex2 ;?>');chargement2('<?php echo $centrex2 ;?>');">
<?php
require ('connecte/base.php');
 include("menu_haut.php");
?>



<table align="center" width="100%"  border="0" >

<tr>

<td width="40%" >
<center> <font color="red" size="5">  <b>Flush </b> </font> <a href="flush.php?mynumevice=<?php echo $numvice ;?> "> <img src="/images/go.gif" border="0"  /> </a> </center>
</td>

<td width="20%" >
<center> <font color="red" size="5">  <b>Parking </b> </font> <a href="parking.php?mynumevice=<?php echo $numvice ;?>"> <img src="/images/go.gif" border="0" /> </a> </center>
</td>

<td width="40%"  align="center">
<font color="red" size="5">  <b> Mes 10 derniers appels ll </b> </font>  <a href="crm2.php?mynumevice=<?php echo $numvice ;?>&page=mesdixa"> <img src="/images/go.gif" border="0" /> </a>
</td>
</tr>

</table>



<?php

echo 'centrex2:'.$centrex2;echo 'numvice'.$numevice; 

require("lib/date.php");
    $query = " SELECT  * ";
    $query .= " FROM crm ";
    $query .= " WHERE  numero = '".$centrex2."'";

$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
    $numetrang = ($row["numetrang"]);
    $numevice = ($row["numvice"]);
    $numexterieur = ($row["numexterieur"]);
    $nomdecampagne = ($row["nomcampagne"]); 
    $iddelabase = ($row["id_base"]); 
    
}

 // print(" numevice $numevice <br> ");

$query = " SELECT  * ";
$query .= " FROM appelcours  ";
$query .= " WHERE  src = '$numevice'  ";

$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
    $numcliappel = ($row["numcliappel"]);
    $dst = ($row["dst"]);
}


  $query = " SELECT  * ";
  $query .= " FROM base_client ";
  $query .= " WHERE  numero ='$numcliappel' or telephone1='$dst' ";/*J'ai mis 2 condition juste au cas où!!!!!!!!!!!!!!!!!!!!!!!!!!*/

$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
if($row = mysql_fetch_array($mysql_result))
{
	$numero = ($row["numero"]);
    $nom = ($row["nom"]);
    $prenom = ($row["prenom"]);
	$email = ($row["email"]);
    $telephone1 = ($row["telephone1"]);
    $telephone2 = ($row["telephone2"]);
	$remarque = ($row["remarque"]);
    $etat = ($row["etat"]);
    $nombase = ($row["nombase"]);


// $prenom = utf8_decode($prenom);
// $nomi = utf8_decode($nom); 

}
echo '<br>centrex2:'.$centrex2; 
echo '<br> numvice'.$numevice."<br>";
?>

<br />
<?php
	$query = " SELECT p.conseil as conseil, p.fiches as fiches, p.qcm as qcm, p.qb as qb ,p.matable as labase ";
	$query .= " FROM crm as c , preview as p ";
	$query .= " WHERE  c.numero = '$centrex2'  and p.numero=c.id_base ";
//  $query .= " WHERE  c.numero = '$centrex2'  and p.numero=c.id_base ";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
	$leconseil = $row['conseil'];
	$lesfiches = $row['fiches'];
	$laqcm = $row['qcm'];
	$laqb = $row['qb'];
	$idcamp = $row['idcamp'];
	$labase = $row['labase'];

// print("idcamp $idcamp centrex2 $centrex2 "); 

}



// **************************************************
// ********** debloque les appel une fois raccroche
// print("affiche le numvice $numvice ");

$query = " update compte set etat4='0'  where numero = '$numvice' ";
$result = mysql_query($query) or die ("Erreur : ".mysql_error());

// ********** fin bloquage *******



?>
<table align="center" width="80%"  border="2" >
	<tr bgcolor="#CCCCCC" align="center"> <td><b>RAPPEL DU CONSEIL DE LA CAMPAGNE</b></td> </tr> 
	<tr id="leconseil" style=""> 
		<td align="center" id="zoneconseil" style="height:auto">  
			<b>

 <TEXTAREA name="conseil" rows="25" cols="70" >
                              <?php print("$leconseil");?>

                                        </TEXTAREA>


			</b>
		</td> 
	</tr> 
	<tr  bgcolor="#CCCCCC" align="center"> 
		<td><a href="#" onclick="openCloseConseil();" id="openclose">Fermer</a></td>
	</tr> 
</table>
<BR />








<div id="taskbox" class="taskboxclass"  style="background:#FFBC37;width:auto;height:auto;"></div>
<center><div id="calendar" ></div></center>

<?php
$fiche = explode('-',$lesfiches);
$qcmTemp = explode('::',$laqcm);
$qb = $laqb;
?>
<div id="infosFiches">
<?php

$prenom = utf8_decode($prenom);
$nom = utf8_decode($nom);
?>
<table border="0" align="center" width="50%">
	
	<tr bgcolor="#CCCCCC">
		<td width="100%" align="center">
<b>  <br> : <?php echo $prenom.' '.$nom.'<br />Téléphone : '.$telephone1; ?>
		</b>
		</td>
	</tr>
</table><br />
<?php
if(count($qcmTemp))
{
	$r = mysql_query("SELECT * FROM ficheqcm WHERE idclientapp='".$numero."'   ;") or die ("Erreur : ".mysql_error());
	$deja = mysql_num_rows($r);
	$laqcm = mysql_fetch_array($r);
	if($deja)
	{
		$laquest = substr($qcmTemp[0],4,strlen($qcmTemp[0])-4);
		$leschoix = explode('-',$qcmTemp[1]);
		$choix = (int)$laqcm['choix'];
	
?>
	<table border="0" align="center" width="70%">
	
	<tr bgcolor="#CCCCCC">
		<td width="100%" align="center">
		<b>Question &agrave; choix multiples</b>
		</td>
	</tr>
	<tr>
		<td width="100%" align="center">
		Question : <?php echo '<b>  '.$laquest.'</b>';?>
		</td>
	</tr>
	<tr>
		<td width="100%">Choix du client : <?php echo '<b>'.$leschoix[$choix-1].'</b>' ;?>
	</td>
	</tr>
	</table>
<?php
	}
}

if($qb)
{
	$r = mysql_query("SELECT * FROM ficheqbinaire WHERE idclientapp='".$numero."' ;") or die ("Erreur : ".mysql_error());
	$deja = mysql_num_rows($r);
	if($deja)
	{
		$laqcm = mysql_fetch_array($r);
		$reponse = $laqcm['reponse'];
	
?>
	<table border="0" align="center" width="70%">
	
	<tr bgcolor="#CCCCCC" >
		<td width="100%" align="center" >
		<b>Question binaire (oui/non)</b>
		</td>
	</tr>
	<tr>
		<td width="100%" align="center">
		Question : <?php echo '<b>  '.substr($qb,3,strlen($qb)-3).'</b>';?>
		</td>
	</tr>
	<tr>
		<td width="100%" align="center">
		R&eacute;ponse du client : <?php echo '<b>'.$reponse.'</b>' ; ?>
		</td>
	</tr>
		
	</table>
<?php
	}
}
		
if(count($fiche))
{
	for($i=0; $i<count($fiche); $i++)
	{
		if($fiche[$i] == 'rdv')
		{
			$r = mysql_query("SELECT * FROM ficherdv WHERE idclientapp='".$numero."' ;") or die ("Erreur : ".mysql_error());
			$deja = mysql_num_rows($r);
			$lerdv = mysql_fetch_array($r);
			if($deja)
			{
				
			?>
			<table border="0" align="center" width="70%">
				<tr bgcolor="#CCCCCC">
					<td width="100%" align="center">
					<b>Rendez-vous:</b>
					</td>
				</tr>
				<tr>
					<td width="100%">
					Lieu du RDV : <?php echo $lerdv['lieu']?>
					</td>
				</tr>
				<tr>
					<td width="100%">
					Date et heure du RDV : 
					<?php 
						$ladete1 = explode(' ',$lerdv['dateheure']);
						$ladate = explode('-',$ladete1[0]);
						$lheure = explode(':',$ladete1[1]);
						echo '<b>'.$ladate[2]."/".$ladate[1]."/".$ladate[0]." &agrave; ".$lheure[0]."H ".$lheure[1]."Min ".$lheure[2]."Sec</b>";
					?>
						
					</td>
				</tr>
				
			</table>
			<?php
			}
		}
		if($fiche[$i] == 'rmq')
		{
                   

/********************************/

        		$r = mysql_query("SELECT * FROM fichermq WHERE idclientapp='".$numero."' ;") or die ("Erreur : ".mysql_error());
			$deja = mysql_num_rows($r);
			$larmq = mysql_fetch_array($r);
			if($deja)
			{
                      				
			?>
			<table border="3" align="center" width="70%">
				<tr bgcolor="red">
					<td width="100%" align="center">
					<b>Less remarquessss:</b>
					</td>
				</tr>
				<tr>
					<td width="100%" align="center">
					Remarque 1:
						<?php echo $lerdv['lieu'] ;?>
					
                                 </td>
				</tr>
				<tr>
					<td width="100%" align="center">
					Remarque 20:
					<TEXTAREA name="rmq2" rows="4" cols="40" readonly="readonly">
						<?php echo htmlentities($lerdv['remarque2']) ;?>
					</TEXTAREA>
					</td>
				</tr>
			</table>
			<?php
			}
/********************************************/


		}
		if($fiche[$i] == 'contrat')
		{
			$r = mysql_query("SELECT * FROM fichecontrat WHERE idclientapp='".$numero."' ;") or die ("Erreur : ".mysql_error());
			$deja = mysql_num_rows($r);
			$lecontrat = mysql_fetch_array($r);
			if($deja)
			{
				
			?>
			<table border="2" align="center" width="70%">
				<tr bgcolor="#CCCCCC">
					<td width="100%" align="center">
					<b>Etat du contrat</b>
					<input type="hidden" name="contrat" value="contrat" >
					</td>
				</tr>
				<tr>
					<td width="100%">
					Contrat conclu ? : <?php echo $lecontrat['conclu'] ; ?>
					</td>
				</tr>
				<tr>
				</tr>
				<?php if( $lecontrat['conclu']!='oui'){?>
				<tr>
					<td width="100%">
					Date et heure de rappel : 
					<?php	
						$ladete1 = explode(' ',$lecontrat['dateheurerappel']);
						$ladate = explode('-',$ladete1[0]);
						$lheure = explode(':',$ladete1[1]);
						echo '<b>'.$ladate[2]."/".$ladate[1]."/".$ladate[0]." &agrave; ".$lheure[0]."H ".$lheure[1]."Min ".$lheure[2]."Sec</b>";
						
					?>
						
					</td>
				</tr>
				<?php }?>
			</table>
			<?php
			}
		}
	}
}



// $prenom = utf8_decode($prenom);
// $nom = utf8_decode($nom); 
?>
</div><br/>






<table class="form">
<thead><tr><td colspan="2">Informations sur le client : </td></tr></thead>






<?php


	$r_opt = mysql_query(" SELECT *  from base_client where nombase = '".$labase."' LIMIT 0,1 ; ")or die ("Erreur : ".mysql_error());

	$row_opt = mysql_fetch_array($r_opt);
	$Toptions = explode('-',$row_opt['options_choisis']);
	if(count($Toptions)&&$Toptions[0])
	{
		for($i=0;$i<count($Toptions); $i++)
		{
			$lop = $Toptions[$i];
			echo '<tr>';
			$label = $row_opt['labeloption'.$lop];
			echo '<td ">'.$label.'</td>';
			echo '<td >"'.$row['option'.$lop].'"</td>';
			echo '</tr>';
		}
					
	}



$date_heure_rdvtb  = date('y-m-d H:i:s',mktime($hrdvt, $minrdvt, $secrdvt, $mrdvt, $jrdvt, $ardvt));
// print("affiche $date_heure_rdvtb "); 
// echo date('Y-m-d H:i:s',mktime(date('H'),0,0,date('m'),date(d)+1,date('Y')));
// echo date('Y-m-d H:i:s');



$mktime = mktime(date('H')+2, date('i'), date('s'), date('m'), date('d'), date('Y')); 

// echo '<p>'.date('l d F Y H:i:s', $mktime).'</p>';


// $mktime2 = mktime($hrdvt, $minrdvt, $secrdvt, $mrdvt, $jrdvt, $ardvt); 
// $ladate = date('Y-m-d H:i:s',$mktime);

// print(" la date $ladate "); 
// print("idcamp $idcamp centrex $centrex2 "); 

$rdvtime = time() + 7200  ; 

// print("rdvtime $rdvtime  ladate $mktime et mktime2 $mktime2 "); 
//  echo '<p>'.date('l d F Y H:i:s', $mktime2).'</p>';

?>

</table>


<br>
<br>

<br>
<table border="0" align="center" width="80%" >
<tr>
<td>
<?
// print("idcamp : $nomdecampagne"); 
// php print("numero : $numero");

$timestamp = "1314011401" ; 

// echo date('H\h i\m\i\n s\s', $timestamp); 
// echo date('d/m/Y', $timestamp);


 ?>

 <form action="supprimclientcrm2.php" method="post">
   <INPUT TYPE="hidden" NAME="numero" VALUE="<?php print("$numero"); ?>">
<input type="submit" value="SUPPRIMER"/>
  </form>

 </td>


<td>

<form action="crm2.php?page=qualification" method="post">

<SELECT name="qualification1">
  <option value="pinteresse">Pas inter&eacute;ss&eacute; </option>
  <option value="horscible">Hors Cible</option>
  <option value="dejaeqp">Deja Equiper</option>
  <option value="repondeur">Repondeur </option>
</select>
<INPUT TYPE="hidden" NAME="numeroe" VALUE="<?php print("$numero"); ?>"">
<INPUT TYPE="hidden" NAME="idcamp" VALUE="<?php print("$nomdecampagne"); ?>"">
<INPUT TYPE="hidden" NAME="ladate" VALUE="<?php print("$rdvtime"); ?>"">
<INPUT TYPE="hidden" NAME="iddelabase" VALUE="<?php print("$iddelabase"); ?>"">




   <INPUT TYPE="hidden" NAME="numero" VALUE="<?php print("$numero"); ?>">
<input type="submit" value="valider"/>
  </form>
</td>



<td>
<form action="modifiche.php" method="post">
   <INPUT TYPE="hidden" NAME="numero" VALUE="<?php print("$numero"); ?>">

<INPUT TYPE="hidden" NAME="idcamp1" VALUE="<?php print("$nomdecampagne"); ?>"">
<INPUT TYPE="hidden" NAME="iddelabase" VALUE="<?php print("$iddelabase"); ?>"">


<input type="submit" value="QUALIFIEZ"/>
  </form>
</td>


<td>
<form action="crm2.php?page=appeltdz" method="POST">
   <INPUT TYPE="hidden" NAME="numeroe" VALUE="<?php print("$numero"); ?>">
<INPUT TYPE="hidden" NAME="etatr" VALUE="no">

<INPUT TYPE="hidden" NAME="qualification1" VALUE="repondeur">

<INPUT TYPE="hidden" NAME="numeroe" VALUE="<?php print("$numero"); ?>"">
<INPUT TYPE="hidden" NAME="idcamp" VALUE="<?php print("$nomdecampagne"); ?>"">
<INPUT TYPE="hidden" NAME="ladate" VALUE="<?php print("$rdvtime"); ?>"">
<INPUT TYPE="hidden" NAME="iddelabase" VALUE="<?php print("$iddelabase"); ?>"">
<input type="submit" value="APPELEZ PLUS TARD" >
  </form>


</td>



</tr>
</table>








</body>
