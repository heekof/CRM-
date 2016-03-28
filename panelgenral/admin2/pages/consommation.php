<?php/*consommation.php*/

?>
<table id="menu_hist" align="center">
	<tr>
		<td align="center"> <b> 
			<a href="?page=consommation&a=cj">Consommation journali&egrave;re</a>&nbsp; | &nbsp; 
			<a href="?page=consommation&a=ch">Consommation hebdomadaire</a> &nbsp; | &nbsp;  
	        <a href="?page=consommation&a=cm">Consommation mensuelle</a> 
         </b>
       	</td>
    </tr>
</table>
<?php
require_once('lib/date.php');
require_once('lib/paging.php');
require_once('lib/number.php');

$Tabmois = array();
$Tabmois[1] = "Janvier";
$Tabmois[]  = "Fevrier";
$Tabmois[]  = "Mars";
$Tabmois[]  = "Avril";
$Tabmois[]  = "MAI"; 
$Tabmois[]  = "Juin"; 
$Tabmois[]  = "Juillet"; 
$Tabmois[]  = "Aout";
$Tabmois[]  = "Septembre";
$Tabmois[]  = "Octobre";
$Tabmois[]  = "Novembre";
$Tabmois[]  = "Decembre";

$Tabjours = array();
$Tabjours[] = "Dimanche";
$Tabjours[] = "Lundi";
$Tabjours[] = "Mardi";
$Tabjours[] = "Mercredi";
$Tabjours[] = "Jeudi";
$Tabjours[] = "Vendredi";
$Tabjours[] = "Samedi";

//Titre par défaut
$title = 'Historique des consommations ';

if(isset($_GET['a']))
{
	$a = strtolower($_GET['a']);
	if($a=='cj')
	{ 		
		$auj = getdate();
		$a = $auj["year"] ; 
		$m = $auj["mon"] ;
		$md = $auj["mday"] ;
		$wd = $auj["wday"] ;
		
		$soeTotal1 = 0;
		$soeTotal2 = 0;
		
		$query1 = "SELECT SUM(coutappel) FROM cdr WHERE calldate LIKE '%$auj%' ;" ;
		$query2 = "SELECT SUM(coutappel) FROM cdr2 WHERE calldate LIKE '%$auj%' ;" ;
		$r1 = mysql_query($query1);
		$r2 = mysql_query($query2);
		
		if($row = mysql_fetch_row($r1))
			$soeTotal1 += (float)$row[0];
		if($row = mysql_fetch_row($r2))
			$soeTotal2 += (float)$row[0];
		
			echo '<br /><table class="list"><thead><tr>'
				.'<td><font size=4>Total consommation de ce jour : '.$Tabjours[$wd].' , '.$md.' '.$Tabmois[$m].' '.$a.'.</font></td>'
				.'</tr></thead><tbody>';
			echo '<td  align="center"><b>'.htmlentities(nformat($soeTotal1 + $soeTotal2, 2)).'  €</b></td>';
			echo '</tbody></table>';
		
	}//FIN Conso Journaliere
	
	if($a=='ch')
	{ 		
		$auj = getdate();
		$a = $auj["year"] ; 
		$m = $auj["mon"] ;
		$md = $auj["mday"] ;
		$wd = $auj["wday"] ;
		
		$soeTotal1 = 0;
		$soeTotal2 = 0;
		
		$auj = date('d/m/Y', date_ilya_njours(0, getdate(),1));
		if($wd==0)
			$lundi  = date('y-m-d', date_ilya_njours(6, getdate(),0));
		elseif($wd==1)
			$lundi  = date('y-m-d', date_ilya_njours(0, getdate(),0));
		elseif($wd==2)
			$lundi  = date('y-m-d', date_ilya_njours(1, getdate(),0));
		elseif($wd==3)
			$lundi  = date('y-m-d', date_ilya_njours(2, getdate(),0));
		elseif($wd==4)
			$lundi  = date('y-m-d', date_ilya_njours(3, getdate(),0));
		elseif($wd==5)
			$lundi  = date('y-m-d', date_ilya_njours(4, getdate(),0));
		elseif($wd==6)
			$lundi  = date('y-m-d', date_ilya_njours(5, getdate(),0));
			
		$demain =date('y-m-d', date_ilya_njours(1, getdate(),1));
		
		$query1 = "SELECT SUM(coutappel) FROM cdr WHERE calldate BETWEEN  '".$lundi."' AND '".$demain."'";
		$query2 = "SELECT SUM(coutappel) FROM cdr2 WHERE calldate BETWEEN  '".$lundi."' AND '".$demain."'";
		$r1 = mysql_query($query1);
		$r2 = mysql_query($query2);
		if($row = mysql_fetch_row($r1))
			$soeTotal1 += (float)$row[0];
		if($row = mysql_fetch_row($r2))
			$soeTotal2 += (float)$row[0];
			
		
			echo '<br /><table class="list"><thead><tr>';
			if($wd==1)
				echo '<td><font size=4>Total consommation de cette semaine. Debut : '.$Tabjours[$wd].' , '.$md.' '.$Tabmois[$m].' '.$a.'.</font></td>';
			else
				echo '<td><font size=4>Total consommation de cette semaine. Ici de '.$Tabjours[1].' &agrave; aujourd\'hui  '.$Tabjours[$wd].' '.$auj.'.</font></td>';
			echo '</tr></thead><tbody>';
			
			echo '<td  align="center"><b>'.htmlentities(nformat($soeTotal1 + $soeTotal2, 2)).'  €</b></td>';
			echo '</tbody></table>';
		
	}//Fin Conso Hebdomadaire
	
	
	if($a=='cm')
	{
		$d = getdate() ; 
		$a = $d["year"] ; 
		$m = $d["mon"] ;
		
		$soeTotal1 = 0;
		$soeTotal2 = 0;
		
		$date = ($m < 10)? date("$a-0$m") : date("$a-$m");
		
		$query1 = "SELECT SUM(coutappel) FROM cdr WHERE calldate LIKE '%$date%' ;" ;
		$query2 = "SELECT SUM(coutappel) FROM cdr WHERE calldate LIKE '%$date%' ;" ;
		$r1 = mysql_query($query1);
		$r2 = mysql_query($query2);
		if($row = mysql_fetch_row($r1))
			$soeTotal1 += (float)$row[0];
		if($row = mysql_fetch_row($r2))
			$soeTotal2 += (float)$row[0];
		
			echo '<br /><table class="list"><thead><tr>'
				.'<td><font size=4>Total consommation du mois de  '.$Tabmois[$m].' '.$a.'.</font></td>'
				.'</tr></thead><tbody>';
			echo '<td  align="center"><b>'.htmlentities(nformat($soeTotal1 + $soeTotal2, 2)).'  €</b></td>';
			echo '</tbody></table>';
	}//FIN Conso Mensuelle
}

?>
