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







<head>
    <meta charset="UTF-8">
    <title></title>
    <style type="text/css">
        #hidden { display: none; }
    </style>
</head>


<table class="form">
<body>
    <form name="form1">
      


<tr>
<td>    	  <label>a un compte  <input type="radio"  name="choix" value="1" /></label>  </td>
  <td>      <label>n'a pas de compte <input type="radio" name="choix" value="0" /></label>  </td>
       
</tr>

<div id="oui">
         
<script type="text/javascript">

function autoComplete (field, select, property, forcematch) {
        var found = false;
        for (var i = 0; i < select.options.length; i++) {
        if (select.options[i][property].toUpperCase().indexOf(field.value.toUpperCase()) == 0) {
                found=true; break;
                }
        }
        if (found) { select.selectedIndex = i; }
        else { select.selectedIndex = -1; }
        if (field.createTextRange) {
                if (forcematch && !found) {
                        field.value=field.value.substring(0,field.value.length-1); 
                        return;
                        }
                var cursorKeys ="8;46;37;38;39;40;33;34;35;36;45;";
                if (cursorKeys.indexOf(event.keyCode+";") == -1) {
                        var r1 = field.createTextRange();
                        var oldValue = r1.text;
                        var newValue = found ? select.options[i][property] : oldValue;
                        if (newValue != field.value) {
                                field.value = newValue;
                                var rNew = field.createTextRange();
                                rNew.moveStart('character', oldValue.length) ;
                                rNew.select();
                                }
                        }
                }
        }

</script>

<?php
require_once('C:\Program Files\EasyPHP-5.3.9\www\panelgenral\admin2\config.php');
require_once('lib/mysql.php');
mysql_auto_connect();
if(isset($_GET['rech_from'])){ $rech_from = $_GET['rech_from'];}
else {$rech_from = 'numero';} 
echo "Rechercher par $rech_from\n";
?>

<input type="text" name="input1" value="" onKeyUp="autoComplete(this,this.form.options,'value',true)">



<tr>
<td>
<select name="options" onchange="this.form.input1.value=this.options[this.selectedIndex].value">
<?php
        $sql = mysql_query("SELECT * FROM identite");
        while($cli = mysql_fetch_array($sql)){
         if($_GET['rech_from'] == numero)
          echo '<option value="'.$cli['email'].'" >'.$cli['prenom'].' '.$cli['nom'].'</option>';

         if($_GET['rech_from'] == nom)
           echo '<option value="'.$cli['nom'].'" >'.$cli['prenom'].' '.$cli['nom'].'</option>';

         if($_GET['rech_from'] == prenom)
           echo '<option value="'.$cli['email'].'" >'.$cli['prenom'].' '.$cli['nom'].'</option>';

         else
echo '<option value="'.$cli['email'].'" >'.$cli['prenom'].' '.$cli['nom'].'</option>';

        }
?>
              

</select>

</td>

</tr>			  
        </div>
		
		
		
		
	
		
		
		<div id="non">
            <label>adresse email pas compte<input type="text" /></label>
        </div>
	</form>
    <script type="text/javascript">
        var oui = document.form1.choix[0];
        var non = document.form1.choix[1];
        document.getElementById("non").style.display = "none"
		document.getElementById("oui").style.display = "none"
		
		
		
		oui.onclick = function() {
            document.getElementById("oui").style.display = "block"
			document.getElementById("non").style.display = "none"
        };
        non.onclick = function() {
            document.getElementById("oui").style.display = "none"
			document.getElementById("non").style.display = "block"
        };
    </script>
</body>	 

<form action="newfacture.php" method="post" enctype="multipart/form-data">
    <p>
	
	Ajout d'un contrat :
	    <br />
                <input type="file" name="monfichier" /><br />
	 </p>	
 <?php // method="post" : c'est la méthode la plus utilisée pour les formulaires car elle permet d'envoyer un grand nombre d'informations. Les données saisies dans le formulaire ne transitent pas par la barre d'adresse.
//action : c'est l'adresse de la page ou du programme qui va traiter les informations (réponse au problème n°2). Cette page se chargera de vous envoyer un e-mail avec le message si c'est ce que vous voulez, ou bien d'enregistrer le message avec tous les autres dans une base de données.
//Cela ne peut pas se faire en HTML et CSS, on utilisera en général un autre langage dont vous avez peut-être entendu parler : PHP?> 

    <p> 
        <label for="pseudo">adresse mail du contact :</label>
        <input type="text" name="pseudo" id="pseudo" placeholder="ici l'adresse mail" size="30" maxlength="30" />
    </p>
	// je n'arrive pas a afficher en fonction des boutons radios 
	liste 

<p> 
            <br/>				<input type="submit" value="Envoyer le fichier" />
	         <br/> 
	</p>
  </FORM>
 	taper le mail :
	 </br>
	 
<form onsubmit="return checkFormFact(); >
<TEXTAREA name="nom" rows=8 cols=60>tapez ici le mail</TEXTAREA>
	 
	 </br>
</form>	 	 
<?php echo'affichage email du client selectionné :'; ?>	 



</table>



<?php
require_once('lib/form.php');
require_once('lib/check.php');
require_once('lib/paging.php');
//require_once('lib/date.php');

//Titre
$title = 'Création d\'un contrat';


include("excel/Classes/PHPExcel.php");
include("excel/Classes/PHPExcel/Writer/Excel5.php");
 
$workbook = new PHPExcel;
 
$sheet = $workbook->getActiveSheet();
 
$col=0;
$lig=2;
 
$mysql_server = '192.168.137.25';
$mysql_user = 'root';
$mysql_password = 'kalonji';
$mysql_db = 'testcentrex';
$mysql_link = mysql_connect($mysql_server, $mysql_user, $mysql_password);
mysql_select_db($mysql_db, $mysql_link);
?>
<p>Choisissez un client: </p>
  
// liste déroulante alimentée par mySQL.
  
<?php
echo '<select size=1 name="cat">'."\n"; 
echo '<option value="-1">Choisir un résultat<option>'."\n";  
 $reglog=mysql_query("select * from identite ") or die ("requète non executé");


while( $resultat = mysql_fetch_row($reglog))
{
 
 echo '<option value="'.$resultat[0].'">'.$resultat[1];// email =8
    echo '</option>'."\n";
}

echo '</select>'."\n";

echo " <br /> " ;
echo ' ici afficher l\'email du contact';
			
			
			
			

mysql_close();
?>





</html>
