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
	
	//First, get the GCD.  This is almost the same as the GCD algorithm gcd.php
	$gcd = $x;
	$r = 1;
	$a = $y;
	$b = $x;
	$div = 1;
	$coefficients = array();	//For instance, in 31 = 4 * 7 + 3", 4 is the coefficient.
	$results = array();			//The remainders each time.  Then 3 would be the result.
	
	while ($r != 0){	//The algorithm continues until the remainder is 0.
		$r = ($a % $b);	//The remainer is of a and b.
		$div = intval($a / $b);
		array_push($coefficients, $div);
		echo "$a = $div * $b + $r<br />";	//i.e. "31 = 3 * 7 + 3"
		$a = $b;
		$b = $r;
		array_push($results, $r);
		if ($r != 0)	//The gcd is the second to last remainder, and the last remainder is always 0.
			$gcd = $r;
	}
	
	//Now for the Extended Euclidean Algorithm
	echo "<br />";
	if ($z % $gcd != 0)	//The GCD has to divide z, so if it doesn't there is no solution.
		echo "There is no solution - the gcd of $x and $y does not divide $z";
	else{	
		//First, divide all sides by the gcd.
		$x /= $gcd;
		$y /= $gcd;
		$z /= $gcd;
		//Remember y is greater than x
		//y = 1(y) + 0(x)
		//x = 0(y) + 1(x)
		//We start on the third iteration.
		//y1 and y2 are the last two coefficients in the last two iterations.
		$coef_y1 = 1;
		$coef_y2 = 0;
		$coef_x1 = 0;
		$coef_x2 = 1;
		//Suppose the coefficient in the GCD algorithm is z.
		//Then a = zb + r
		//So a - zb = r
		//The third value will be r, we have a = y1(y) + x1(x) and b = y2(y) + x2(x)
		//So y1(y) + x1(x) - zy2(y) - zx2(x) = r
		//So y(y1 - zy2) + x(x1 - zx2) = r
		//Continue until r is 0.  Then we have a combination of y and x that gets 0.
		//Above that will be a combination that gives gcd.  We want z, so multiply the coefficients of this row by z/gcd.
		//That gets us coefficients such that ax + by = z.  We can add multiples of 0.
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
		//Not multiply through by z because z = the original z divided by the gcd, so it's really z/gcd that you're multiplying through by.
		echo ($z * $gcd) . " = (" . ($coef_x1 * $z) . " + $coef_x2 * k) * " . ($x * $gcd) . " + (" . ($coef_y1 * $z) . " + $coef_y2 * k) * " . ($y * $gcd);
	}
	
?>