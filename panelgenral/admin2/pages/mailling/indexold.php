<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" title="Design" href="../design.css" type="text/css" media="screen" />
<!-- TinyMCE -->
<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		skin : "o2k7",
		skin_variant : "silver",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		/*Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}*/
	});
</script>
<!-- /TinyMCE -->

</head>
<body>

<?php
require("haut.php");
?>

<form action="?page=mailling&spage=maillingenerale" method="post"   >
<?php
	if(isset($modif) && $modif=="ok")
	{
		echo '<input type="hidden" name="modif" value="ok">';
		echo '<input type="hidden" name="idmail" value="'.$idmail.'">';
		
		$query = "select * from lesmails where numero='$idmail' ;";
		if($result = mysql_query($query) or die ("Erreur : ".mysql_error()))
		{
			while($row = mysql_fetch_array($result))
			{
				$type = $row['type'];
				$exp = $row['expediteur'];
				$dest = $row['destinataire'];
				$obj = $row['objet'];
				$msg = $row['message'];
				$date = $row['date'];
				$datemodif = $row['datemodif'];
				$idsignature = $row['idsignature'];
			}
		}
	}
?>
<table width="%80" height="470" border="2" align="center" cellpadding="6" cellspacing="0">

<TR>
	<TD><b> Etat </b> </TD>
	<TD>
	Test <INPUT type=radio name="etat" value="1" checked  onclick="document.getElementById('dest').style.display='';">
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
	Production: <INPUT type=radio name="etat" value="2" <?php if($test=="Production") echo 'checked';?> onclick="document.getElementById('base').style.display='';">
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
	Membres (nos clients): <INPUT type=radio name="etat" value="3" <?php if($test=="Membres") echo 'checked';?> onclick="document.getElementById('dest').style.display='none';document.getElementById('base').style.display='none';">
	</TD>
</TR>

<tr>
     <td> <b> Email d envoie </b> </td>
     <td> <input type="text" name="email" size="20" id="dest" value="<?php echo $dest;?>" />
	 &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
	Email de retour (test)  &nbsp; &nbsp; &nbsp;      
<input type="text" name="email1" size="30" value="<?php echo $exp;?>" />
      </td>
</tr>

<tr>
     <td> <b> BASE : </b> </td>
     <td>

     <SELECT name="id_base" id="base">

<?php
//require("base.php");
// nomchamp
$query = " SELECT DISTINCT nombase,numero  FROM baseclient group by nombase ";

$mysql_result = mysql_query($query) or die ("Erreur : ".mysql_error());
while($row = mysql_fetch_array($mysql_result))
{
    $nombase = ($row["nombase"]);
    $monnumero = ($row["numero"]);
?>
<OPTION VALUE="<?php print("$nombase") ?>" <?php if($test=="Production" && $dest==$nombase) echo 'selected';?>>  <?php print("$nombase  ") ?>  </OPTION>
<?php
}
?>
</SELECT>

     </td>
</tr>

  <tr>
    <td><span class="Style1"> <b>Objet :</b> </span></td>
    <td><input type="text" name="objet" size="60" value="<?php  echo stripslashes($obj);?>" /></td>
  </tr>

  <tr>
    <td height="335" colspan="2">

      <textarea style="width:100%;overflow:auto;" rows="15" name="message"><?php echo stripslashes($msg); ?></textarea>    </td>
  </tr>
  
   <tr>
  <td>Signature : </td>
  <td>
	<?php
	$query = "select * from mailparametre;";
		if($result = mysql_query($query) or die ("Erreur : ".mysql_error()))
		{
			echo '<select name="idsignature">';
			while($row = mysql_fetch_array($result))
			{
				$numero = $row['numero'];
				$nom = $row['nom'];
				echo '<option value="'.$numero.'"';
				if($idsignature == $numero) echo ' selected="selected"';
				echo '>'.$nom.'</option>';
			}
			echo '</select>';
		}
	?>
  </td>
  </tr>
  
  <tr>
  <td><input type="submit" value="ENVOYER"   /></td>
  <td></td>
  </tr>

</table>

</form>
</body>
</html>