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

<form name="form1" action="test.php" method="post"   enctype="multipart/form-data">
<table class="form">
<body>
    
      
<thead><td colspan="2">   Ajout d'un contrat :   </td></thead>

<tr>

  <td>     <label> type de client </label> </td>
  <td>    	  <label>a un compte  <input type="radio"  name="choix" value="1" /></label>  
        <label>n'a pas de compte <input type="radio" name="choix" value="0" /></label>  </td>
       
</tr>


         
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
require_once('config.php');// à changer sur le serveur
require_once('lib/mysql.php');
mysql_auto_connect();

?>
 <form name="options"  >
<tr  style="display:none" id="ma_ligne"  >
            
            <td  >     <label  > selectionner un client </label> </td>
            <td >
                            <input type="text"  name="input1" value="" onKeyUp="autoComplete(this,this.form.options,'value',true)">





                                           <select name="options"  id="oui"  onchange="this.form.input1.value=this.options[this.selectedIndex].value">
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
       
 </form>

<tr style="display:none" id="ma_ligne2"  >
			<td>     <label  > taper l'adresse mail du client  </label>     </td>
			
			<td > 
			
			
			  <label  >adresse email pas compte   </label>
			  <input name="emailsanscompte" id="non" type="text" />
            
			</td>
		
			
</tr>
        
<script type="text/javascript">
        var oui = document.form1.choix[0];
        var non = document.form1.choix[1];
        document.getElementById("ma_ligne").style.display = "none"
		document.getElementById("ma_ligne2").style.display = "none"
		
	
		
		oui.onclick = function() {
            document.getElementById("ma_ligne").style.display = "block"
			document.getElementById("ma_ligne2").style.display = "none"
        };
        non.onclick = function() {
            document.getElementById("ma_ligne").style.display = "none"
			document.getElementById("ma_ligne2").style.display = "block"
        };
    </script>

</body>	 


 
 <?php // method="post" : c'est la méthode la plus utilisée pour les formulaires car elle permet d'envoyer un grand nombre d'informations. Les données saisies dans le formulaire ne transitent pas par la barre d'adresse.
//action : c'est l'adresse de la page ou du programme qui va traiter les informations (réponse au problème n°2). Cette page se chargera de vous envoyer un e-mail avec le message si c'est ce que vous voulez, ou bien d'enregistrer le message avec tous les autres dans une base de données.
//Cela ne peut pas se faire en HTML et CSS, on utilisera en général un autre langage dont vous avez peut-être entendu parler : PHP?> 

    
	

	 
 	 
 

<tfoot>

<tr>
	<td class="label">   <input type="submit" value="Envoyer le fichier" />   </td>
	<td class="label1">    <input type="file" name="monfichier" />  </td>
</tr>

</tfoot>






</table>


</table>
</form>




</html>
