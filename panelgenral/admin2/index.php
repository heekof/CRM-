<?php 
require_once('config.php');
require_once('lib/mysql.php');

if (isset($title))
	unset($title);

function ob_callback($buffer, $mode)
{
	global $admin_pages, $title, $index_page;
	
	if ($mode & PHP_OUTPUT_HANDLER_START)
	{
		$out = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'
			.'<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr"><head>'
			.'<title>Administraction Kt-Centrex</title>'
			.'<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />'
			.'<link rel="stylesheet" type="text/css" href="style/default.css" />'
			.'<script type="text/javascript" src="js/js.js"></script>'
			.'<script type="text/javascript" src="js/prototype.js"></script>'
			.'<script type="text/javascript" src="js/effects.js"></script>'

			.'</head><body>'
			.'<div id="headbar"><div id="header">';
		if (isset($title) && strlen($title) > 0)
			$out .= htmlentities($title);
		else
			$out .= 'Kt-Centrex Administration';
		$out .= '</div></div>'
			.'<div id="menu_2"><ul>';
		foreach ($admin_pages as $admin_page => $page_info)
		{	
			if(!$page_info['spage'])
			$out .= '<li><a href="?page='.$admin_page.''.(($page_info['name']=="Comptes")? '&amp;l=all':'').'"'.(($admin_page == $index_page)?' class="selected"':'').'>'.$page_info['name'].'</a></li>';
			else 
			{
				$spages = $page_info['spage'];
				$out .= '<li><a href="#"'.(($admin_page == $index_page)?' class="selected"':'').'>'.$page_info['name'].'</a>';
				$out .= '<ul>';
				foreach ($spages as $spage => $spage_info)
					$out .= '<li><a href="?page='.$admin_page.'&amp;spage='.$spage.'"'.(($admin_page == $index_page)?' class="selected"':'').'>'.$spage_info['name'].'</a></li>';
				$out .= '</ul></li>';
			}
		}
		$out .= '</ul></div><div id="main"><div id="content">';
	}
	else
		$out = '';
	
	$out .= $buffer;
	
	if ($mode & PHP_OUTPUT_HANDLER_END)
		$out .= '</div></div></body></html>';
	
	return $out;
}

if (!isset($_SERVER['PHP_AUTH_USER'])
	|| !isset($_SERVER['PHP_AUTH_USER'])
	|| !isset($_SERVER['PHP_AUTH_PW'])
	|| $_SERVER['PHP_AUTH_USER'] != $admin_user
	|| $_SERVER['PHP_AUTH_PW'] != $admin_pass) {
    header('WWW-Authenticate: Basic realm="Administration Kt-Centrex"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Acc&egrave;s non autoris&eacute;';
    exit;
}

mysql_auto_connect();

ob_start('ob_callback');
setlocale(LC_TIME, 'fr');

if (isset($_GET['page']))
	$index_page = $_GET['page'];
else
	$index_page = '';

if (!array_key_exists($index_page, $admin_pages))
	$index_page = $admin_default_page;

$page_name = $admin_pages[$index_page]['name'];
$page_path = $admin_pages[$index_page]['path'];


$result = include($page_path);

ob_end_flush();

mysql_auto_close() ?>