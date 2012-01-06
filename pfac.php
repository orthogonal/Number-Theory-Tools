<?php //pfac.php
	$x = $_POST['pfac_x'];
	$hold = $x;
	
	$i = 2;
	$j = 1;
	$str = "$x = ";
	while ($i <= $x){
		if ($x % $i == 0){
			if ($j != 1) $str = $str . " * ";
			$str = $str . "$i";
			$j++;
			$x /= $i;
		}
		else $i++;
	}
	
	if ($str == "$hold = $hold") echo "$hold is prime";
	else echo "$str";
?>