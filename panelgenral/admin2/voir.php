<?php /* voir.php */

// Conteneur spécial pour les factures

if ($page != 'suppcourriel')
	$page = 'suppcourriel';

?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
		<link rel="stylesheet" type="text/css" href="style/default.css" />
	</head>
	<body>
		<div id="logo" style="width:100%;height:40px"><img src="images/logo6.gif" width="100%"alt="Solutions Standard et IP Centrex" border="0" /></div>
		<div id="facture">
<?php include('scripts/'.$page.'.php') ?>
		</div>
	</body>
</html>
