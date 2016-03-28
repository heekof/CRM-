<!DOCTYPE html>
<html>
<?php
require_once('lib/form.php');
require_once('lib/check.php');
require_once('lib/paging.php');

//require_once('lib/date.php');
//$connexion=mysql_connect('localhost','root',"") or die ("connexion impossible.");
//$db=mysql_select_db('fcjo',$connexion) or die ("base de données non accessible");
?>

<form name="form1" action="./spages/stocker_fichier.php" method="post"   enctype="multipart/form-data">
<table class="form">
<body>
    
      
<thead><td colspan="2">   Sauvegarde d'un contrat :   </td></thead>




<tfoot>

<tr>
	<td class="label">   <input type="submit" value="Envoyer le fichier" />   </td>
	<td class="label1">    <input type="file" name="monfichier" />  </td>
</tr>

</tfoot>
</form>




</html>