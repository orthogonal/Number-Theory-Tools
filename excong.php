<?php //excong.php
	$k = $_POST['excong_k'];
	$b = $_POST['excong_b'];
	$m = $_POST['excong_m'];
	
	/*The steps in solving an exponential congruence are: 
		1.  Compute phi(m)
		2.  Check that gcd(k, phi) = gcd(b, phi) = 1
		3.  Solve ku - phi(m)v = 1 
		4.  x^k = (b^u)^k, and b^uk = b from above, so solve x = b^u
		
		The reason this works is that ku = 1 + phi(m)v, so b^uk = b(b^phi(m)v).  From Euler's Formula, we know b^phi(m) = 1, so b^phi(m)v = 1.
	*/
	
	//<font face='Symbol'> &#186; </font> is congruence
	//&#981; is phi
	
	echo "x<sup>$k</sup> <font face='Symbol'> &#186; </font> $b mod $m<br /><br />";
	echo "First, compute &#981;(m)<br />";
	
	//Step 1:  Compute phi(m)
	$options = array();	
	$temp = $m;
	$i = 2;
	while ($i <= $temp){
		if ($temp % $i == 0){
			$temp /= $i;
			$options[$i]++;
		}
		else $i++;
	}
	//$options now an array of the prime factors of $m.  If an index of the array has a value, then it's a prime factor and that value is its power.
	
	$phi = 1;
	$flag = false;	//Flag checks if it is the first factor.
	$str1 = "";		//str1 is going to be the first line, phi(mn) = phi(m) * phi(n), etc.
	$str2 = "";		//str2 is going to be the second line, which goes through phi(p^k) = p^k - p^(k-1)
	$str3 = "";		//str3 is the third line, which shows the results of the second and first lines.
	for ($i = 0; $i <= $m; $i++){	//Check every number.  Only the ones with values in the array will do anything.
		if ($options[$i] != 0){		//If it is a prime factor (if it isn't, then the value at the index is just going to be 0)
			if (!$flag) echo "$m = ";
			else echo " * ";
			//If it's not the first factor, then there was another factor before it that it was multiplied by.  Remember $flag determines if it's the first factor.
			
			$phi *= (pow($i, $options[$i]) - pow($i, ($options[$i] - 1)));
			//This is from the formula for phi:  phi(p^k) = p^k - p^(k-1).
			//Also, phi(mn) = phi(m)phi(n), so to find phi(x), you find phi of all the prime factors of x and multiple those phis together.
			
			echo "$i<sup>$options[$i]</sup>";
			
			//If $i = $m and something's happening, then that means that the number was prime, so you wouldn't write anything like what's described below.
			//If $i != $m, then the steps above were executed, so something else involving the strings has to be written.
			if ($i != $m){
				if ($flag){
					$str1 = $str1 . " * &#981;($i<sup>$options[$i]</sup>)";
					$str2 = $str2 . " * ($i" . (($options[$i] == 1) ? " - 1)" : "<sup>$options[$i]</sup> - $i<sup>" . ($options[$i] - 1) . "</sup>)");
					$str3 = $str3 . " * (" . pow($i, $options[$i]) . " - " . pow($i, $options[$i] - 1) . ")";
				}
				else{
					$str1 = "&#981;($m) = &#981;($i<sup>$options[$i]</sup>)";
					$str2 = "&#981;($m) = ($i" . (($options[$i] == 1) ? " - 1)" : "<sup>$options[$i]</sup> - $i<sup>" . ($options[$i] - 1) . "</sup>)");
					$str3 = "&#981;($m) = (" . pow($i, $options[$i]) . " - " . pow($i, $options[$i] - 1) . ")";
					$flag = true;
				}
			}
		}
	}
	
	//If the flag never fell, then there were no factors, so it was prime.
	if (!$flag){
		echo "<br />$m is prime.  &#981;($m) = " . ($m - 1) . ".";
		$phi = $m - 1;
	}
	else echo "<br />$str1<br />$str2<br />$str3<br />&#981;($m) = $phi";
	
	echo "<br /><br />In order for this method to work, gcd($k, &#981;($m)) and gcd($b, &#981;($m)) must both equal 1.<br />";
	
	//Step 2.  Check if gcd(k, phi) = gcd(b, phi) = 1.  
	//The gcd method returns the gcd of two numbers.
	if ((gcd($k, $phi) != 1) || (gcd($b, $phi) != 1))
			exit("$gcd is not 1, so this is unsolveable.");
	
	//Step 3.  Solve the diophantine equation.
	//This part is complicated because PHP doesn't like doing modulus on negative numbers.
	//The diophantine method returns an array with u and v as the values in the 0 and 1 indices.
	echo "Next, we want to solve the equation ($k)u - &#981;($m)v = 1 using the Extended Euclidean Algorithm<br /><br />";
	$diop = diophantine($k, $phi, 1);
	$u = $diop[0];
	$v = $diop[1];
	echo "<br />So the solution is ($k)$u - &#981;($m)$v = 1";
	
	//Step 4.  Solve x = b^u through successive squaring.
	echo "<br />So ($u)$k = 1 + &#981;($m)$v";
	echo "<br />From Euler's Formula, we know b<sup>&#981;(m)</sup> = $b<sup>&#981;($m)</sup> = 1";
	echo "<br />So b<sup>uk</sup> = b<sup>1+&#981;(m)v</sup> = b * (b<sup>&#981;(m)</sup>)<sup>v</sup> = b * 1<sup>v</sup> = b";
	echo "<br />We know x<sup>k</sup> = b, and b<sup>uk</sup> = b, so x = b<sup>u</sup> = $b<sup>$u</sup>";
	echo "<br />Therefore, we just need to solve x <font face='Symbol'> &#186; </font> $b<sup>$u</sup> mod $m";
	echo "<br />We can find this through successive squaring.";
	//The successive method simply outputs the result of successive squaring using the successive.php script.
	//We want to find x = b^u mod m, which is the same as a^k mod m in the successive squaring script.
	successive($b, $u, $m);
	
	function gcd($x, $y){
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
	
		echo "<br />The greatest common divisor of $y and $x is $gcd<br /><br />";
	
		return $gcd;
	}
	
	function diophantine ($x, $y, $z){

		$r = 1;
		$a_diop = $y;
		$b_diop = $x;
		$div = 1;
		$coefficients = array();	
		$results = array();
		
		//If y < x, make y > x.  We want y > x.
		if ($a_diop < $b_diop){
			$temp = $b_diop;
			$b_diop = $a_diop;
			$a_diop = $temp;
		}
		
		//$a_diop > $b_diop.
		$gcd = $b_diop;
	
		//Basic gcd algorithm
		while ($r != 0){	
			$r = ($a_diop % $b_diop);
			$div = intval($a_diop / $b_diop);
			array_push($coefficients, $div);
			echo "$a_diop = $div * $b_diop + $r<br />";	
			$a_diop = $b_diop;
			$b_diop = $r;
			array_push($results, $r);
			if ($r != 0)	
				$gcd = $r;
		}
		//The gcd method isn't called here because more values than just the gcd are needed in the Extended Euclidean Algorithm.
		
		//This next bit is copied from the diophantine.php script up until the end.
		echo "<br />";
		if ($z % $gcd != 0)	//The GCD has to divide z, so if it doesn't there is no solution.
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
			echo ($z * $gcd) . " = (" . ($coef_x1 * $z) . " + $coef_x2 * k) * " . ($x * $gcd) . " + (" . ($coef_y1 * $z) . " + $coef_y2 * k) * " . ($y * $gcd) . "<br />";
			$u = $coef_x1 * $gcd;
			$v = $coef_y1 * $gcd;
			//This is going to get a solution of ku + phi(m)v = 1.  We want v to be a negative number, and we know that u and v will always be opposite signs.
			//Therefore, keep adding the k-coefficients to both of them until u is positive, because then v will be negative.
			//Then it will still be ku + phi(m)v = 1, but v is negative, so we can multiply v by -1 to get ku - phi(m)(-v) = 1.
			while ($u <= 0){
				$u += $coef_x2;
				$v += $coef_y2;
			}
			echo ($z * $gcd) . " = ($u) * " . ($x * $gcd) . " - (" . ($v * -1) . ") * " . ($y * $gcd);
			echo "<br />";
			return array($u, $v * -1);
		}
	}

	function successive ($a, $k, $m) {
	//For commentary, see the successive.php script.
		$kfactors = array();
		$kpowers = array();
	
		$tempk = $k;
		$i = 1;
		$j = 0;
	
		while ($tempk != 0){
			$i *= 2;
			$j++;
			if ($i > $tempk){
				$i /= 2;
				$j--;
				$tempk -= $i;
				array_push($kfactors, $i);
				array_push($kpowers, $j);
				$i = 1;
				$j = 0;
			}
		}
	
		$str2 = "$k = ";
		echo "$k = ";
		for ($i = 0; $i < count($kfactors); $i++){
			$str2 .= $kfactors[$i];
			echo "2<sup>" . $kpowers[$i] . "</sup>";
			if ($i < (count($kfactors) - 1)){
				echo " + ";
				$str2 .= " + ";
			}
		}
		echo "<br />$str2";
		
		echo "<br />$a<sup>$k</sup> = ";
		for ($i = 0; $i < count($kfactors); $i++){
			echo "$a<sup>$kfactors[$i]</sup>";
			if ($i < (count($kfactors) - 1)) echo " * ";
		}
		
		echo "<br /><br />";
		$last = 1;
		$i = 1;
		$stop = $kfactors[0];
		$j = count($kfactors) - 1;
		while ($i <= $stop){
			if ($i != 1){
				echo "$a<sup>$i</sup> <font face='Symbol'> &#186; </font> ";
				echo "$a<sup>" .($i / 2) . " * 2</sup> mod $m <font face='Symbol'> &#186; </font> $last<sup>2</sup> mod $m";
				echo " <font face='Symbol'> &#186; </font> " . pow($last, 2) . " mod $m <font face='Symbol'> &#186; </font> " . bcpowmod($last, 2, $m);
				$last = bcpowmod($last, 2, $m);
			}
			else{
				echo "$a<sup>1</sup> mod $m <font face='Symbol'> &#186; </font> " . ($a % $m);
				$last = $a % $m;
			}
			if ($i == $kfactors[$j]){
				$kfactors[$j] = $last;
				$j--;
			}
			$i *= 2;
			echo "<br />";
		}		
		
		$result = 1;
		echo "<br />$a<sup>$k</sup> <font face='Symbol'> &#186; </font> ";
		for ($i = 0; $i < count($kfactors); $i++){
			echo "$kfactors[$i]";
			$result *= $kfactors[$i];
			$result %= $m;
			if ($i < (count($kfactors) - 1)) echo " * ";
		}
		echo " mod $m";
		echo "<br />$a<sup>$k</sup> mod $m <font face='Symbol'> &#186; </font> " . ($result % $m);
		echo "<br />x = " . ($result % $m);
}
?>