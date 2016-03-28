<!DOCTYPE html>
<html>
<?php





// Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
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
                        move_uploaded_file($_FILES['monfichier']['tmp_name'], './upload_contrat/' . basename($_FILES['monfichier']['name']));
                        echo "L'envoi a bien été effectué !";
                }
				else?>    
				    <script type="text/javascript" >           alert("hello suri ")                 </script>;
      <?php   
	 header("Location: sauvegarde_contrat.php");
	   }       
}

?>
</html>