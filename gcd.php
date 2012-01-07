<?php //gcd.php
	$x = $_POST['gcd_x'];
	$y = $_POST['gcd_y'];
	
	//We want y to be greater than x
	if ($y < $x){
		$temp = $x;
		$x = $y;
		$y = $temp;
	}
	
	//Euclid's GCD Algorithm 
	$gcd = $x;
	$r = 1;
	$a = $y;	//We want to hold onto y and x until the end for the echo statement, so make temporary variables to modify.
	$b = $x;
	$div = 1;
	
	while ($r != 0){	//When the remainder is 0, the algorithm finishes.
		$r = ($a % $b);	//The remainder is of a and b.
		$div = intval($a / $b);
		echo "$a = $div * $b + $r<br />";	//One line of output of the algorithm, i.e. "24 = 3 * 7 + 3"
		$a = $b;
		$b = $r;
		if ($r != 0)	//The gcd is the second to last remainder in the algorithm, and the last remainder is always 0.
			$gcd = $r;
	}
	
	echo "<br />The greatest common divisor of $y and $x is $gcd";
	
?>