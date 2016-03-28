<?php /* number.php */

// $n: nombre à formatter
// $d: nombre de décimales
function nformat($n, $d)
{
	return number_format((float)$n, (int)$d, ',', ' ');
} ?>