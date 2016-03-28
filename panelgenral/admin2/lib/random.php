<?php /* random.php */
/* Generation d'identifiants et mots de passes al�atoires */

// $l: longueur du texte � g�n�rer
function random_text($l)
{
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$pass = '';
	
	$l = (int)$l;
	
	if ($l <= 0)
		$l = 8;
	
	for ($i = 0; $i < $l; $i++)
		$pass .= $chars[rand(0, 61)];
	
	return $pass;
}

// $l: longueur du texte � g�n�rer
function random_login($l)
{
	return random_text($l);
}

// $l: longueur du texte � g�n�rer
function random_password($l)
{
	return random_text($l);
}

?>