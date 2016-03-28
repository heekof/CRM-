<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="imagetoolbar" content="no">
<title>Publicite</title>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<meta name="content-language" content="fr">


<script type="text/javascript" src="editeur/ckeditor.js"></script>
<script src="sample.js" type="text/javascript"></script>
<link href="sample.css" rel="stylesheet" type="text/css" />

	</head>
<body >

	<form action="#" method="post">
	<p>
		    <label for="editor1" style="font-family:verdana; font-size:11px;">Nom de la publicite:</label><br><br>
			<input class="ckeditor" style="width:355px;" id="objet" value="<?php echo $obj;?>" name="objet"><br><br>
			<label for="editor1" style="font-family:verdana; font-size:11px;">Contenue de la publicite:</label><br><br>
			<textarea class="ckeditor"  cols="10" id="editor1" name="editor1" rows="5"><?php echo $message;?></textarea>
		</p>
		<p>
			<input type="submit" value="valider">
			<input type="hidden" name="mail">
			<input type="hidden" name="adr" value="<?php echo $email;?>">
		</p>
	</form>
</body>
</html>