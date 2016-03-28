<?php /* consommations_credits.php */
require_once('lib/date.php');
require_once('lib/paging.php');
require_once('lib/fonctions_historique.php');

//Situation initialle
if(!isset($stat) && !isset($conso))
{
	$stat = "generale";
	$conso = "j";
}
$title= "Statistiques des consommations";
//Sous menu
include('pages/spages/menuConsoCredits.php');
if(!isset($stat))
{
	
}
else if($stat=="generale")
{
	if($conso=="j")
	{
		$consoGJr = consoGeneDuJour(date('Y-m-d',time()));
		
		//echo '<center><font color="green" size="4">Consommation de la journ&eacute;e : '.$consoGJr.'€</font></center>';
		echo '<br /><table class="list"><thead><tr>'
				.'<td><font size=4>Total consommation de ce jour : '.$Tabjours[$auj_wd].' , '.$auj_j.' '.$Tabmois[$auj_m].' '.$auj_a.'.</font></td>'
				.'</tr></thead><tbody>';
			echo '<td  align="center"><font color="green" size="4">'.htmlentities($consoGJr).' €</font></td>';
			echo '</tbody></table>';
	}
	if($conso=="hendo")
	{
		$soeTotal1 = 0;
		$soeTotal2 = 0;
		
		if($auj_wd==0)
			$lundi  = date('y-m-d', date_ilya_njours(6, $auj,0));
		elseif($auj_wd==1)
			$lundi  = date('y-m-d', date_ilya_njours(0, $auj,0));
		elseif($auj_wd==2)
			$lundi  = date('y-m-d', date_ilya_njours(1, $auj,0));
		elseif($auj_wd==3)
			$lundi  = date('y-m-d', date_ilya_njours(2, $auj,0));
		elseif($auj_wd==4)
			$lundi  = date('y-m-d', date_ilya_njours(3, $auj,0));
		elseif($auj_wd==5)
			$lundi  = date('y-m-d', date_ilya_njours(4, $auj,0));
		elseif($auj_wd==6)
			$lundi  = date('y-m-d', date_ilya_njours(5, $auj,0));
			
		$demain =date('y-m-d', date_ilya_njours(1, $auj,1));
		
		$consoGHebdo = consoGeneEntreDeuxDates($lundi,$demain);
		//echo '<center><font color="green" size="4">Consommation de la semaine : '.$consoGHebdo.'€</font></center>';
		echo '<br /><table class="list"><thead><tr>';
			if($auj_wd==1)
				echo '<td><font size=4>Total consommation de cette semaine. Debut : '.$Tabjours[$auj_wd].' , '.$auj_j.' '.$Tabmois[$auj_m].' '.$auj_a.'.</font></td>';
			else
				echo '<td><font size=4>Total consommation de cette semaine. Ici de '.$Tabjours[1].' &agrave; aujourd\'hui  '.$Tabjours[$auj_wd].' '.date('d/m/Y', date_ilya_njours(0, $auj,1)).'.</font></td>';
			echo '</tr></thead><tbody>';
			
			echo '<td  align="center"><font color="green" size="4">'.htmlentities($consoGHebdo).' €</font></td>';
			echo '</tbody></table>';
	}
	if($conso=="mensuelle")
	{
		$consoGMois = consoGeneDuJour(date('Y-m',time()));
		//echo '<center><font color="green" size="4">Consommation du mois : '.$consoGMois.'€</font></center>';
		echo '<br /><table class="list"><thead><tr>'
				.'<td><font size=4>Total consommation du mois de  '.$Tabmois[$auj_m].' '.$auj_a.'.</font></td>'
				.'</tr></thead><tbody>';
			echo '<td  align="center"><font color="green" size="4">'.htmlentities($consoGMois).' €</font></td>';
			echo '</tbody></table>';
	}
	if($conso=="intervalle")
	{
		$Td1 = explode('/',$gd1);
		$Td2 = explode('/',$gd2);
		
		if(checkdate((int)$Td1[1], (int)$Td1[0], (int)$Td1[2]) && checkdate((int)$Td2[1], (int)$Td2[1], (int)$Td2[2]))
		{
			$consoGIntervalle = consoGeneEntreDeuxDates(date('Y-m-d',mktime(0, 0, 0, (int)$Td1[1], (int)$Td1[0], (int)$Td1[2])),date('Y-m-d',mktime(0, 0, 0, (int)$Td2[1], (int)$Td2[0], (int)$Td2[2])));
			//echo '<center><font color="green" size="4">Consommation de la p&eacute;riode du '.$gd1.' au '.$gd2.' : '.$consoGIntervalle.'€</font></center>';
			echo '<br /><table class="list"><thead><tr>'
				.'<td><font size=4>Total Consommation de la p&eacute;riode du '.$gd1.' au '.$gd2.'.</font></td>'
				.'</tr></thead><tbody>';
			echo '<td  align="center"><font color="green" size="4">'.htmlentities($consoGIntervalle).' €</font></td>';
			echo '</tbody></table>';
		}else
			echo '<center><font color="red" size="4">Date(s) non conforme(s)!</font></center>';
	
	}
}
else if($stat=="client")
{
	if(isset($idclient))
	{
		$r_test = @mysql_query("SELECT * FROM identite WHERE  numero='$idclient'");
		$infoclient = @mysql_fetch_array($r_test);
		$name = $infoclient['prenom'].' '.$infoclient['nom'];
	}
	if($periode=="j")
	{
		$consoJr = consoDuJour($idclient,date('Y-m-d',time()));
		//echo '<center><font color="green" size="4">Consommation journali&egrave;re du client N° '.$idclient.' : '.$consoJr.'€</font></center>';
		echo '<br /><table class="list"><thead><tr>'
				.'<td><font size=4>Consommation journali&egrave;re ('.$Tabjours[$auj_wd].' , '.$auj_j.' '.$Tabmois[$auj_m].' '.$auj_a.') du client N° '.$idclient.'<br>'.$name.'</font></td>'
				.'</tr></thead><tbody>';
			echo '<td  align="center"><font color="green" size="4">'.htmlentities($consoJr).' €</font></td>';
			echo '</tbody></table>';
	}
	if($periode=="hendo")
	{
		if($auj_wd==0)
			$lundi  = date('y-m-d', date_ilya_njours(6, $auj,0));
		elseif($auj_wd==1)
			$lundi  = date('y-m-d', date_ilya_njours(0, $auj,0));
		elseif($auj_wd==2)
			$lundi  = date('y-m-d', date_ilya_njours(1, $auj,0));
		elseif($auj_wd==3)
			$lundi  = date('y-m-d', date_ilya_njours(2, $auj,0));
		elseif($auj_wd==4)
			$lundi  = date('y-m-d', date_ilya_njours(3, $auj,0));
		elseif($auj_wd==5)
			$lundi  = date('y-m-d', date_ilya_njours(4, $auj,0));
		elseif($auj_wd==6)
			$lundi  = date('y-m-d', date_ilya_njours(5, $auj,0));
			
		$demain =date('y-m-d', date_ilya_njours(1, $auj,1));
			
		$consoHebdo = consoEntreDeuxDates($idclient,$lundi,$demain);
		echo '<br /><table class="list"><thead><tr>';
			if($auj_wd==1)
				echo '<td><font size=4>Consommation hebdomadaire du client N° '.$idclient.'.<br>'.$name.'<br> d&eacute;but : '.$Tabjours[$auj_wd].' , '.$auj_j.' '.$Tabmois[$auj_m].' '.$auj_a.'.</font></td>';
			else
				echo '<td><font size=4>Consommation hebdomadaire du client N° '.$idclient.'<br>'.$name.'<br> : Ici de '.$Tabjours[1].' &agrave; aujourd\'hui  '.$Tabjours[$auj_wd].' '.date('d/m/Y', date_ilya_njours(0, $auj,1)).'.</font></td>';
			echo '</tr></thead><tbody>';
			
			echo '<td  align="center"><font color="green" size="4">'.htmlentities($consoHebdo).' €</font></td>';
			echo '</tbody></table>';
	}
	if($periode=="mensuelle")
	{
		$consoMois = consoDuJour($idclient,date('Y-m',time()));
		//echo '<center><font color="green" size="4">Consommation mensuelle du client N° '.$idclient.' : '.$consoMois.'€</font></center>';
		echo '<br /><table class="list"><thead><tr>'
				.'<td><font size=4>Consommation mensuelle ('.$Tabmois[$auj_m].' '.$auj_a.') du client N° '.$idclient.'<br>'.$name.'</font></td>'
				.'</tr></thead><tbody>';
			echo '<td  align="center"><font color="green" size="4">'.htmlentities($consoMois).' €</font></td>';
			echo '</tbody></table>';
	}
	if($periode=="intervalle")
	{
		$Td1 = explode('/',$cd1);
		$Td2 = explode('/',$cd2);
		
		if(checkdate((int)$Td1[1], (int)$Td1[0], (int)$Td1[2]) && checkdate((int)$Td2[1], (int)$Td2[0], (int)$Td2[2]))
		{
			$consoIntervalle = consoEntreDeuxDates($idclient,date('Y-m-d',mktime(0, 0, 0, (int)$Td1[1], (int)$Td1[0], (int)$Td1[2])),date('Y-m-d',mktime(0, 0, 0, (int)$Td2[1], (int)$Td2[0], (int)$Td2[2])));
			//echo '<center><font color="green" size="4">conso entre le '.$cd1.' et le '.$cd2.' : '.$consoIntervalle.'</font></center>';
			echo '<br /><table class="list"><thead><tr>'
				.'<td><font size=4>Total Consommation du client N° '.$idclient.'<br>'.$name.'<br>p&eacute;riode du '.$cd1.' au '.$cd2.'</font></td>'
				.'</tr></thead><tbody>';
			echo '<td  align="center"><font color="green" size="4">'.htmlentities($consoIntervalle).' €</font></td>';
			echo '</tbody></table>';
		}else
			echo '<center><font color="red" size="4">Date(s) non conforme(s)!</font></center>';
	
	}
}else if($stat=="nmeilleurs")
{
	if($periode=="j")
	{
		$nMeilleurs = nMeilleursConsommateursDuJour((int)$n,date('Y-m-d',time()));
		$url = "&n=".$n."&periode=j";
		if($n<>1)
		echo '<center><font size="4">Liste des '.$n.' meilleurs consommateurs de la journ&eacute;e</font></center>';
		else echo '<center><font size="4">Le meilleur consommateurs de la journ&eacute;e</font></center>';
		
	}
	if($periode=="hendo")
	{
		$auj = getdate();
		$a = $auj["year"] ; 
		$m = $auj["mon"] ;
		$md = $auj["mday"] ;
		$wd = $auj["wday"] ;
		
		$soeTotal1 = 0;
		$soeTotal2 = 0;
		
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
		
		$nMeilleurs = nMeilleursConsommateursEntreDeuxDates((int)$n,$lundi,$demain);
		$url = "&n=".$n."&periode=hendo";
		if($n<>1)
		echo '<center><font size="4">Liste des '.$n.' meilleurs consommateurs de la semaine</font></center>';
		else echo '<center><font size="4">Le meilleur consommateurs de la semaine</font></center>';
	
	}
	if($periode=="mensuelle")
	{
		$nMeilleurs = nMeilleursConsommateursDuJour((int)$n,date('Y-m',time()));
		$url = "&n=".$n."&periode=mensuelle";
		if($n<>1)
		echo '<center><font size="4">Liste des '.$n.' meilleurs consommateurs du mois</font></center>';
		else echo '<center><font size="4">Le meilleur consommateurs du mois</font></center>';
	}
	if($periode=="intervalle")
	{
		$Td1 = explode('/',$id1);
		$Td2 = explode('/',$id2);
		
		if(checkdate((int)$Td1[1], (int)$Td1[0], (int)$Td1[2]) && checkdate((int)$Td2[1], (int)$Td2[0], (int)$Td2[2]))
		{
			$nMeilleurs = nMeilleursConsommateursEntreDeuxDates((int)$n,date('Y-m-d',mktime(0, 0, 0, (int)$Td1[1], (int)$Td1[0], (int)$Td1[2])),date('Y-m-d',mktime(0, 0, 0, (int)$Td2[1], (int)$Td2[0], (int)$Td2[2])));
			$url = "&n=".$n."&periode=intervalle&d1=".$id1."&d2=".$id2."";
			if($n<>1)
			echo '<center><font size="4">Liste des '.$n.' meilleurs consommateurs de la p&eacute;riode du '.$id1.' au '.$id2.'</font></center>';
			else echo '<center><font size="4">Le meilleur consommateurs de la p&eacute;riode du '.$id1.' au '.$id2.'</font></center>';
		}else
			echo '<center><font color="red" size="4">Date(s) non conforme(s)!</font></center>';
			
	}
	
	if(count($nMeilleurs))
	{
		$page_count = page_count(count($nMeilleurs));
		
		$page = page_get($page_count);
		$page_start = ($page - 1) * DEFAULT_PAGE_SIZE;	
		$navbar = '<div class="navbar">'
			.'<div class="pages">Page: '.page_build_menu('?page=gestioncredits&spage=consommations_credits&stat=nmeilleurs'.$url.'&p=', $page, $page_count).'</div>'
			.'</div>';
		echo $navbar;
		echo '<br><br><table class="list"><thead><tr>'
				."<td>Rang</td><td>ID du client</td><td>Nom</td><td>Prenom</td><td>Consommation</td>"
				.'</tr></thead><tbody>';
		for($i=$page_start; $i< min(count($nMeilleurs),$page_start+DEFAULT_PAGE_SIZE); $i++)
		{
			$result = mysql_query(" SELECT * FROM identite where numero='".$nMeilleurs[$i][0]."' ;");
			$client = mysql_fetch_array($result);
			echo '<tr>';
			echo '<td align="center">'.($i+1).'</td>';
			echo '<td align="center">'.$client['numero'].'</td>';
			echo '<td align="center">'.$client['nom'].'</td>';
			echo '<td align="center">'.$client['prenom'].'</td>';
			echo '<td align="center">'.$nMeilleurs[$i][1].'€</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
		echo $navbar;
	}
}

?>