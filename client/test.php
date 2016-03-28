<script type="text/javascript">

function toto(){
alert(document.getElementById('a').textContent);
document.getElementById('a').style.bgcolor="red";
}
</script>


<table >
<tr>
<td id="a" value="abc" > test1 </td>
<td> test2 </td>

<input type="button" onclick="toto();"> 
</tr>
</table>