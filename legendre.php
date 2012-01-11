<?php //legendre.php
	$p = $_POST['legendre_x'];
	$q = $_POST['legendre_p'];
	
	$original_a = $p;
	$original_p = $q;
		
	//p can't be 2.
	if ($q == 2) exit ("p can't be 2.");
	//First test to make sure p ($q, this is confusing) is an odd prime.
	for ($i = 2; $i <= sqrt($q); $i++)
		if ($q % $i == 0) exit("$q isn't prime, it is divisible by $i<br />Remember, p must be an odd prime.");
	
	
	$legendre = 1;
	echo "<br />($p / $q)";
	
	//When p or q gets to 2 or 1, you can figure it out with the formulas.  You have to flip if q is 2 (see after the while loop).
	while ($p > 2 && $q > 2){
		//You can simplify the numerator mod the denominator, i.e. (7/5) = (2/5)
		//Basically we're going to keep flipping here until the numerator or the demoninator is 2 or 1.
		$p %= $q;
		echo "<br /> = " . (($legendre == -1) ? "-" : "") . "($p / $q)";
		
		//Next, factor out all the 2s, because we can figure those out.
		$pow = 0;
		while ($p % 2 == 0){
			$pow++;
			$p /= 2;
		}
		
		//Figure out how the legendre symbol changes due to all the 2s previously factored out.
		//The rule here is that (2/q) = 1 if q is 1 or 7 mod 8, and -1 if p is 3 or 5 mod 8.
		if ($pow > 0){
			echo "<br /> = " . (($legendre == -1) ? "-" : "") . "($p / $q) * (2 / $q)<sup>$pow</sup>";
			//First of all, if you have an even number of 2-factors, then the legendre symbol won't change, because -1 and 1 to even powers are both 1.
			if ($pow % 2 == 0)
				echo "<br /> $pow is even, so = " . (($legendre == -1) ? "-" : "") . "($p / $q)";
			//If you have an odd number, then check what q is, and if it's 3 or 5 mod 8, then you're multiplying by -1 to an odd power, or -1.
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
		
		//Now flip p and q.
		//The rule here is that (p/q) = (q/p) if either of the numbers is congruent to 1 mod 4, and -(q/p) if they are both congruent to 3 mod 4.
		//If p is 1, then flipping would be a huge waste of time!
		if ($p > 1){
			if ($p % 4 == 1)
				echo "<br />$p mod 4 = " . ($p % 4) . " so " . (($legendre == -1) ? "-($p / $q) = -($q / $p)" : "($p / $q) = ($q / $p)");
			else if ($q % 4 == 1)
				echo "<br />$q mod 4 = " . ($q % 4) . " so " . (($legendre == -1) ? "-($p / $q) = -($q / $p)" : "($p / $q) = ($q / $p)");
			else{
				echo "<br />$p mod 4 = " . ($p % 4) . " and $q mod 4 = " . ($q % 4) . " so " . (($legendre == -1) ? "-($p / $q) = ($q / $p)" : "($p / $q) = -($q / $p)");
				$legendre *= -1;
			}
		$temp = $p;
		$p = $q;
		$q = $temp;
		}
	}
	
	//By this point, the loop has exited, so either p or q is <= 2.
	if ($q == 2 && $p > 2){	//We want (2/q) or (1/q) because that's super easy to figure out.  So if we have (p/2), flip.  
			if ($p % 4 == 1)
				echo "<br />$p mod 4 = " . ($p % 4) . " so " . (($legendre == -1) ? "-($p / $q) = -($q / $p)" : "($p / $q) = ($q / $p)");
			else if ($q % 4 == 1)
				echo "<br />$q mod 4 = " . ($q % 4) . " so " . (($legendre == -1) ? "-($p / $q) = -($q / $p)" : "($p / $q) = ($q / $p)");
			else{
				echo "<br />$p mod 4 = " . ($p % 4) . " and $q mod 4 = " . ($q % 4) . " so " . (($legendre == -1) ? "-($p / $q) = ($q / $p)" : "($p / $q) = -($q / $p)");
				$legendre *= -1;
			}
		$temp = $p;
		$p = $q;
		$q = $temp;
	}
	//Now we have (2/q) or (1/q).  If it's (1/q), then we do nothing.  If it's (2/q), modify the Legendre symbol one last time.
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