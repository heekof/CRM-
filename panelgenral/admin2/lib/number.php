<?php /* number.php */

// $n: nombre � formatter
// $d: nombre de d�cimales
function nformat($n, $d)
{
	return number_format((float)$n, (int)$d, ',', ' ');
} ?>