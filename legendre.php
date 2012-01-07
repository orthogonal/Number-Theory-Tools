<?php //legendre.php
	$p = $_POST['legendre_x'];
	$q = $_POST['legendre_p'];
	
	$original_a = $p;
	$original_p = $q;
		
	//p can't be 2.
	if ($q == 2) exit ("p can't be 2.");
	//First test to make sure p ($q) is prime.
	for ($i = 2; $i <= sqrt($q); $i++)
		if ($q % $i == 0) exit("$q isn't prime, it is divisible by $i<br />Remember, p must be an odd prime.");
	
	
	$legendre = 1;
	echo "<br />($p / $q)";
	
	while ($p > 2 && $q > 2){
		$p %= $q;
		echo "<br /> = " . (($legendre == -1) ? "-" : "") . "($p / $q)";
		
		$pow = 0;
		while ($p % 2 == 0){
			$pow++;
			$p /= 2;
		}
		
		if ($pow > 0){
			echo "<br /> = " . (($legendre == -1) ? "-" : "") . "($p / $q) * (2 / $q)<sup>$pow</sup>";
			if ($pow % 2 == 0)
				echo "<br /> $pow is even, so = " . (($legendre == -1) ? "-" : "") . "($p / $q)";
			else{
				if (($q % 8 == 1) || ($q % 8 == 7)){
					echo "<br />$q mod 8 = " . ($q % 8) . " so = " . (($legendre == -1) ? "-" : "") . "($p / $q)";
				}
				else{
					$legendre *= -1;
					echo "<br />$q mod 8 = " . ($q % 8) . " so = " . (($legendre == -1) ? "-" : "") . "($p / $q)";
				}
			}
		}
		$temp = $p;
		$p = $q;
		$q = $temp;
		if ($p > 2 && $q > 2){
			if ($p % 4 == 1)
				echo "<br />$p mod 4 = " . ($p % 4) . " so " . (($legendre == -1) ? "-($q / $p) = -($p / $q)" : "($q / $p) = ($p / $q)");
			else if ($q % 4 == 1)
				echo "<br />$q mod 4 = " . ($q % 4) . " so " . (($legendre == -1) ? "-($q / $p) = -($p / $q)" : "($q / $p) = ($p / $q)");
			else{
				echo "<br />$q mod 4 = " . ($q % 4) . " and $p mod 4 = " . ($p % 4) . " so " . (($legendre == -1) ? "-($q / $p) = ($p / $q)" : "($q / $p) = -($p / $q)");
				$legendre *= -1;
			}
		}
	}
		
	if ($p == 2){
			if (($q % 8 == 1) || ($q % 8 == 7))
				$legendre *= 1;
			else
				$legendre *= -1;
		}
	
	echo "<br />So ($original_a / $original_p) = $legendre";
	if ($legendre == 1)
		echo "<br />So $original_a is a quadratic residue mod $original_p<br />So there exists an x such that x<sup>2</sup> <font face='Symbol'> &#186; </font> $original_a mod $original_p";
	else
		echo "<br />So $original_a is not a quadratic residue mod $original_p<br />So there does not exist an x such that x<sup>2</sup> <font face='Symbol'> &#186; </font> $original_a mod $original_p";
?>