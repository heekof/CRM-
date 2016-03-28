<?php
function cumulDuJour($idclient,$date)
{
	//onrecupère ous les ajouts effectués au compte du client
	$query = " SELECT sum(montant) FROM historique_credit2 where idclient='$idclient' AND dateop like '%".$date."%' AND typeoperation = 'Ajout';";
	$cumul = 0;
	if($result = mysql_query($query))
	{
		while($row = mysql_fetch_row($result))
		{
			$cumul = (float)$row[0];
		}
	}
	/*$query = " SELECT * FROM historique_credit2 where idclient='$idclient' AND dateop like '%".$date."%' AND typeoperation = 'Ajout';";
	
	$cumul = 0;
	
	if($result = mysql_query($query))
	{
		while($row = mysql_fetch_array($result))
		{
			$cumul += (float)$row['montant'];
		}
	}*/
	return $cumul;
}

function cumulEntreDeuxDates($idclient,$d1,$d2)
{
	//onrecupère ous les ajouts effectués au compte du client
	$query = " SELECT sum(montant) FROM historique_credit2 where idclient='$idclient' AND (dateop BETWEEN '".$d1."' AND '".$d2."') AND typeoperation = 'Ajout';";
	$cumul = 0;
	if($result = mysql_query($query))
	{
		while($row = mysql_fetch_row($result))
		{
			$cumul = (float)$row[0];
		}
	}
	/*$query = " SELECT * FROM historique_credit2 where idclient='$idclient' AND (dateop BETWEEN '".$d1."' AND '".$d2."') AND typeoperation = 'Ajout';";
	
	$cumul = 0;
	
	if($result = mysql_query($query))
	{
		while($row = mysql_fetch_array($result))
		{
			$cumul += (float)$row['montant'];
		}
	}*/
	return $cumul;
}

function consoDuJour($idclient,$date)
{
	$query = " SELECT min(datearchive), max(datearchive) FROM historique_credit where idclient='$idclient' AND datearchive like '%".$date."%';";
	$conso = 0;
	if($result = mysql_query($query))
	{
		$row = mysql_fetch_row($result);
		$leCumul = cumulEntreDeuxDates($idclient,$row[0],$row[1]);
		//echo $row[0].' a '.$row[1];
		$rC1 = mysql_query(" SELECT credit FROM historique_credit where idclient='$idclient' AND datearchive = '".$row[0]."';");
		$rC2 = mysql_query(" SELECT credit FROM historique_credit where idclient='$idclient' AND datearchive = '".$row[1]."';");
		
		$c1 = mysql_fetch_array($rC1);
		$c2 = mysql_fetch_array($rC2);
		
		$conso = (float)($c1['credit']-$c2['credit']+$leCumul);
		//echo $c1['credit'].'-'.$c2['credit'].'+'.$leCumul;
	}
	return $conso;
}

function consoEntreDeuxDates($idclient,$d1,$d2)
{
	$query = " SELECT min(datearchive), max(datearchive) FROM historique_credit where idclient='$idclient' AND (datearchive BETWEEN '".$d1."' AND '".$d2."');";
	$conso = 0;
	if($result = mysql_query($query))
	{
		$row = mysql_fetch_row($result);
		$leCumul = cumulEntreDeuxDates($idclient,$row[0],$row[1]);
		
		$rC1 = mysql_query(" SELECT credit FROM historique_credit where idclient='$idclient' AND datearchive = '".$row[0]."';");
		$rC2 = mysql_query(" SELECT credit FROM historique_credit where idclient='$idclient' AND datearchive = '".$row[1]."';");
		
		$c1 = mysql_fetch_array($rC1);
		$c2 = mysql_fetch_array($rC2);
		
		$conso = (float)($c1['credit']-$c2['credit']+$leCumul);
	}
	return $conso;
}

function consoGeneDuJour($date)
{
	$consoGDJ = 0;
	if($result = mysql_query(" SELECT idclient FROM credit ;"))
	{
		while($row = mysql_fetch_array($result))
		{
			$consoGDJ += consoDuJour($row['idclient'],$date);
		}
	}
	return $consoGDJ;
}

function consoGeneEntreDeuxDates($d1,$d2)
{
	$consoGEDD = 0;
	if($result = mysql_query(" SELECT idclient FROM credit ;"))
	{
		while($row = mysql_fetch_array($result))
		{
			$consoGEDD += consoEntreDeuxDates($row['idclient'],$d1,$d2);
		}
	}
	return $consoGEDD;
}

function nMeilleursConsommateursDuJour($n,$date)
{
	$lesNMeilleurs = array();//liste des n meilleurs
	$monTabRecap = array();
	if($result = mysql_query(" SELECT idclient FROM credit ;"))
	{
		while($row = mysql_fetch_array($result))
		{
			$monTabRecap[] = array($row['idclient'],consoDuJour($row['idclient'],$date));
		}
	}
	//On tri en fonction de la consommation
	triDecroissant($monTabRecap);
	for($i=0; $i<$n; $i++)
		$lesNMeilleurs[] = $monTabRecap[$i];
	return $lesNMeilleurs;
}

function nMeilleursConsommateursEntreDeuxDates($n,$d1,$d2)
{
	$lesNMeilleurs = array();//liste des n meilleurs
	$monTabRecap = array();
	if($result = mysql_query(" SELECT idclient FROM credit ;"))
	{
		while($row = mysql_fetch_array($result))
		{
			$monTabRecap[] = array($row['idclient'],consoEntreDeuxDates($row['idclient'],$d1,$d2));
		}
	}
	//On tri en fonction de la consommation
	triDecroissant($monTabRecap);
	for($i=0; $i<$n; $i++)
		$lesNMeilleurs[] = $monTabRecap[$i];
	return $lesNMeilleurs;
}


// Le tri en lui-même
function triDecroissant(&$T)
{
	for($i=0; $i<count($T)-1; $i++)
	{
		for($j=$i; $j<count($T); $j++)
		{
			if($T[$i][1] < $T[$j][1])
			{
				$tmp = $T[$i];
				$T[$i] = $T[$j];
				$T[$j] = $tmp;
			}
		}
	}
}
/*
function triCroissant2(&$T)
{
  if (count($T) > 0 )
    {
      for($i = 0 ; $i<count($T); $i++)
        {
          SwapElts($T, $i, SmallestIndex($T, $i));
        }
    }
}

// Recherche du plus petit élément de T dans l'intervalle StartIndex..Longueur(T)
function SmallestIndex($T, $StartIndex)
{
  $Result = $StartIndex;
  $tmp = $T[$StartIndex][1];
  for($i=$StartIndex; $i<count($T); $i++)
    {
		if ($tmp > $T[$i][1]) 
		{
			$Result = $i;
			$tmp = $T[$i][1];
        }
    }
}

// Echange de 2 éléments de T
function SwapElts($T, $index1, $index2)
{
  if ($index1 <> $index2)
    {
		$tmp = $T[$index1];
		$T[$index1] = $T[$index2];
		$T[$index2] = $tmp;
    }
}*/
?>