<?php
//+++++++++++++++++++++++++++++++++++++++++++ refe ici 

// test contient nom canonique de la question .

// 'l' indice de reponse
$l=$p-1;//p-1
$vari="clik";
// 'oui' ou 'non'
$reponse=${$vari.$l};
// condition de reponse
// mavar4 contient la reference !

echo '<br> --------------'.$reponse.'------------';

	//$mavar4 ="Question".$l.".";
    //$mavar4.=$reponse;
    /** code test   **/
	if($p!=1){$mavar4 ="Question"; }  
    $mavar4=$reponse;
    
	//if($p==2) echo 'ici test1 :'.$mavar4;//		
			
	/** fin code test   **/
	  
//else echo 'erreur reference non modifiée !';
//+++++++++++++++++++++++++++++++++++++++++++ refe ici



// ajout au text et afficher 
if($p==1){
$query11 = " SELECT  * ";
$query11 .= "FROM  argument  ";
$query11 .= "WHERE  numcli='$centrex' and niveau='$p' ";
}
else {
$test2=$test1;
$test2.=$mavar4;
$query11 = " SELECT  * ";
$query11 .= "FROM  argument  ";
$query11 .= "WHERE    numcli='$centrex' and reference='$test2' ";// erreu ici pour lui il est dans b
echo '<br> le test2 que je cherche ========'.$test2;
}
$mysql_result11 = mysql_query($query11) or die ("Erreur : ".mysql_error());
while($row11 = mysql_fetch_array($mysql_result11))
{

    $Vheritage = ($row11["commentaire"]);
	
}



?>
