Consommation : &nbsp;
<form action="?page=gestioncredits&conso=j" method="POST">
Journali&egrave;re<blink><font color="green" size="2">-></font></blink>
<input type="submit" value="Go">
<input type="hidden" name="spage" value="consommations_credits">
<input type="hidden" name="stat" value="generale">
</form>
<form action="?page=gestioncredits&conso=hendo" method="POST">
<label for="">Hebdomadaire<blink><font color="green" size="2">-></font></blink></label>
<input type="submit" value="Go">
<input type="hidden" name="spage" value="consommations_credits">
<input type="hidden" name="stat" value="generale">
</form>
<form action="?page=gestioncredits&conso=mensuelle" method="POST">
Mensuelle<blink><font color="green" size="2">-></font></blink>
<input type="submit" value="Go">
<input type="hidden" name="spage" value="consommations_credits">
<input type="hidden" name="stat" value="generale">
</form>
<form action="?page=gestioncredits&conso=intervalle" method="POST">
&nbsp;&nbsp;Entre le
<input type="text" name="gd1" value="<?php echo $gd1;?>">&nbsp;et le&nbsp;
<input type="text" name="gd2" value="<?php echo $gd2;?>">
<blink><font color="green" size="2">-></font></blink>
<input type="submit" value="Go">
<input type="hidden" name="spage" value="consommations_credits">
<input type="hidden" name="stat" value="generale">
</form>

<br><hr style="border-top:1;border-bottom:1px;">

<form action="?page=gestioncredits" method="POST">
Consommation :
<input type="radio" name="periode" value="j" checked>&nbsp;Journali&egrave;re&nbsp;
<input type="radio" name="periode" value="hendo" <?php if($periode=="hendo" && $stat=="client") echo "checked";?>>&nbsp;Hebdomadaire&nbsp;
<input type="radio" name="periode" value="mensuelle" <?php if($periode=="mensuelle" && $stat=="client") echo "checked";?>>&nbsp;Mensuelle&nbsp;
<input type="radio" name="periode" value="intervalle" <?php if($periode=="intervalle" && $stat=="client") echo "checked";?>>&nbsp;&nbsp;Entre le
<input type="text" name="cd1" value="<?php echo $cd1;?>"> et le
<input type="text" name="cd2" value="<?php echo $cd2;?>">
du user N°&nbsp;
<input type="text" name="idclient" size="6" value="<?php echo $idclient;?>">&nbsp;
<blink><font color="green" size="2">-></font></blink>&nbsp;
<input type="submit" value="Go">&nbsp;
<input type="hidden" name="spage" value="consommations_credits">
<input type="hidden" name="stat" value="client">
</form>

<br><hr style="border-top:1;border-bottom:1px;">

<form action="?page=gestioncredits" method="POST">
Liste des N
<input type="text" name="n" size="6"  value="<?php echo $n;?>">&nbsp;meilleurs consommateurs
<input type="radio" name="periode" value="j" checked>&nbsp;du jour&nbsp;
<input type="radio" name="periode" value="hendo" <?php if($periode=="hendo" && $stat=="nmeilleurs") echo "checked";?>>&nbsp;de la semaine&nbsp;
<input type="radio" name="periode" value="mensuelle" <?php if($periode=="mensuelle" && $stat=="nmeilleurs") echo "checked";?>>&nbsp;du mois&nbsp;
<input type="radio" name="periode" value="intervalle" <?php if($periode=="intervalle" && $stat=="nmeilleurs") echo "checked";?>>&nbsp;&nbsp;du
<input type="text" name="id1"  value="<?php echo $id1;?>"> au
<input type="text" name="id2"  value="<?php echo $id2;?>">
<blink><font color="green" size="2">-></font></blink>
<input type="submit" value="Go">
<input type="hidden" name="spage" value="consommations_credits">
<input type="hidden" name="stat" value="nmeilleurs">
</form>

<br><hr style="border-top:1;border-bottom:1px;">
<i>Toutes les dates au format jj/mm/aaaa SVP</i>