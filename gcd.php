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
		$a = $b;
		$b = $r;
		if ($r != 0)
			$gcd = $r;
	}
	
	echo "gcd: $gcd";
	
?>