<?

if (!isset($mysql_link))
{
	// $mysql_link = mysql_connect("localhost" ,"adil","adil");
$mysql_link = mysql_connect("localhost" ,"root","kalonji");
// $mysql_link = mysql_connect("94.23.22.154" ,"tshivuadi","tshivuadi2010");

	mysql_select_db("ktcentrex", $mysql_link);
}

?>
