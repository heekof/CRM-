<br>    <br>   <br>

<?php
if(isset($a) && $a=="delete")
{

	if(isset($av) && $av=="ok")
	{
		$query = "delete from baseclient";
		$query  .= " where nombase = '".$lenom."' ";
		$result = mysql_query($query) or die ("Erreur : ".mysql_error());

		if($result)
			echo '<br ><br ><br ><center><b>'.htmlentities('Entrée supprimée !!').'</b></center><br >';
		else
		echo '<br ><br ><br ><center><b>'.htmlentities('Erreur lors de la suppression !!').'</b></center><br >';
	}else
	{
		$title = 'Suppression d\'une entrée de la base';
	
	// Affiche simplement un message dissuasif
	echo '<div class="warning">'
		.'<div class="title">Attention !</div>'
		.'<p>Vous &ecirc;tes sur le point de supprimer la base <b>'.$lenom.'</b>.<br />'
		.'Cette op&eacute;ration est irr&eacute;versible.<br />'
		.'&Ecirc;tes vous certain de vouloir continuer ?</p>'
		.'<div class="buttons">'
		.'<form method="post" action="?page=mailling&amp;spage=basemodif&amp;a=delete">'
		.'<input type="hidden" name="av" value="ok" />'
		.'<input type="hidden" name="lenom" value="'.$lenom.'" />'
		.'<input type="submit" value="Oui" />'
		.'</form>'
		.'<form method="get" action="">'
		.'<input type="button" value="Non" onclick="history.back();"/>'
		.'</form>'
		.'</div>'
		.'</div>';
	}
}
require_once('lib/paging.php');


$base_url = '';
$query = " SELECT distinct nombase FROM baseclient ";
 
$r = mysql_query($query);


if($nb = mysql_num_rows($r))
	$page_count = page_count($nb);
else 
	$page_count = 1;
$page = page_get($page_count);
$page_start = ($page - 1) * DEFAULT_PAGE_SIZE;

$navbar = '<div class="navbar">'
		.'<div class="pages">Page: '.page_build_menu('?page=mailling&spage=basemodif&p=', $page, $page_count).'</div>'
		.'</div>';

$query = " SELECT distinct nombase,numero FROM baseclient ";
 $query .= " group by nombase "
		.' LIMIT '.$page_start.','.DEFAULT_PAGE_SIZE;
		

$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
$i = "0";

if($mysql_result = mysql_query($query))
{
	echo $navbar;
 ?>
	<table border="0" width="90%"  align="center">
         
    <tr align="center" BGCOLOR="#C0C0C0" >
        <td><b> Nom base </b> </td>      
		<td width="30%" ><b> voir </b> </td>   <td width="30%"> <b> Supprimer </b> </td>
	</tr>
<?php
$i = 0;
while($row = mysql_fetch_array($mysql_result))
{
    //$numero = ($row["numero"]);
    $nombase = ($row["nombase"]);
    // $etat = ($row["etat"]);

?>

	<tr align="center" <?php echo 'class="ligne_'.($i%2).'"'?>>
		<td>  <?php print("$nombase");   ?>   </td>                  
		<td> <a href="?page=mailling&amp;spage=voirbase&lenom=<?php print("$nombase")?>"><font color="#996600" size="2" > Go </font> </a>  </td>   
		<td> <a href="?page=mailling&amp;spage=basemodif&lenom=<?php print("$nombase")?>&a=delete"><font color="#996600" size="2" >  Go </font> </a> </td>
	</tr>
<?php
$i++;
}
?>
</table>
<?php
	echo $navbar;
}else
	echo '<p class="error">Erreur lors de la requête MySQL.</p>';
?>


