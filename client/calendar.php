<?php
//calendar.php
//Check if the month and year values exist
require_once('date.php');
require ('../connecte/base.php');

if ((!$_GET['month']) && (!$_GET['year'])) {
	$month = (date ("n") < 10)? date ("0n") : date ("n");
	$year  = date ("Y");
} else {
$month = max(1, min(12, (int)$_GET['month']));
$year = max(1900, min(2050, (int)$_GET['year']));
}
//Calculate the viewed month.
$timestamp = mktime (0, 0, 0, $month, 1, $year);
$monthname = date("F", $timestamp);
//Pour Naviguer entre les mois
$moisSuiv = mois_suiv_prec($year,$month,1);
$moisPrec = mois_suiv_prec($year,$month,0);

//On cherche tous les RDV du mois en cours
$result_numcli = mysql_query(" select numetrang from crm where numero='$centrex2' ;");
$row_numcli = mysql_fetch_array($result_numcli);

$liste_crm = mysql_query(" select * from crm where numetrang='".$row_numcli["numetrang"]."' ;");

$ensemble = "";
while($row = mysql_fetch_array($liste_crm))
{
	$ensemble .= "'".$row['numero']."',";
}
$ln = strlen($ensemble);
if($ln)
	$ensemble = substr($ensemble,0,$ln-1);
//$nb_rdv = $ensemble;

$r_rdv = mysql_query(" select dateheure, lieu, idcommercial from ficherdv where numcrm IN (".$ensemble.") ;");
//$nb_rdv = mysql_num_rows($r_rdv);

$nb_rdv  = "";
$liste_dates = array();
$liste_lieus = array();
$liste_comcio = array();
while($rdv = mysql_fetch_array($r_rdv))
{
	$date1 = explode(' ',$rdv['dateheure']);
	$date2 = explode('-',$date1[0]);
	$liste_dates[] = $date2[2]."/".$date2[1]."/".$date2[0];
	$nb_rdv .= $date2[2]."/".$date2[1]."/".$date2[0];
	$nb_rdv .= ";";
	$liste_lieus[] = $rdv['lieu'];
	$liste_comcio[] = $rdv['idcommercial'];
}

//Now let's create the table with the proper month.
?>
<table style="width: 105px; border-collapse: collapse;" border="1"
cellpadding="3" cellspacing="5" bordercolor="#000000">
<!--tr style="background: #FFBC37;">
	<td><?php //echo "Nombre de RDV : ".$nb_rdv; ?></td>
<tr-->
<tr style="background: #CCCCCC;">
<td><a href="javascript://" onclick="showHideCalendar2('<?php echo $moisPrec[0];?>','<?php echo $moisPrec[1];?>')"><b><<</b></a></td>
<td colspan="5" style="text-align: center;" onmouseover="this.style.background=#E6E6E6'" onmouseout="this.style.background='#CCCCCC'">
<b><?php echo htmlentities($Tabmois[$month])." ".$year; ?></b>
</td>
<td><a href="javascript://" onclick="showHideCalendar2('<?php echo $moisSuiv[0];?>','<?php echo $moisSuiv[1];?>')"><b>>></b></a></td>
</tr>
<tr style="background: #CCCCCC;">
<td style="text-align: center; width: 15px;" onmouseover="this.style.background= '#E6E6E6'" onmouseout="this.style.background='#CCCCCC'">
<b>Di</b>
</td>
<td style="text-align: center; width: 15px;" onmouseover="this.style.background='#E6E6E6'" onmouseout="this.style.background='#CCCCCC'">
<b>Lu</b>
</td>
<td style="text-align: center; width: 15px;" onmouseover="this.style.background='E6E6E6'" onmouseout="this.style.background='#CCCCCC'">
<b>Ma</b>
</td>
<td style="text-align: center; width: 15px;" onmouseover="this.style.background='#E6E6E6'" onmouseout="this.style.background='#CCCCCC'">
<b>Me</b>
</td>
<td style="text-align: center; width: 15px;" onmouseover="this.style.background='#E6E6E6'" onmouseout="this.style.background='#CCCCCC'">
<b>Je</b>
</td>
<td style="text-align: center; width: 15px;" onmouseover="this.style.background='#E6E6E6'" onmouseout="this.style.background='#CCCCCC'">
<b>Ve</b>
</td>
<td style="text-align: center; width: 15px;" onmouseover="this.style.background='#E6E6E6'" onmouseout="this.style.background='#CCCCCC'">
<b>Sa</b>
</td>
</tr>
<?php
$monthstart = date("w", $timestamp);
$lastday = date("d", mktime (0, 0, 0, $month + 1, 0, $year));
$startdate = -$monthstart;
//Figure out how many rows we need.
$numrows = ceil (((date("t",mktime (0, 0, 0, $month + 1, 0, $year)) + $monthstart) / 7));
//Let's make an appropriate number of rows.
//for ($k = 1; $k <= $numrows; $k++){
for ($k = 1; $k <= 6; $k++){
?><tr><?php
//Use 7 columns (for 7 days).
for ($i = 0; $i < 7; $i++){
$startdate++;
if (($startdate <= 0) || ($startdate > $lastday)){
//If we have a blank day in the calendar.
?><td style="background: #FFFFFF;">&nbsp;</td><?php
} else {
if($startdate<10)
{
	$startdate = "0".$startdate;
	$date_calendrier = $startdate."/".$month."/".$year;
}
else
	$date_calendrier = $startdate."/".$month."/".$year;
//if ($startdate == date("j") && $month == date("n") && $year == date("Y")){
if (in_array($date_calendrier,$liste_dates)){
	//$startdate = ($startdate < 10)? '0'.$startdate : $startdate;
?><td style="text-align: center; background: #FFBC37;" onmouseover="this.style.background='#FECE6E';" onclick=" checkfortasks ('<?php echo $year . "-" . $month . "-" . $startdate; ?>',event);">
<?php echo $startdate; ?></td><?php
} else {
	//$startdate = ($startdate < 10)? '0'.$startdate : $startdate;
?><td style="text-align: center; background: #A2BAFA;" onmouseover="this.style.background='#CAD7F9';" onmouseout="this.style.background='#A2BAFA';">
<?php echo $startdate; ?></td><?php
}
}
}
?></tr><?php
}
?>
</table>