<?php /* mysql.php */

$mysql_link = false;

function mysql_auto_connect()
{
	global $mysql_db, $mysql_link, $mysql_server, $mysql_user, $mysql_password;
	
	if (!$mysql_link)
	{
		//$mysql_link = mysql_connect("127.0.0.1" ,"kaloTony","tshivkalo2006");
		if ($mysql_link = mysql_connect($mysql_server, $mysql_user, $mysql_password))
			mysql_select_db($mysql_db, $mysql_link);
		else
			return false;
	}
	return true;
}

function mysql_auto_close()
{
	global $mysql_link;
	
	if ($mysql_link)
		mysql_close($mysql_link);
} ?>