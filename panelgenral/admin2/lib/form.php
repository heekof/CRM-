<?php /* form.php */

// Insère un élément de formulaire dans un tableau HTML en 2 colonnes
function insert_form_element($title, $type, $name, $value, $editable, $extra1=0, $extra2=0)
{
	echo '<tr><td class="label">'.htmlentities($title).'</td>';
	echo '<td class="input">';
	if ($editable)
	{
		if ($type == 'textarea')
			echo '<textarea name="'.$name.'">'.htmlentities($value).'</textarea>';
		else if ($type == 'select')
		{
			echo '<select name="'.$name.'">';
			foreach ($extra1 as $choice => $choice_title)
				echo '<option value="'.htmlentities($choice).'"'.(($value == $choice)?' selected="selected"':'').'>'.htmlentities($choice_title).'</option>';
			echo '</select>';
		}
		else if ($type == 'imgupload')
		{
			if (strlen($extra2) > 0)
				echo '<img src="'.htmlentities($extra2).'" alt="" /><br />';
			echo '<input type="hidden" name="MAX_FILE_SIZE" value="'.(int)$extra1.'" />';
			echo '<input type="file" name="'.$name.'" />';
		}
		else
			echo '<input type="'.$type.'" name="'.$name.'" value="'.htmlentities($value).'" />';
	}
	else
	{
		if ($type == 'textarea')
			echo nl2br(htmlentities($value));
		else if ($type == 'select')
		{
			if (array_key_exists($value, $extra1))
				echo htmlentities($extra1[$value]);
			else
				echo $value;
		}
		else if ($type == 'imgupload')
		{
			if (strlen($extra2) > 0)
				echo '<img src="'.htmlentities($extra2).'" alt="" />';
			else if (strlen($value))
				echo htmlentities($value);
			else
				echo 'Aucune image';
		}
		else
			echo htmlentities($value);
	}
	echo '</td></tr>';
}

?>