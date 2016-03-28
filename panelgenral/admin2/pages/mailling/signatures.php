<?php
require_once('lib/form.php');
require_once('lib/paging.php');
require("haut.php");
echo "<center><font size='4'>Liste des signatures</font></center>";

$query = "select * from mailparametre ";
$r = mysql_query($query) or die ("Erreur : ".mysql_error());
	
if ($nb = mysql_num_rows($r))
	$page_count = page_count($nb);
else
	$page_count = 1;
$page = page_get($page_count);
$page_start = ($page - 1) * DEFAULT_PAGE_SIZE;

$navbar = '<div class="navbar">'
			.'<div class="pages">Page: '.page_build_menu('?page=mailling&amp;spage=signatures&p=', $page, $page_count).'</div>'
			.'</div>';

$query .= ' LIMIT '.$page_start.','.DEFAULT_PAGE_SIZE.';';
if($result = mysql_query($query))
{
	echo $navbar;
		echo '<br><br><table class="list"><thead><tr>'
				."<td width='5%'>Numero</td><td>Nom</td><td>Signature</td><td>Modifier</td>"
				.'</tr></thead><tbody>';
	while($row = mysql_fetch_array($result))
	{
		echo '<tr>';
		echo '<td>'.$row['numero'].'</td>';
		echo '<td>'.$row['nom'].'</td>';
		echo '<td>'.$row['signature'].'</td>';
		echo '<td><a href="?page=mailling&spage=parametrage&modif=ok&idpara='.$row['numero'].'">Go</a></td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
	echo $navbar;
}
?>