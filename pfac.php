<?php //pfac.php
	$x = $_POST['pfac_x'];
	$hold = $x;
	
	$i = 2;
	$j = 1;
	$pow = 0;
	$flag = false;
	$str = "$x = ";
	while ($i <= $x){
		if ($x % $i == 0){
			if ($j != 1 && !$flag) $str = $str . " * ";
			if (!$flag) $str = $str . "$i";
			$pow++;
			$j++;
			$x /= $i;
			$flag = true;
		}
		else{
			if ($pow > 1)
				$str = $str . "<sup>$pow</sup>";
			$flag = false;
			$pow = 0;
			$i++;
		}
	}
	if ($pow > 1)
		$str = $str . "<sup>$pow</sup>";
	
	if ($str == "$hold = $hold") echo "$hold is prime";
	else echo "$str";
?>