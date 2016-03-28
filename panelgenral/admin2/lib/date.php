<?php /* date.php */
$Tabmois = array();
$Tabmois[1] = "Janvier";
$Tabmois[]  = "Février";
$Tabmois[]  = "Mars";
$Tabmois[]  = "Avril";
$Tabmois[]  = "Mai"; 
$Tabmois[]  = "Juin"; 
$Tabmois[]  = "Juillet"; 
$Tabmois[]  = "Août";
$Tabmois[]  = "Septembre";
$Tabmois[]  = "Octobre";
$Tabmois[]  = "Novembre";
$Tabmois[]  = "Décembre";

$Tabjours = array();
$Tabjours[] = "Dimanche";
$Tabjours[] = "Lundi";
$Tabjours[] = "Mardi";
$Tabjours[] = "Mercredi";
$Tabjours[] = "Jeudi";
$Tabjours[] = "Vendredi";
$Tabjours[] = "Samedi";

$mois_de_31jrs = array();
$mois_de_31jrs[] = 1;
$mois_de_31jrs[] = 3;
$mois_de_31jrs[] = 5;
$mois_de_31jrs[] = 7;
$mois_de_31jrs[] = 8;
$mois_de_31jrs[] = 10;
$mois_de_31jrs[] = 12;

$mois_de_30jrs[] = 4;
$mois_de_30jrs[] = 6;
$mois_de_30jrs[] = 9;
$mois_de_30jrs[] = 11;

$auj = getdate();
	
$auj_j = $auj['mday'];
$auj_m = $auj['mon'];
$auj_a = $auj['year'];
$auj_wd = $auj["wday"] ;

//$auj_mysql = date('Y-m-d H:i:s',mktime(0, 0, 0, $auj_m, $auj_j, $auj_a));
$auj_mysql = date('Y-m-d H:i:s',time());
$auj_fr = date('d/m/Y',time());

// Transforme une chaîne de caractères en date (timestamp unix)
// Retourne false en cas d'erreur
function date_get($text)
{
	$text = trim($text);
	
	if (preg_match('@^(0?[1-9]|[1-2][0-9]|3[01])/(0?[1-9]|1[012])/([0-9]{4})$@', $text, $matches) > 0)
	{
		$day = (int)$matches[1];
		$month = (int)$matches[2];
		$year = (int)$matches[3];
		
		if (checkdate($month, $day, $year))
			return mktime(0, 0, 0, $month, $day, $year);
		else
			return false;
	}
	else
		return false;
} 

// Retourne le nombre (relatif) de jours entre deux dates
/* jaafar
function date_diff($date1, $date2)
{
	// 86400 sec = 24h * 3600 sec = 24h * 60 min * 60 sec
	return round(($date1 - $date2) / 86400);
}
    */
// Ajoute 1 mois à la date
function date_add_month($timestamp)
{
	$date = getdate($timestamp);
	
	$day = $date['mday'];
	$month = $date['mon'];
	$year = $date['year'];
	
	if ($month == 12)
		$month = 1;//JEAN ETIENNE : JE PENSE QU'IL FAUT AJOUTER 1 ANS DANS CE CAS :   $year++  ; car on était en décembre
	else
		$month++;
	
	// Soustrait un jour jusqu'à trouver une date valide (gère les fins de mois)
	while (!checkdate($month, $day, $year))
		$day--;
	
	return mktime(0, 0, 0, $month, $day, $year);
}

// Formatte la date au format MySQL
function date_mysql_format($timestamp)
{
	return date('Y-m-d', $timestamp);
}
//Donne la date d'il ya n jours
function date_ilya_njours($n,$date,$avant)
{
	$today = $date;//Date du d'aujourd'hui
	$year = $today["year"] ; 
	$month = $today["mon"] ;
	$day = $today["mday"] ;
	
	if($n == 0) return mktime(0, 0, 0, $month, $day, $year);
if(!$avant)
{
	if($n < $day) return mktime(0, 0, 0, $month, $day-$n, $year);
	if($n == $day)
	{
		if($month == 1) return mktime(0, 0, 0, 12, 31, $year-1);
		if($month ==2 || $month == 4 || $month == 6 || $month == 8 || $month == 9 || $month == 11) 
			return mktime(0, 0, 0, $month-1, 31, $year);
		if($month == 3 && bissextile($year)) return mktime(0, 0, 0, 2, 29, $year);
		if($month == 3) return mktime(0, 0, 0, 2, 28, $year);
		if($month == 5 || $month == 7 || $month == 10 || $month == 12) return mktime(0, 0, 0, $month-1, 30, $year);
	}
	
	if($n > $day)
	{
		$n -= $day;
		$d  = getdate(date_ilya_njours($day,$date,$avant));
		return date_ilya_njours($n,$d,$avant);
	}
}else
{
	if($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 7 || $month == 10 || $month == 12)
	$totaljour = 31;
	elseif($month == 4 || $month == 6 || $month == 9 || $month == 11) 
	$totaljour = 30;
	elseif(bissextile($year))
		$totaljour = 29;
	else $totaljour = 28;
	
	
	if($n <= ($totaljour - $day) ) return mktime(0, 0, 0, $month, $day+$n, $year);
	if($n == ($totaljour - $day + 1))
	{
		if($month == 12) return mktime(0, 0, 0, 1, 1, $year+1);
		return mktime(0, 0, 0, $month+1, 1, $year);
		
		if($month ==2 || $month == 4 || $month == 6 || $month == 8 || $month == 9 || $month == 11) 
			return mktime(0, 0, 0, $month-1, 31, $year);
		if($month == 3 && bissextile($year)) return mktime(0, 0, 0, 2, 29, $year);
		if($month == 3) return mktime(0, 0, 0, 2, 28, $year);
		if($month == 5 || $month == 7 || $month == 10 || $month == 12) return mktime(0, 0, 0, $month-1, 30, $year);
	}
	
	if($n > ($totaljour - $day + 1))
	{
		$n -= ($totaljour - $day+1);
		$d  = getdate(date_ilya_njours(($totaljour - $day + 1),$date,$avant));
		return date_ilya_njours($n,$d,$avant);
	}
}
}

function bissextile($year)
{
	if(($year % 4)==0) return true;
	return false;
}
function get_semaine()
{//PAS ECHEVE
	
}
/**************************/
/**
AFFICHE DATE
*/
function afficheDate()
{
	$auj = getdate();
	$a = $auj["year"] ; 
	$m = $auj["mon"] ;
	$md = $auj["mday"] ;
	$wd = $auj["wday"] ;
	return htmlentities($Tabjours[$wd].' , '.$md.' '.$Tabmois[$m].' '.$a);
}
?>