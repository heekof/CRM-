
<script  type="text/javascript">
function revenir(){

alert("hello");

}

</script>

<?php require("connecte/base.php"); 

if (!isset($mysql_link))
{
	// $mysql_link = mysql_connect("localhost" ,"adil","adil");
$mysql_link = mysql_connect("localhost" ,"root","kalonji");
// $mysql_link = mysql_connect("94.23.22.154" ,"tshivuadi","tshivuadi2010");

	mysql_select_db("ktcentrex", $mysql_link);
}





 

 $tab=array();







if($i==NULL) {$i=1;$p=1;}


for ($j=0; $j<1; $j++){
echo '<br> question :'.$p;


?>
<form method="POST" action="jaafar.php"> 
<input type="hidden" name="p" value=<?php echo $p+1;?> >
<input type="text" name=<?php echo 'entry'.$p; ?> value="" >
<input type="hidden" name="i" value=<?php echo $i+1;?> >

<input type="submit" name=<?php echo 'clik'.$p; ?> value="oui">
<input type="submit" name=<?php echo 'clik'.$p; ?> value="non">
<input type="button" name="revenir" value="revenir" onclick="revenir();">

</form>
<?php

$t=$i-1;
//echo " questioni".$p ;
//echo "<br> questionp".$i ;

if(${"clik".$p}=="oui") {

	if(1)
	{
	//$f=$t-1;
	$mavar4="question".$t.${"clik".$p};
	}
	else  
	$mavar4="question".$p;

	
}
else {

 



if(1)
{
$f=$t-1;
$mavar4="question".$t.${"clik".$p};
}
else  
$mavar4="question".$p;

}

$e=$p-1;
$mavar="entry";
$mavar2="question";
$mavar3=${$mavar.$e};
echo '<br> ici marv3='.$mavar3;
//echo '<br> ici i='.${$mavar.$i};

//if($mavar3!="" || $mavar3!= NULL)
{
$query = "INSERT INTO argument (numcli,commentaire,reference) ";
$query  .= " VALUES ('none','$mavar3','$mavar4')";
$result = mysql_query($query) ;//or die ("Erreur : ".mysql_error());

}


mysql_close();

}
?>
