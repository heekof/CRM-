<?php





// Testons si le fichier a bien �t� envoy� et s'il n'y a pas d'erreur
if (isset($_FILES['monfichier']) AND $_FILES['monfichier']['error'] == 0)
{ echo 'le fichier a �t� envoy� sans soucis';
        // Testons si le fichier n'est pas trop gros
        if ($_FILES['monfichier']['size'] <= 1000000)
        {
		
		
		        echo 'votre fichier est inf�rieur � 1MB';
                // Testons si l'extension est autoris�e
                $infosfichier = pathinfo($_FILES['monfichier']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('txt', 'pdf', 'gif', 'png');
                if (in_array($extension_upload, $extensions_autorisees))
                {
                echo ' extension autoris�e';
				// On peut valider le fichier et le stocker d�finitivement
                move_uploaded_file($_FILES['monfichier']['tmp_name'], 'uploads/' . basename($_FILES['monfichier']['name']));
                echo "L'envoi a bien �t� effectu� !";
                }
        }
}



?>
<html>

