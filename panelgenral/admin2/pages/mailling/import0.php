<?php
require("haut.php");
//require("base.php");
?>
<table border="2"  align="center" width="60%" >

<tr align="center">
 <td > <b> Importation  & Ficher & Base  </b>    </td>
    </tr>
<tr>

</table>





<br>
<table border="2"  align="center" width="60%" >

<tr align="left">

<td>

<form method="post"  action="?page=mailling" >
<p>
<input type="hidden" name="spage" value="import1">
<center>
<b> Nom de votre Base </b>    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
<input type="text" size="20"  name="nominsertion" >
<br>
<br>
<b> Separé par dés</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;

<SELECT name="separation">

<OPTION value=";"> <b>Point virgule  ;  </b> </option>
<OPTION value=":"> <b> Deux point :    </b> </option>
<OPTION value="-"> Tirait  -  </option>

</SELECT>
</center>

<br>


<br>
<center>
<b> Email &nbsp; prenom &nbsp; nom &nbsp;  </b>
</center>
<center>
<TEXTAREA ROWS="20" COLS="50" name="labase"></TEXTAREA>
</center>
<br>
<br>
<p Align="center">
<input type="submit"  value="Enregistrer">
</p>

</a>

</p>
</form>


 </td>
</tr>
</table>

