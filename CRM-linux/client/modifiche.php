<head>
<!--META HTTP-EQUIV="refresh" CONTENT="5; URL=ficheclient2.php"-->
	<script type="text/javascript" src="agenda/functions.js"></script>
	<link rel="stylesheet" type="text/css" href="agenda/style.css" />
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="js/js.js"></script>
	<script type="text/javascript" src="js/prototype.js"></script>
	<script type="text/javascript" src="js/effects.js"></script>


</head>
<?php

 require ('connecte/base.php');
 require("lib/date.php");
 
 include("menu_haut.php");
 
	$query = " SELECT p.conseil as conseil ";
	$query .= " FROM crm as c , preview as p ";
	$query .= " WHERE  c.numero = '$centrex2'  and p.numero=c.id_base ";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
	$leconseil = $row['conseil'];
}

// **************************************************
// ********** bloque les appel une fois raccroche 
// print("affiche le numvice $numvice "); 

$query = " update compte set etat4='1'  where numero = '$numvice' ";
$result = mysql_query($query) or die ("Erreur : ".mysql_error());

// ********** fin bloquage *******


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
<font color="red" size="5">  <b> Mes 10 derniers appels </b> </font>  <a href="crm2.php?mynumevice=<?php echo $numvice ;?>&page=mesdixa"> <img src="/images/go.gif" border="0" /> </a> 
</td>
</tr>

</table>


<table align="center" width="80%"  border="0" >
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






<?php
	$query = " SELECT p.fiches as fiches, p.qcm as qcm, p.qb as qb,p.matable as labase, p.numcli as numcli  ";
	$query .= " FROM crm as c , preview as p ";
	$query .= " WHERE  c.numero = '$centrex2'  and p.numero=c.id_base ";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
	$lesfiches = $row['fiches'];
	$laqcm = $row['qcm'];
	$laqb = $row['qb'];
	$idcamp = $row['idcamp'];
	$labase = $row['labase'];
	$numcli = $row['numcli'];
}
$fiche = explode('-',$lesfiches);
$qcmTemp = explode('::',$laqcm);
$qb = $laqb;

?>
<form action="crm2.php?page=enregistrement1" method="POST">
<?php
if(count($qcmTemp))
{
$laquest = substr($qcmTemp[0],4,strlen($qcmTemp[0])-4);
$leschoix = explode('-',$qcmTemp[1]);
$nbchoix = count($leschoix)-1;
?>
	<table border="0" align="center" width="70%">
	
	<tr bgcolor="#CCCCCC">
		<td width="100%" align="center">
		<b>Question à choix multiples</b>
		</td>
	</tr>
	<tr>
		<td width="100%" align="center">
		Question : <?php echo '  '.$laquest;?>
		</td>
	</tr>
	<tr>
		<td width="100%">Choix du client : 
		<select name="choixqcm">
	<?php 
		for($j=1; $j<=$nbchoix; $j++)
		{
	?>
			
		<option value="<?php echo $j ;?>"><?php echo $leschoix[$j-1]; ?></option>
		
	<?php 
		}
	?></td>
	</tr>
	</table>
<?php
}
		
if($qb)
{
?>
	<table border="0" align="center" width="70%">
	
	<tr bgcolor="#CCCCCC" >
		<td width="100%" align="center" >
		<b>Question binaire (oui/non)</b>
		</td>
	</tr>
	<tr>
		<td width="100%" align="center">
		Question : <?php echo '  '.substr($qb,3,strlen($qb)-3);?>
		</td>
	</tr>
	<tr>
		<td width="100%" align="center">
		Réponse du client : Oui<input type="radio" name="choixqb" value="oui"/>&nbsp;&nbsp;&nbsp;
							Non<input type="radio" name="choixqb" value="non"/>
		</td>
	</tr>
		
	</table>
<?php
}

echo '<br> Ceci est le fichier MODIFICHE.PHP et count(fiche)='.count($fiche).'fiche[0]='.$fiche[0]."<br>";
$fiche[2]='rdv';
		
if(count($fiche))
{

	for($i=0; $i<count($fiche); $i++)
	{
		
		if($fiche[$i] == 'rdv')
		{
		?>
			<table border="2" align="center" width="70%">
				<tr bgcolor="#CCCCCC">
					<td width="100%" align="center">
					<b>Rendez-vous:</b>
					</td>
				</tr>
				<tr>
					<td width="100%">
					Lieu du RDV :
					<input type="text" name="lieurdv" value="" size="70%"/>
					</td>

				</tr>
				<tr>
					<td width="100%">
					Date du RDV : 
						<select name="jrdv" id="jrdv">
						<?php
							for($i=1; $i<=31; $i++)
							{
							echo '<option value="'.$i.'" ';
							if($i == $auj_j) echo ' selected="selected" ';
							echo '>'.$i.'</option>';
							}
						?>
						</select>
						<select name="mrdv">
						<?php
							for($i=1; $i<=12; $i++)
							{
							echo '<option value="'.$i.'" ';
							if($i == $auj_m) echo ' selected="selected" ';
							echo '>'.htmlentities($Tabmois[$i]).'</option>';
							}
						?>
						</select>
						<select name="ardv">
						<?php
							for($i=1900; $i<=2050; $i++)
							{
							echo '<option value="'.$i.'" ';
							if($i == $auj_a) echo ' selected="selected" ';
							echo '>'.$i.'</option>';
							}
						?>
						</select>
					</td>


<!-- jaafar  *********************************************************************************************************************--> 	
<td> 
<table border=0 >
<div id="mainContainer"  >
 
<tr><td><input type="button" id="button" onClick="dispo_com();"  value="Afficher la  disponibilité" /> 
</tr>
		<tr><td> </tr>
	
<input type="text" id="jour"   >
</div>
</table>
<table border="2" >

 


</table> 
</td>
<!-- fin jaafar **************************************************************************************************************-->
				</tr>


				<tr>
					<td  width="100%">
						Heure  du RDV : H : 
						<select name="hrdv">
						<?php
							for($i=0; $i<=23; $i++)
							{
							echo '<option value="'.$i.'">';
							if($i < 10) echo '0';
							echo $i.'</option>';
							}
						?>
						</select> Min : 
						<select name="minrdv">
						<?php
							for($i=0; $i<=59; $i++)
							{
							echo '<option value="'.$i.'">';
							if($i < 10) echo '0';
							echo $i.'</option>';
							}
						?>
						</select> Sec : 
						<select name="secrdv">
						<?php
							for($i=0; $i<=59; $i++)
							{
							echo '<option value="'.$i.'">';
							if($i < 10) echo '0';
							echo $i.'</option>';
							}
						?>
						</select>
					</td>
				</tr>
<tr>
					<td  width="100%">
						Heure de fin du RDV : H : 
						<select name="hfrdv">
						<?php
							for($i=0; $i<=23; $i++)
							{
							echo '<option value="'.$i.'">';
							if($i < 10) echo '0';
							echo $i.'</option>';
							}
						?>
						</select> Min : 
						<select name="minfrdv">
						<?php
							for($i=0; $i<=59; $i++)
							{
							echo '<option value="'.$i.'">';
							if($i < 10) echo '0';
							echo $i.'</option>';
							}
						?>
						</select> Sec : 
						<select name="secfrdv">
						<?php
							for($i=0; $i<=59; $i++)
							{
							echo '<option value="'.$i.'">';
							if($i < 10) echo '0';
							echo $i.'</option>';
							}
						?>
						</select>
					</td>
				</tr>

				<tr>
					<td>
					Attacher un commercial au RDV
					
					<select name="commercial" id="commercial" >
						<option value="0">-Choisir un commercial-</option>
						<option value="no">----------------------</option>
						<?php 
							$r_com = mysql_query(" select * from commerciaux where numcli='$numcli' ");
							while($row=mysql_fetch_array($r_com))
							{
								echo '<option value="'.$row['numero'].'">'.$row['nom'].' '.$row['prenom'].'</option>';
							}
						?>
					</select>
					</td>
				</tr>
				<tr>
				date indisponible: <?php        
// recherche date debut				
$query1 = " SELECT  dateheure ";
$query1 .= "FROM  ficherdv1  ";
$query1 .= "WHERE idcommercial='$commercial' ";//and  date('y',dateheure)=ardv and  date('m',dateheure)=mrdv and  date('d',dateheure)=jrdv  ";
//" and  $jrdv='10' and  $mrdv='2' and $ardv='2012'";
$mysql_result = mysql_query($query1) or die ("Erreur : ".mysql_error());
$ff=0;
while($row = mysql_fetch_array($mysql_result))
{
    $Targument[$ff] = ($row["dateheure"]);
$ff++;
	}
// recherche date fin 
	$query11 = " SELECT  dateheuref ";
$query11 .= "FROM  ficherdv1  ";
$query11 .= "WHERE idcommercial='$commercial' ";//and  date('y',dateheure)=ardv and  date('m',dateheure)=mrdv and  date('d',dateheure)=jrdv  ";
//" and  $jrdv='10' and  $mrdv='2' and $ardv='2012'";
$mysql_result = mysql_query($query11) or die ("Erreur : ".mysql_error());
$ff1=0;
while($row = mysql_fetch_array($mysql_result))
{
    $Targumentf[$ff1] = ($row["dateheuref"]);
$ff1++;
	}
	$ff=0;$ff1=0;
//for($ff=0;$ff<$Targument.size;$ff++){
	// ca c est pour le test 
echo "<br>dateheure=".$Targument[$ff] ;
echo "<br>la date est :".date('y-m-d H:i:s',$Targument[$ff] );
echo "<br>année".date('y',$Targument[$ff] );
echo "<br>mois".date('m',$Targument[$ff] );
echo "<br>jour".date('d',$Targument[$ff] );
// ca c est pour l'affichage
echo "<br>heure".date('h',$Targument[$ff] ); $heureDebut=date('H',$Targument[$ff] ); echo 'MON HEURE ='.$heureDebut;
echo "<br>min".date('i',$Targument[$ff] ); $minuteDebut=date('i',$Targument[$ff] );
echo "<br>sec".date('s',$Targument[$ff] ); $secondeDebut=date('s',$Targument[$ff] );
 //}
 
 // ca c est pour l'affichage
echo "<br>heure".date('h',$Targumentf[$ff1] ); $heureFin=date('h',$Targumentf[$ff] );
echo "<br>min".date('i',$Targumentf[$ff1] ); $minuteFin=date('i',$Targumentf[$ff] );
echo "<br>sec".date('s',$Targumentf[$ff1] ); $secondeFin=date('s',$Targumentf[$ff] );
 
 
 
 
 
 ?> 
 
 
     
 
 

	<td  id="a" >8h-8h30</td>
	<td id="b" >8h30-9h</td>
	<td  id="c">9h-9h30</td>
	<td  id="d" >9h30-10h</td>
	<td id="e" >10h-10h30</td>
	<td id="f" bgcolor="red" style="red" >10h30-11h</td>
    
	<td  id="g" >11h-11h30</td>
	<td  id="h" >11h30-12h</td>
	<td id="i" >12h-12h30</td>
	<td  id="j" >12h30-13h</td>
	<td  id="k" >13h-13h30</td>
	<td id="l"  >13h30-14h</td>
	<td id="m" >14h-14h30</td>
	<td id="n"  >14h30-15h</td>
	<td id="o" >15h-15h30</td>
	<td id="p"  >15h30-16h</td>
	<td id="q" >16h-16h30</td>
	<td id="r"  >16h30-17h</td>
	<td id="s" >17h-17h30</td>
	<td  id="t" >17h30-18h</td>
	
	
	     </tr>
			</table>
		<?php
		}
//		if($fiche[$i] == 'rmq'){
		?>







    <table border="0" align="center" width="70%">

        <tr bgcolor="#CCCCCC" >
                <td width="100%" align="center" >
                <b>Qualification</b>
                </td>
        </tr>
        <tr>
                <td width="100%" align="center">

  
  <br>                
<SELECT name="qualification1">

   <option value="A"> ----------------- </option>
  <option value="pinteresse">Pas inter&eacute;ss&eacute; </option>
  <option value="horscible">Hors Cible</option>
  <option value="dejaeqp">Deja Equiper</option>
  <option value="repondeur">Repondeur </option>
</select>
      <br>
  <br>

                </td>
        </tr>
 </table>




















			<table border="0" align="center" width="70%">
				<tr bgcolor="#CCCCCC">
					<td width="100%" align="center">
					<b>Les remarques:</b>
					</td>
				</tr>
				<tr>
					<td width="100%" align="center">
					Remarque 1:
					<TEXTAREA name="rmq1" rows="4" cols="40">
						
					</TEXTAREA>
					</td>
				</tr>
				<tr>
					<td width="100%" align="center">
					Remarque 2:
					<TEXTAREA name="rmq2" rows="4" cols="40">
						
					</TEXTAREA>
					</td>
				</tr>
			</table>
		<?php
//		}
		
		if($fiche[$i] == 'contrat'){
		?>
			<table border="0" align="center" width="70%">
				<tr bgcolor="#CCCCCC">
					<td width="100%" align="center">
					<b>Etat du contrat</b>
					<input type="hidden" name="contrat" value="contrat" >
					</td>
				</tr>
				<tr>
					<td width="100%">
					Contrat conclu ? : Oui<input type="radio" name="etatcontrat" value="oui"/>&nbsp;&nbsp;&nbsp;
										Non<input type="radio" name="etatcontrat" value="non"/>
					</td>
				</tr>
				<tr>
				</tr>
				<tr>
					<td>
						<font color="red">Si le contrat n'est pas conclu</font>
					</td>
				</tr>
				<tr>
					<td width="100%">
					Date de rappel : 
						<select name="jrappel">
						<?php
							for($i=1; $i<=31; $i++)
							{
							echo '<option value="'.$i.'" ';
							if($i == $auj_j) echo ' selected="selected" ';
							echo '>'.$i.'</option>';
							}
						?>
						</select>
						<select name="mrappel">
						<?php
							for($i=1; $i<=12; $i++)
							{
							echo '<option value="'.$i.'" ';
							if($i == $auj_m) echo ' selected="selected" ';
							echo '>'.htmlentities($Tabmois[$i]).'</option>';
							}
						?>
						</select>
						<select name="arappel">
						<?php
							for($i=1900; $i<=2050; $i++)
							{
							echo '<option value="'.$i.'" ';
							if($i == $auj_a) echo ' selected="selected" ';
							echo '>'.$i.'</option>';
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td  width="100%">
						Heure de rappel: H : 
						<select name="hrappel">
						<?php
							for($i=0; $i<=23; $i++)
							{
							echo '<option value="'.$i.'">';
							if($i < 10) echo '0';
							echo $i.'</option>';
							}
						?>
						</select> Min : 
						<select name="minrappel">
						<?php
							for($i=0; $i<=59; $i++)
							{
							echo '<option value="'.$i.'">';
							if($i < 10) echo '0';
							echo $i.'</option>';
							}
						?>
						</select> Sec : 
						<select name="secrappel">
						<?php
							for($i=0; $i<=59; $i++)
							{
							echo '<option value="'.$i.'">';
							if($i < 10) echo '0';
							echo $i.'</option>';
							}
						?>
						</select>
					</td>
				</tr>
			</table>
		<?php
		}
	}
}
?>
<?php

$query = " SELECT  * ";
$query .= " FROM base_client ";
$query .= " WHERE  numcli = '$centrex4' and numero ='$numero' ";

$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
    $numeroe = ($row["numero"]);
    $nome = ($row["nom"]);
    $prenome = ($row["prenom"]);
    $telephone1 = ($row["telephone1"]);
    $telephone2 = ($row["telephone2"]);
    $etat = ($row["etat"]);
    $email1 = ($row["email"]);
    $remarque = ($row["remarque"]);
    $nombase = ($row["nombase"]);


$voption1 = ($row["option1"]);
$vlabeloption1 = ($row["labeloption1"]);

$vlabeloption2 = ($row["labeloption2"]);
$voption2 = ($row["option2"]);

$vlabeloption3 = ($row["labeloption3"]);
$voption3 = ($row["option3"]);

$vlabeloption4 = ($row["labeloption4"]);
$voption4 = ($row["option4"]);

$vlabeloption5 = ($row["labeloption5"]);
$voption5 = ($row["option5"]);

$vlabeloption6 = ($row["labeloption6"]);
$voption6 = ($row["option6"]);




}  
?>
<br />










<br>
 <table border="0" align="center" width="70%">
                                <tr bgcolor="#CCCCCC">
                                        <td width="100%" align="center">
                                        <b>Rappel t&eacute;l&eacute;phonique:</b>
                                        </td>
                                </tr>



                                <tr>
                                        <td width="100%">
                                        Date du RDV :
                                                <select name="jrdvt">
                                                <?php
                                                        for($i=1; $i<=31; $i++)
                                                        {
                                                        echo '<option value="'.$i.'" ';
                                                        if($i == $auj_j) echo ' selected="selected" ';
                                                        echo '>'.$i.'</option>';
                                                        }
                                                ?>
                                                </select>
                                                <select name="mrdvt">
                                                <?php
                                                        for($i=1; $i<=12; $i++)
                                                        {
                                                        echo '<option value="'.$i.'" ';
                                                        if($i == $auj_m) echo ' selected="selected" ';
                                                        echo '>'.htmlentities($Tabmois[$i]).'</option>';
                                                        }
                                                ?>

 </select>
                                                <select name="ardvt">
                                                <?php
                                                        for($i=1900; $i<=2050; $i++)
                                                        {
                                                        echo '<option value="'.$i.'" ';
                                                        if($i == $auj_a) echo ' selected="selected" ';
                                                        echo '>'.$i.'</option>';
                                                        }
                                                ?>
                                                </select>
                                        </td>
                                </tr>
                                <tr>
                                        <td  width="100%">
                                                Heure du RDV : H :
                                                <select name="hrdvt">
                                                <?php
                                                        for($i=0; $i<=23; $i++)
                                                        {
                                                        echo '<option value="'.$i.'">';
                                                        if($i < 10) echo '0';
                                                        echo $i.'</option>';
                                                        }
                                                ?>
                                                </select> Min :
                                                <select name="minrdvt">
                                                <?php
                                                        for($i=0; $i<=59; $i++)
                                                        {
                                                        echo '<option value="'.$i.'">';
                                                        if($i < 10) echo '0';
                                                        echo $i.'</option>';
                                                        }
                                                ?>
                                                </select> 
                                                

                             </td>
                                </tr>
                              

 <tr>   <td> 

<INPUT TYPE=RADIO NAME=rdvtel VALUE="non" CHECKED> pas de rendez vous 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp      <INPUT TYPE=RADIO NAME=rdvtel VALUE="oui">  Qualifier le rendez-vous  


  </td>  </tr>
</table>




<TABLE border="0" width="70%"  align="center" cellpadding="2" cellspacing="0" class="form">
<thead><tr><td colspan="2">Informations sur le client</td></tr></thead>
	  <TR>
	  <TD class="label">Nom :</td>
	  <TD><input size="30" name="nome" value="<?php print("$nome")?>" ></td>
	  </tr>

	  <TR>

	  <TD class="label">Pr&eacute;nom :</TD>
	  <td class="input"><input size="30" name="prenome" value="<?php print("$prenome")?>" ></td>
	  </tr>

          <TR>
	  <td class="label">Telephone :</td>
	  <td class="input"><input size="30" name="telephone1" value="<?php print("$telephone1")?>" ></td>
	  </tr><tr>
	  
	  <TR>
	  <td class="label">Email :</td>
	  <td class="input"><input size="30" name="email1" value="<?php print("$email1")?>" ></td>
	  </tr>
<?php
// print("idcamp $idcamp1  centrex4 $centrex4 and numero $numero labase $labase ");   

//	$r_opt = mysql_query(" SELECT *  from base_client where nombase = '".$labase."' LIMIT 0,1 ; ")or die ("Erreur : ".mysql_error());
 $r_opt = mysql_query(" SELECT *  from base_client where numero = '$numero' ");
	$row_opt = mysql_fetch_array($r_opt);

$vropte = $row_opt['options_choisis']; 
	
// print("rp_opte : $r_opt -  vropte $vropte ");
$Toptions = explode('-',$row_opt['options_choisis']);
	if(count($Toptions)&&$Toptions[0])
	{
               //  for($i=0;$i< 3 ; $i++)
		for($i=0;$i<count($Toptions); $i++)
		{
		


$lop = $Toptions[$i];
$label = $row_opt['labeloption'.$lop];
$loption = option.$lop;
$lavaleur = $row_opt[$loption];

// print("<br>  $lavaleur lavaleur -lavaleur $lavaleur - loption $loption - lop $lop - label $label  <br> ");

echo '<td class="label">'.$label.'</td>';

?>
<td class="input">

<input type="text"  name="<?php print($loption); ?>" value="<?php print($lavaleur); ?>" >
 </td>

<?php
echo '</tr>';

		}
		echo '<input type="hidden" name="labase" value="'.$labase.'" />';
	}

// print("toption totale count($Toptions) "); 
?>

</TABLE>

        <input type="hidden" name="numerosip" value="<?php print("$numvice"); ?>" >
         <input type="hidden" name="nomagent" value="<?php print("$nomagent"); ?>" >

<INPUT TYPE="hidden" NAME="qualification2" VALUE="rdztel">
<INPUT TYPE="hidden" NAME="qualification3" VALUE="rdzc">

	<input type="hidden" name="nombase" value="<?php print("$nombase"); ?>" >
	<input type="hidden" name="numeroe" value="<?php print("$numero"); ?>" >
<input type="hidden" name="numero" value="<?php print("$numero"); ?>" >

<INPUT TYPE="hidden" NAME="idcamp" VALUE="<?php print("$idcamp1"); ?>"">
<INPUT TYPE="hidden" NAME="iddelabase" VALUE="<?php print("$iddelabase"); ?>"">

	
	<br /><center><INPUT type="submit" value="Suivant" name="submit"></center>
</FORM>

	<script type="text/javascript">  

   function dispo_com(){
      
     // var elm2 = document.getElementById('commercial').value;
     //var elm1 = document.getElementById('jrdv').value;
     //document.getElementById('jour').value="le jour : "+elm1+"le commercial"+elm2+"disponible pour le "; 
    
    
         // alert("<?php echo $heureDebut ?>");
	
				heureDebut="<?php echo $heureDebut; ?>";
				 minuteDebut="<?php echo $minuteDebut; ?>";
				 secondeDebut="<?php echo $secondeDebut; ?>";
				
				 heureFin="<?php echo $heureFin; ?>";
				 minuteFin="<?php echo $minuteFin; ?>";
				 secondeFin="<?php echo $secondeFin; ?>";
				
				alert(heureDebut);
				alert(minuteDebut);
				
				if( heureDebut== '08'){
						
						if( minuteDebut<='30' )  document.getElementById('a').style.color="red";
						else   document.getElementById('b').style.color="red";
						
				}
				
				if( heureDebut== '09'){
						
						if( minuteDebut<='30' )  document.getElementById('c').style.color="red";
						else   document.getElementById('d').style.color="red";
						
				}
				if( heureDebut== '10'){
						
						if( minuteDebut<='30' )  document.getElementById('e').style.color="red";
						else   document.getElementById('f').style.color="red";
						
				}
				if( heureDebut== '11'){
						
						if( minuteDebut<='30' )  document.getElementById('j').style.color="red";
						else   document.getElementById('h').style.color="red";
						
				}
				if( heureDebut== '12'){
						
						if( minuteDebut<='30' )  document.getElementById('i').style.color="red";
						else   document.getElementById('j').style.color="red";
						
				}
				if( heureDebut== '13'){
						
						if( minuteDebut<='30' )  document.getElementById('k').style.color="red";
						else   document.getElementById('l').style.color="red";
						
				}if( heureDebut== '14'){
						
						if( minuteDebut<='30' )  document.getElementById('m').style.color="red";
						else   document.getElementById('n').style.color="red";
						
				}if( heureDebut== '15'){
						
						if( minuteDebut<='30' )  document.getElementById('o').style.color="red";
						else   document.getElementById('p').style.color="red";
						
				}
				if( heureDebut== '16'){
						
						if( minuteDebut<='30' ) document.getElementById('q').style.color="red";
						else   document.getElementById('r').style.color="red";
						
				}if( heureDebut== '17'){
						
						if( minuteDebut<='30' )  document.getElementById('s').style.color="red";
						else   document.getElementById('t').style.color="red";
						
				} 
      }

     </script>
