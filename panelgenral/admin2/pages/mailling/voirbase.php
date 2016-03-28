<br><br><br>
<?php
if(isset($a) && $a=="add")
{
	$query = " insert into baseclient (nom,prenom,email,nombase) "
		." values('$nom','$prenom','$email','$lenom') ";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());

if($mysql_result)
	echo '<br /><br /><br /><center><h3>'.htmlentities('Entrée ajoutée avec succès  !!').'</h3></center><br />';
}
if(isset($a) && $a=="update")
{
	$query = " UPDATE baseclient SET "
		." nom='$nom',prenom='$prenom',email='$email' "
	    ." where numero = '$lenum' ";
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());

if($mysql_result)
	echo '<br /><br /><br /><center><h3>'.htmlentities('Entrée modifié avec succès  !!').'</h3></center><br />';
}
if(isset($a) && $a=="delete")
{

	if(isset($av) && $av=="ok")
	{
		$query = "delete from baseclient";
		$query  .= " where numero = '".$lenum."' ";
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
		.'<p>Vous &ecirc;tes sur le point de supprimer l\'entrée numéro '.$lenum.'.<br />'
		.'Cette op&eacute;ration est irr&eacute;versible.<br />'
		.'&Ecirc;tes vous certain de vouloir continuer ?</p>'
		.'<div class="buttons">'
		.'<form method="post" action="?page=mailling&amp;spage=voirbase&amp;a=delete">'
		.'<input type="hidden" name="av" value="ok" />'
		.'<input type="hidden" name="lenom" value="'.$lenom.'" />'
		.'<input type="hidden" name="lenum" value="'.$lenum.'" />'
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
$r = mysql_query(" SELECT count(*)  from baseclient where nombase = '".$lenom."' ; ");
// $query .= " FROM cdr  where src  = '$numvice' order by numero desc ";
// $query .= " FROM cdr  where channel like '%$numvice%' order by numero desc ";

if($row = mysql_fetch_row($r))
	$page_count = page_count($row[0]);
else 
	$page_count = 1;
$page = page_get($page_count);
$page_start = ($page - 1) * DEFAULT_PAGE_SIZE;

$navbar = '<div class="navbar">'
		.'<div class="pages">Page: '.page_build_menu('?page=mailling&spage=voirbase&lenom='.$lenom.''.$base_url.'&p=', $page, $page_count).'</div>'
		.'</div>';
		
$query = " SELECT * FROM baseclient "
		." where nombase = '".$lenom."' "
		.' LIMIT '.$page_start.','.DEFAULT_PAGE_SIZE;
	   
$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
$i = "0";

if($mysql_result = mysql_query($query))
{
	echo $navbar;
 ?>
	<table border="0" width="100%"  align="center">
    <tr align="center" >
		<td colspan="7" style="background:#cccccc;">
			Nom de la Base : <?php echo '<B>'.$lenom.'</B>  |  ';?>
			<a href="?page=mailling&amp;spage=ajoutItemBase&labase=<?php print("$lenom")?>">
				<font color="#996600" size="2" > 
					Ajouter une entrée
				</font>
			</a>
		</td>
    </tr>
    <tr align="center" style="background:#cccccc;">
        <td>Numero </td>   
        <td>Nom </td>   
		<td>Prenom </td>           
		<td> E-mail </td>   
		<td> Modifier </td>   
		<td> Supprimer </td>
    </tr>
<?php
$i = 0;
while($row = mysql_fetch_array($mysql_result))
{
    $numero = ($row["numero"]);
    $nom = ($row["nom"]);
    $prenom = ($row["prenom"]);
    $email = ($row["email"]);
    $nombase = ($row["nombase"]);
                             	       
?>

	<tr align="center" <?php echo 'class="ligne_'.($i%2).'"'?>>
		<td> <?php print("$numero");   ?>   </td>  
		<td> <?php print("$nom");   ?>   </td>  
		<td> <?php print("$prenom");   ?>   </td>  
		<td> <?php print("$email");   ?>   </td>                
		<td> <a href="?page=mailling&amp;spage=editebase&lenom=<?php echo $lenom;?>&lenum=<?php print("$numero")?>"><font color="#996600" size="2" > Go </font></a> </td>   
		<td> <a href="?page=mailling&amp;spage=voirbase&a=delete&lenom=<?php echo $lenom;?>&lenum=<?php print("$numero")?>"><font color="#996600" size="2" > Go </font></a> </td>
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

