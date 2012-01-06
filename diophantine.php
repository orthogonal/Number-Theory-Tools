<?php //diophantine.php
	$x = $_POST['diop_x'];
	$y = $_POST['diop_y'];
	$z = $_POST['diop_z'];
	
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
	$coefficients = array();
	$results = array();
	
	while ($r != 0){
		$r = ($a % $b);
		$div = intval($a / $b);
		array_push($coefficients, $div);
		echo "$a = $div * $b + $r<br />";
		$a = $b;
		$b = $r;
		array_push($results, $r);
		if ($r != 0)
			$gcd = $r;
	}
	echo "<br />";
	if ($z % $gcd != 0)
		echo "There is no solution - the gcd of $x and $y does not divide $z";
	else{
		$x /= $gcd;
		$y /= $gcd;
		$z /= $gcd;
		$coef_y1 = 1;
		$coef_y2 = 0;
		$coef_x1 = 0;
		$coef_x2 = 1;
		for ($i = 0; $i < count($coefficients); $i++){
			$k = $coefficients[$i];
			$tempy = $coef_y1 - ($k * $coef_y2);
			$coef_y1 = $coef_y2;
			$coef_y2 = $tempy;
			
			$tempx = $coef_x1 - ($k * $coef_x2);
			$coef_x1 = $coef_x2;
			$coef_x2 = $tempx;
			
			echo ($results[$i] / $gcd) . "= $coef_x2 * $x + $coef_y2 * $y <br />";
		}
		
		echo "<br />";
		echo ($z * $gcd) . " = (" . ($coef_x1 * $z) . " + $coef_x2 * k) * " . ($x * $gcd) . " + (" . ($coef_y1 * $z) . " + $coef_y2 * k) * " . ($y * $gcd);
	}
	
?>