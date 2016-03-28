<?php
//ENREGISTREMENT DANS LA TABLE DE CORRESPONDANCE POUR LA ROTATION	
if($i==1){$jo="Monday";}	
if($i==2){$jo="Tuesday";}	
if($i==3){$jo="Wednesday";}	
if($i==4){$jo="Thursday";}	
if($i==5){$jo="Friday";}	


$queryw ="SELECT numero FROM identite ORDER BY numero ASC LIMIT $start,$limit ";
$mysql_resultw = mysql_query($queryw) or die ("Erreur : ".mysql_error());
while($rows = mysql_fetch_array($mysql_resultw))
                              {
							       $cl= ($rows["numero"]);
									  
								  
$sql = 'INSERT INTO  pubcorrespondance(numcli,jours) VALUES ("'.$cl.'","'.$jo.'")';
mysql_query($sql);						  
                                      

}
?>