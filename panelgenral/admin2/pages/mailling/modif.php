<?php
require_once('lib/form.php');
require_once('lib/paging.php');
require("haut.php");
echo "<center><font size='4'>Liste des mails envoy&eacute;s</font></center>";

$query = "select * from lesmails ";
$r = mysql_query($query) or die ("Erreur : ".mysql_error());
	
if ($nb = mysql_num_rows($r))
	$page_count = page_count($nb);
else
	$page_count = 1;
$page = page_get($page_count);
$page_start = ($page - 1) * DEFAULT_PAGE_SIZE;

$navbar = '<div class="navbar">'
			.'<div class="pages">Page: '.page_build_menu('?page=mailling&amp;spage=modif&p=', $page, $page_count).'</div>'
			.'</div>';

$query .= ' LIMIT '.$page_start.','.DEFAULT_PAGE_SIZE.';';
if($result = mysql_query($query))
{
	echo $navbar;
		echo '<br><br><table class="list"><thead><tr>'
				."<td></td><td>Type</td><td>De</td><td>&Agrave;</td><td>Objet</td><td>Date</td><td>Modifi&eacute;</td>"
				.'</tr></thead><tbody>';
	while($row = mysql_fetch_array($result))
	{
		$type = $row['type'];
		
		if(date('Y-m-d',time())==substr($row['date'],0,10))
		{
			$T = explode(' ',$row['date']);
			$Tdate = explode(':',$T[1]);
			$date = 'Aujourd\'hui &agrave; '.$Tdate[0].'h'.$Tdate[1];
		}else
		{
			$T = explode(' ',$row['date']);
			$Tdate = explode('-',$T[0]);
			$Theure = explode(':',$T[1]);
			$date = $Tdate[2].'/'.$Tdate[1].'/'.$Tdate[0].' &agrave; '.$Theure[0].'h '.$Theure[1].'mn '.$Theure[2].'s';
		}
		if(date('Y-m-d',time())==substr($row['datemodif'],0,10))
		{
			$T = explode(' ',$row['date']);
			$Tdate = explode(':',$T[1]);
			$datemodif = 'Aujourd\'hui &agrave; '.$Tdate[0].'h'.$Tdate[1];
		}else
		{
			$T = explode(' ',$row['date']);
			$Tdate = explode('-',$T[0]);
			$Theure = explode(':',$T[1]);
			$datemodif = $Tdate[2].'/'.$Tdate[1].'/'.$Tdate[0].' &agrave; '.$Theure[0].'h '.$Theure[1].'mn '.$Theure[2].'s';
		}
		
		echo '<tr>';
		echo '<td><input type="checkbox" name="liste[]" value="'.$row['numero'].'"></td>';
		echo '<td>'.$type.'</td>';
		echo '<td>'.$row['expediteur'].'</td>';
		if($type="Test") echo '<td>'.$row['destinataire'].'</td>';
		else echo '<td> base : '.$row['destinataire'].'</td>';
		echo '<td><a href="?page=mailling&modif=ok&idmail='.$row['numero'].'">'.stripslashes($row['objet']).'</a></td>';
		echo '<td>'.$date.'</td>';
		echo '<td>'.$datemodif.'</td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
	echo $navbar;
}
?>