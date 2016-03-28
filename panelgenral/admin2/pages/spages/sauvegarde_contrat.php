
<?php
require_once('lib/form.php');
require_once('lib/check.php');
require_once('lib/paging.php');

?>
<form method="post" action="" enctype="multipart/form-data">
<table class="form">
<body>   
<thead><td colspan="2">   Sauvegarde d'un contrat :   </td></thead>
<tfoot>

<tr>
	<td>    <input type="file" name="monfichier" />  </td>
	<td>   
	<input type="hidden" name="f" value="1">
	<input type="submit" value="Envoyer le fichier" />   
	</td>
</tr>

</tfoot>
</form>
<?php

if (isset ($_POST['f'])){
  if (isset($_FILES['monfichier']) AND $_FILES['monfichier']['error'] == 0)
{	
        // Testons si le fichier n'est pas trop gros
        if ($_FILES['monfichier']['size'] <= 1000000)
        {
                // Testons si l'extension est autorisée
                $infosfichier = pathinfo($_FILES['monfichier']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('pdf');
                if (in_array($extension_upload, $extensions_autorisees))
                {
                        // On peut valider le fichier et le stocker définitivement
                        move_uploaded_file($_FILES['monfichier']['tmp_name'], './pages/spages/upload_contrat/' . basename($_FILES['monfichier']['name']));
						
                        //echo "L'envoi a bien été effectué !";
						?><script type="text/javascript">alert("L'envoi a bien été effectué !")</script>
						<?php
                }
				else{?>    
				    <script type="text/javascript">alert("Erreur d'extension")</script>;
      <?php 
				}
	   }       
}


}

?>




