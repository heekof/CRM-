<?php function check_mail($mail)
{
	return (bool)preg_match('/^[a-zA-Z0-9\.\-_]+@[a-zA-Z0-9\-_]+(\.[a-zA-Z0-9\-_]+)*$/', $mail);
}

function check_phone($phone)
{
	return (bool)preg_match('/^\+?[0-9]+(( +|-)[0-9]+)*$/', $phone);
}

function check_postal($postal)
{
	return (bool)preg_match('/^[0-9]+(( +|-)[0-9]+)*$/', $postal);
}

function check_upload($name, $max_size)
{
	if (array_key_exists($name, $_FILES))
	{
		if ($_FILES[$name]['size'] == 0)
			return true;
		if (!is_uploaded_file($_FILES[$name]['tmp_name']))
			return false;
		if ($_FILES[$name]['size'] > $max_size)
			return false;
		$ext = strtolower(pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION));
		if ($ext != 'gif' && $ext != 'png' && $ext != 'jpg' && $ext != 'jpeg')
			return false;
	}
	return true;
} ?>