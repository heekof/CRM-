<script type="text/javascript">

function autoComplete (field, select, property, forcematch) {
        var found = false;
        for (var i = 0; i < select.options.length; i++) {
        if (select.options[i][property].toUpperCase().indexOf(field.value.toUpperCase()) == 0) {
                found=true; break;
                }
        }
        if (found) { select.selectedIndex = i; }
        else { select.selectedIndex = -1; }
        if (field.createTextRange) {
                if (forcematch && !found) {
                        field.value=field.value.substring(0,field.value.length-1); 
                        return;
                        }
                var cursorKeys ="8;46;37;38;39;40;33;34;35;36;45;";
                if (cursorKeys.indexOf(event.keyCode+";") == -1) {
                        var r1 = field.createTextRange();
                        var oldValue = r1.text;
                        var newValue = found ? select.options[i][property] : oldValue;
                        if (newValue != field.value) {
                                field.value = newValue;
                                var rNew = field.createTextRange();
                                rNew.moveStart('character', oldValue.length) ;
                                rNew.select();
                                }
                        }
                }
        }

</script>

<?php
require_once('./admin2/config.php');
require_once('./admin2/lib/mysql.php');

mysql_auto_connect();
//mysql_connect("localhost", "root", "kalonji");
//mysql_select_db("ktcentrex");
?>



<?php 
if(isset($_GET['rech_from'])){ $rech_from = $_GET['rech_from'];}
else {$rech_from = 'numero';} 
echo "Rechercher par $rech_from\n";
?>
<form>
<input type="text" name="input1" value="" onKeyUp="autoComplete(this,this.form.options,'value',true)">




<select name="options" onchange="this.form.input1.value=this.options[this.selectedIndex].value">
<?php
        $sql = mysql_query("SELECT * FROM identite");
        while($cli = mysql_fetch_array($sql)){
         if($_GET['rech_from'] == numero)
          echo '<option value="'.$cli['email'].'" >'.$cli['prenom'].' '.$cli['nom'].'</option>';

         if($_GET['rech_from'] == nom)
           echo '<option value="'.$cli['nom'].'" >'.$cli['prenom'].' '.$cli['nom'].'</option>';

         if($_GET['rech_from'] == prenom)
           echo '<option value="'.$cli['email'].'" >'.$cli['prenom'].' '.$cli['nom'].'</option>';

         else
echo '<option value="'.$cli['email'].'" >'.$cli['prenom'].' '.$cli['nom'].'</option>';


        }
?>
</select>
</form>



