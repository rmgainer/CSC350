<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>HW 2 Problem 2</title>
</head>
<body>

<?php

	function calc($a, $b, $operator)
	{
		switch($operator) {
			case '+':
				$result = $a + $b;
				break;
			case '-':
				$result = $a - $b;
				break;
			case '*':
				$result = $a * $b;
				break;
			case '/':
				if ($b == 0)
					$result = "ERROR";
				else
					$result = $a / $b;
				break;
		}
		return $result;
	}

	$input1 = $_POST['input1'];
	$input2 = $_POST['input2'];
	$input3 = $_POST['input3'];
	$operator1 = $_POST['operator1'];
	$operator2 = $_POST['operator2'];

	if (!(is_numeric($input1) && is_numeric($input2) && is_numeric($input3)))
		$result = "ERROR";
	else
	{
		if (($operator2 == '*' || $operator2 == '/') && !($operator1 == '*' || $operator1 == '/'))
		{
			$result = calc($input2, $input3, $operator2);
			if ($result != 'ERROR')
				$result = calc($input1, $result, $operator1);
		} else {
			$result = calc($input1, $input2, $operator1);
			if ($result != 'ERROR')
				$result = calc($result, $input3, $operator2);
		}
	}
	print "$input1 $operator1 $input2 $operator2 $input3 = $result";

?>

</body>
</html>
