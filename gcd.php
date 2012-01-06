<?php //gcd.php
	$x = $_POST['gcd_x'];
	$y = $_POST['gcd_y'];
	
	//We want y to be greater than x
	if ($y < $x){
		$temp = $x;
		$x = $y;
		$y = $temp;
	}
	
	$gcd = $x;
	$r = 1;
	$a = $y;
	$b = $x;
	$div = 1;
	
	while ($r != 0){
		$r = ($a % $b);
		$div = intval($a / $b);
		echo "$a = $div * $b + $r<br />";
		$a = $b;
		$b = $r;
		if ($r != 0)
			$gcd = $r;
	}
	
	echo "<br />The greatest common divisor of $y and $x is $gcd";
	
?>