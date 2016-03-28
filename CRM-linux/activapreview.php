<head>

        <?php $nb=2;  $p=$xy; ?>
		<title>test</title>
		
		
		
		
	</head>


<form>
<?php
/*$nbchamps=1;//
if($nbchamps > 0 )
{
      Print(" <br> <br> <center> <B> DEFINIR LES CHAMPS ADDITIONNEL </B> </Center>    ");
}
*/
?>
<table border="1" align="center" width="70%">

<?php
//for($a=0; $a < $nbchamps; $a++)
{
// print("nbre de champ $nbchamps  ");

?>
  <!--<tr><td> <br> Nom champ </td>
<td> <input type="text" size="23"  name="nom<?php //print("$a");?>"> </td>
</tr> -->
<?php
}
?>


<?php
//Création des fiches

$qcmexiste=0;
$rdvexiste=0;
$contratexiste=0;
$qbinaireexiste=0;
$argument=0;
//$fiche[0] = 'argument';
if(count($fiche))
{
	for($i=0; $i<count($fiche); $i++)
	{
	 if($fiche[$i] == 'qcm')$qcmexiste=1;
	 if($fiche[$i] == 'rdv')$rdvexiste=1;
	if($fiche[$i] == 'contrat')$contratexiste=1;
	if($fiche[$i] == 'qbinaire')$qbinaireexiste=1;
	if($fiche[$i] == 'argument')$argument=1;
	}
}


if(count($fiche))
{
	for($i=0; $i<count($fiche); $i++)
	
	{
	
	    
		if($fiche[$i] == 'qcm')
		{
		?>
		
		
		   
			<table border="0" align="center" width="70%" id="monqcm" <?php if($qcmexiste == 1) echo 'style="display:block;"'; ?>>
			
			<tr bgcolor="#CCCCCC">
				<td width="100%" align="center">
				<b>Question à choix multiples</b>
				</td>
			</tr>
			
			<tr>
			    
				<td width="100%" align="center">
				  <input type="hidden" id="qcm" name="qcm" value="" style="width:70%"    > 
				   <input type="hidden" id="repQcm" name="repQcm" value="" style="width:70%"    > 
				<!-- <input type="button" value="Ajouter un QCM" onClick="addQcm()"> -->
				</td>
			</tr>
			<?php 
				$nb = (int)$nbchoix;
				 
				for($j=1; $j<=$nb; $j++)
				{
			?>
			<tr>
				<td width="100%">
				Choix<?php echo $j ;?> : <input type="text" name="choix<?php echo $j ;?>" value="" style="width:70%">
				<input type="hidden" name="nbchoix" value="<?php print("$nbchoix")?>" >
				 
				</td>
			</tr>
			
			
			
			
			<?php 
				}
			?>
			</table>
			
			<table  id="mainqcm" border="2" align="center" width="70%" <?php if($qcmexiste == 1) echo 'style="display:block;"'; ?>>
			<tr>
			  <td>
			 <div id="mainContainerQcm"  >  </div>
			  </td>
			</tr>
			
			
			
			
			
			<td   id="boutonqcm" width="100%" align="center">
				
				<input type="button" value="Ajouter une question" onClick="addQcm()">
                				<input type="button" value="Terminer" onClick="terminer()">
			
 			</td>
				
				
				
			</table>
		<?php
		}
		if($fiche[$i] == 'rdv')
		{
		?>
			<table border="2" align="center" width="70%">
				<tr bgcolor="#CCCCCC">
					<td width="100%" align="center"  id="ficherdv" <?php if( $qcmexiste==1 || $qbinaireexiste==1) echo 'style="display:none;"'; else echo 'style="display:block;"';  ?>>
					<b><font id="fiche_rdv" type="hidden" color="green" size="5">Fiche rendez-vous choisi!</font></b>
					<input type="hidden" name="rdv" value="rdv" >
					</td>
				</tr>
			</table>
		<?php
		}
		//if($fiche[$i] == 'rmq'){
		?>
			<!--table border="2" align="center" width="70%"-->
				<!--tr bgcolor="#CCCCCC"-->
					<!--td width="100%" align="center"-->
					<!--b><font color="green" size="5">Fiche remarques choisi!</font></b-->
					<!--input type="hidden" name="rmq" value="rmq" -->
					<!--/td-->
				<!--/tr-->
			<!--/table-->
		<?php
		//}
		//$fiche[$i] = 'qbinaire';
		
		if($fiche[$i] == 'qbinaire')// ici je rajoute le boutton ADD
		{
		?>
			<table border="2" align="center" width="70%" id="mainContainer" <?php if($fiche[$i] == 'qbinaire' && $qcmexiste == 1){ echo 'style="display:none;"';} 
			                                                                     if($fiche[$i] == 'qbinaire' && $qcmexiste == 0){ echo 'style="display:block;"'; } ?> >
			
		<tr bgcolor="#CCCCCC" >
				<td width="100%" align="center" >
				<b>Question binaire (oui/non)          </b>
				</td>
			</tr>
			
			
			
			<tr>
				<td width="100%" align="center">
				  
				
				
			<div >	
			 <input type="hidden" name="qbinaire" value="" style="width:70%">
			
			
			</div>

			</td>
			</tr>
		
				
				<td  id="binaire">
				<input type="button" id="qb1"  value="Ajouter une question binaire" OnClick="add_question_binaire()"   />  
				<!-- <input type="button"   id="qb2"   value="Terminer"  OnClick="terminerqb()"   />  -->
				
				
				
			</table>
			
			
			
		
		
		
		
		
		
		<?php
		}
		if($fiche[$i] == 'contrat'){
		?>
			<table border="2" align="center" width="70%"   id="fichecontrat"  style="display:none;"  >
				<tr bgcolor="#CCCCCC">
					<td width="100%" align="center"  >
					<b><font color="green" size="5">Fiche contrat choisi!</font></b>
					<input type="hidden" name="contrat" value="contrat" >
					</td>
				</tr>
			</table>
		<?php
		}
		// ici le code argument !
	   
		
	}
	
}

?>
	<table id="ficheremarque"  style="display:none;"   border="2" align="center" width="70%">
		<tr bgcolor="#CCCCCC" >
			<td width="100%" id="ficher" align="center">
			<b><font color="green" size="5">Fiche de remarques</font></b>
			<input type="hidden" name="rmq" value="rmq" >
			</td>
		</tr>
	</table>
	

	<table   id="matable" style="display:none;"   border="2" align="center" width="70%"   >
		<tr bgcolor="#CCCCCC">
			<td width="100%" align="center">
				<b>Conseil de la campagne</b>
			</td>
		</tr>
		<tr>
			<td width="100%" align="center">
			<TEXTAREA  id="conseil" name="conseil" rows="4" style="width:80%" >Conseil...</TEXTAREA>
			</td>
		</tr>
	</table>

	
 </table>    <br>
 
 <table border="2" align="center" width="70%" id="submit"  >
   <tr   >   <td align="right" >
	<?php
		  
		$debut  = date('y-m-d',mktime(0, 0, 0, $mdebut, $jdebut, $adebut));
		$fin    = date('y-m-d',mktime(0, 0, 0, $mfin, $jfin, $afin));
		if($argument==0)	// jaafar	
		$etat   = "activapreview2";
		else // jaafar
		$etat   = "jaafar";
	?>
<input type="hidden" name="nomcampagne" value="<?php print("$nomcampagne")?>" >
<input type="hidden" name="nbchamps" value="<?php print("$nbchamps")?>" >
<input type="hidden" name="numetrang" value="<?php print("$numetrang")?>" >
<input type="hidden" name="nomproduit" value="<?php print("$nomproduit")?>" >
<input type="hidden" name="debut" value="<?php print("$debut")?>" >
<input type="hidden" name="fin" value="<?php print("$fin")?>" >
<input type="hidden" name="page" value="<?php print("$etat")?>" >
<input type="hidden" name="mbase" value="<?php print("$mbase")?>" >
<input type="hidden" name="count" value="" id="count">
<input type="hidden" name="counter" value="" id="counter">




  <input  align="right" type="button"   id="qb2" <?php if( $qcmexiste==1 || $qbinaireexiste==0  ) echo 'style="display:none;"'; else echo 'style="display:block;"';  ?>   value="Suivant"  OnClick="terminerqb()"   />
  <input type="submit" value="Suivant" id="sub"  <?php  if( $qcmexiste==1 || $qbinaireexiste==1  ) echo 'style="display:none;"' ?> onclick="suivant();"/>
</form>
</td>   </tr> </table>
<? //if($argument==1)  require("jaafar.php"); ?>



<script type="text/javascript">
			var counter = 0;
			 var counterQcm = 0;
		  var choix = new Array;
			
			
			
			/* bouton ajouter question binaire */
			function add_question_binaire() {
				// Get the main Div in which all the other divs will be added
				var mainContainer = document.getElementById('mainContainer');
				
				
				
				// Create a new div for holding text and button input elements
				var newDiv = document.createElement('div');
				// Create a new text input
				var newText = document.createElement('input');
				newText.type = "input"; 
				newText.name="qbinaire"+counter;
				newText.value = counter;
				newText.style.width ="70%";
				// Create a new button input
				var Bouton_Supprimer_QCM = document.createElement('input');
				Bouton_Supprimer_QCM.type = "button";
				Bouton_Supprimer_QCM.value = "Supprimer une question";
				
				// creation choix 
				
				var newChoix = document.createElement('input');
				newChoix.type = "input"; 
				newChoix.value = counter;
				newChoix.style.width ="70%";
				
				
				// fin choix 
				
				// Append new text input to the newDiv
				newDiv.appendChild(newText);
				//newDiv.appendChild(newChoix);
				
				// Append new button input to the newDiv
				newDiv.appendChild(Bouton_Supprimer_QCM);
				// Append newDiv input to the mainContainer div
				mainContainer.appendChild(newDiv);
				counter++;
				
				// Add a handler to button for deleting the newDiv from the mainContainer
				Bouton_Supprimer_QCM.onclick = function() {
						mainContainer.removeChild(newDiv);
				}
			}
			
			function terminerqb(){
			
		document.getElementById("counter").value = counter;

			fichee="<?php echo $contratexiste ?>";
			ficherdv="<?php echo $rdvexiste ?>";
			ficheremarque="<?php echo $ficheremarqueexiste ?>";
			argument="<?php echo $argument ?>";



if(ficherdv==1 ){
	if(document.getElementById("ficherdv").style.display=="none" ){
document.getElementById("ficherdv").style.display="block";
}
}

//alert("a");

if(document.getElementById("mainContainer").style.display=="block"){
document.getElementById("mainContainer").style.display="none";

}



if(document.getElementById("submit").style.display=="none"  )
document.getElementById("submit").style.display="block";

if(ficheremarque==1){
if(document.getElementById("ficheremarque").style.display=="none"  )
document.getElementById("ficheremarque").style.display="block";
	}	
	
if(document.getElementById("matable").style.display=="none"){
document.getElementById("matable").style.display="block";
}	
	
	
// bouton submit
if(document.getElementById("sub").style.display=="none"  ){
document.getElementById("sub").style.display="block";
}	
	
// bouton termiber
if(document.getElementById("qb2").style.display=="block"){
document.getElementById("qb2").style.display="none";
}	
	}
			/* bouton terminer */
		function terminer(){
		
		if(document.getElementById("mainContainerQcm").style.display=="block")
		document.getElementById("mainContainerQcm").style.display="none";
			
		
		if(document.getElementById("mainqcm").style.display=="block")
		document.getElementById("mainqcm").style.display="none";
	
		 if(document.getElementById("monqcm").style.display=="block")
		 document.getElementById("monqcm").style.display="none";
		
			qcme="<?php echo $qbinaireexiste ?>";
			argument="<?php echo $argument ?>";
			fichee="<?php echo $contratexiste ?>";
			ficherdv="<?php echo $rdvexiste ?>";
		       //alert(qcme);
		var mainContainer = document.getElementById('mainContainerQcm');
		var newDiv = document.createElement('div');
		var obj=document.getElementById('count');
		obj.value=counterQcm;
		var qcm = new Array;
		var repQcm = new Array;
		var i=0;
	
		
		for(i=0;i<choix.length;i++)
			{   
			    //alert(choix[i]);
				var Text = document.createElement('input');
				Text.type = "hidden"; 
				Text.id = i;
				Text.name = "choixj"+i;
				Text.value = choix[i];
				//alert("name is "+Text.name);
				//alert("value is "+Text.value);
				newDiv.appendChild(Text);
			}
			
			mainContainer.appendChild(newDiv);
			
	



		if( qcme == 0 )	
		{
		
if(document.getElementById("matable").style.display=="none"){
document.getElementById("matable").style.display="block";
}
		if(document.getElementById("submit").style.display=="none"){
document.getElementById("submit").style.display="block";}

if(document.getElementById("sub").style.display=="none"){
document.getElementById("sub").style.display="block";}
		
	

////alert("b");
if(ficherdv==1 ){
	if(document.getElementById("ficherdv").style.display=="none" ){
document.getElementById("ficherdv").style.display="block";
}
}	
		
		
		
		}
		else {
		
		if(document.getElementById("mainContainer").style.display=="none"   )
		 document.getElementById("mainContainer").style.display="block";}
		 
		 

	 if(document.getElementById("qb2").style.display=="none" &&   qcme==1  ){
document.getElementById("qb2").style.display="block";

}		 
		 
		
		 
		 
		 
		 
		 }
		
		 
		  /* fonction javascript qui rajoute le(s) QCM */
		function addQcm()
		{        
		        //passage variable php -> javascript non utilisé  
		        nb="<?php echo $nb ?>";
				 
				// Get the main Div in which all the other divs will be added
				var mainContainer = document.getElementById('mainContainerQcm');
						
				// Create a new div for holding text and button input elements
				var newDiv = document.createElement('div');
		//----------------------------
              
		//----------------------------------------		
				
				var label = document.createElement("label");
                label.innerHTML = "Question"; 
				label.style.fontWeight="bold";
				label.style.fontWeight="bolder";
                mainContainer.appendChild(label);
				// creation d'un champs texte
				
				var newText = document.createElement('input');
				newText.type = "input"; 
				// CA DOIt ETRE UNIQUE
				newText.id = counterQcm;
				
				newText.name = "qcm"+counterQcm;
				newText.style.width ="70%";
				
				var newText1=new Array(); ; 
				
				
				newDiv.appendChild(newText);
				
				// Create a new button input
				var Bouton_nouveau_QCM = document.createElement('input');
				Bouton_nouveau_QCM.id="buttonQcm"+(i+1);
				Bouton_nouveau_QCM.type = "button";
				Bouton_nouveau_QCM.value = "Ajouter un choix";
				Bouton_nouveau_QCM.name = counterQcm;
				
				// Append new text input to the newDiv
				
				// Append new button input to the newDiv
				newDiv.appendChild(Bouton_nouveau_QCM);
				


				// Create a new button input
				var Bouton_Supprimer_reponse = document.createElement('input');
				Bouton_Supprimer_reponse.type = "button";
				Bouton_Supprimer_reponse.value = "Supprimer un choix";
				// Append new text input to the newDiv
				
				// Append new button input to the newDiv
				newDiv.appendChild(Bouton_Supprimer_reponse);				
				
				var i=0;
				 var newText1=document.createElement('input');//jaafar
				var element = document.createElement('h3');//jaafar
				Bouton_nouveau_QCM.onclick = function() {
						
						
				////alert(this.name);		
						
 		 		 element = document.createElement('h3');//jaafar
				
                element.id="identif1";
				var ss=document.createTextNode("Choix réponse : "+(i+1));
				element.style.fontSize="15px";
				element.style.fontWeight="normal";
				element.appendChild(ss);
				newDiv.appendChild(element); 
					
							
				
						//	if (Bouton_nouveau_QCM.name == "bouton"+counterQcm )
				                choix[this.name]=i+1;
								////alert(choix[0]);
			    

				/////////////
						
			 newText1=document.createElement('input');	//jaafar		var
						
				newText1.type = "input"; 
				newText1.style.width ="70%";
				//newText[i].setAttribute('value',"Please enter your name to continue");
				
				newText1.id='identif';
				newText1.name = "repQcm"+counterQcm +i;
                //alert(newText1.name);
			////alert(newText1.name);
				newDiv.appendChild(newText1);
				
				
				/*******************************************************
				// ici je mets le boutton supprimé devant la reponse 
				var Bouton_Supprimer_reponse2 = document.createElement('input');
				Bouton_Supprimer_reponse2.id = newText1.id;
				Bouton_Supprimer_reponse2.type = "button";
				Bouton_Supprimer_reponse2.value = "Supprimer ce choix";
				newDiv.appendChild(Bouton_Supprimer_reponse2);
				mainContainer.appendChild(newDiv);
				
				****************************************
				Bouton_Supprimer_reponse2.onclick = function() {
						
				       
						
						var elm2 = document.getElementById(newText1.id);
						elm2.parentNode.removeChild(elm2);
						var elm2 = document.getElementById(newText1.id);
						elm2.parentNode.removeChild(elm2);
						var elm2 = document.getElementById(element.id);
						elm2.parentNode.removeChild(elm2);
						i--;
				}
				**************************************/
				
				
				/* bouton supprimer choix 
				Bouton_Supprimer_reponse.onclick = function() {
						
				       // mettre le ID du boutton qui appel dans identif1
					  // var e1="identif1"+i;
					    
				        
						var elm1 = document.getElementById(element.id);
						elm1.parentNode.removeChild(elm1);
					//	 var e2="identif"+i;
						var elm = document.getElementById(newText1.id);
						elm.parentNode.removeChild(elm);
						
				}
				*/
				i++;
				
				}
				
				
				Bouton_Supprimer_reponse.onclick = function() {
						
				       // mettre le ID du boutton qui appel dans identif1
					  
					    
				        
						var elm1 = document.getElementById('identif1');
						elm1.parentNode.removeChild(elm1);
					
						var elm = document.getElementById('identif');
						elm.parentNode.removeChild(elm);
						
						
				}
				
				
				// Create a new button input
				var Bouton_Supprimer_QCM = document.createElement('input');
				Bouton_Supprimer_QCM.type = "button";
				Bouton_Supprimer_QCM.value = "Supprimer une question";
				
				// Append new text input to the newDiv
				
				
				
				// Append new button input to the newDiv
				newDiv.appendChild(Bouton_Supprimer_QCM);
				// Append newDiv input to the mainContainer div
				mainContainer.appendChild(newDiv);
				
				
			
				
				// Add a handler to button for deleting the newDiv from the mainContainer
				Bouton_Supprimer_QCM.onclick = function() {
						mainContainer.removeChild(newDiv);
				        mainContainer.removeChild(label);
				
				}
				counterQcm++;
				

				
				
		
		
		
		}
		
		</script>