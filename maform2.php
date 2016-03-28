<form method="POST" action="crm1.php"> 

<input type="hidden"  id="xret" name="xret" value=<?php $l=$p-1; echo $l;?> >
<input type="hidden" name="page" value="jaafar">
<input type="hidden"   name="ret1"   value="retour1"     /> 

<input type="hidden" name="mavar4" value=<? print("$mavar4"); ?> >
<input type="hidden" name="toto" value=<? print("$mavar4"); ?> >
 <input type="hidden"  name="test1" value="<?   echo $test1; ?>" >
 <tr   >
 
 <p style="text-align: center;"><input  type="image"  src="F4.png" id="ret"   value="Retour"     /> </p>
 
<?php //$fofo="entry"; echo  $_POST['$fofo.$p']; $g=$p+1;   echo  $_POST['$fofo.$g']; $d=$p+2;   echo  ${$fofo.$d};?> 
 </tr>
</form>