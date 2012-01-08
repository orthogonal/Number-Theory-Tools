<?php //excong.php
	$k = $_POST['excong_k'];
	$b = $_POST['excong_b'];
	$m = $_POST['excong_m'];
	
	echo "x<sup>$k</sup> <font face='Symbol'> &#186; </font> $b mod $m<br /><br />";
	echo "First, compute &#981;(m)<br />";
	
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
	
	$phi = 1;
	$flag = false;	//Flag checks if it is the first factor.
	$str1 = "";		//str1 is going to be the first line, phi(mn) = phi(m) * phi(n), etc.
	$str2 = "";		//str2 is going to be the second line, which goes through phi(p^k) = p^k - p^(k-1)
	$str3 = "";		//str3 is the third line, which shows the results of the second and first lines.
	for ($i = 0; $i <= $m; $i++){	//Check every number.  Only the ones with values in the array will do anything.
		if ($options[$i] != 0){		
			if (!$flag) echo "$m = ";
			else echo " * ";
			
			$phi *= (pow($i, $options[$i]) - pow($i, ($options[$i] - 1)));
			
			echo "$i<sup>$options[$i]</sup>";
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
	
	if ((gcd($k, $phi) != 1) || (gcd($b, $phi) != 1))
			exit("$gcd is not 1, so this is unsolveable.");
	
	echo "Next, we want to solve the equation ($k)u - &#981;($m)v = 1 using the Extended Euclidean Algorithm<br /><br />";
	$diop = diophantine($k, $phi, 1);
	$u = $diop[0];
	$v = $diop[1];
	echo "<br />So the solution is ($k)$u - &#981;($m)$v = 1";
	
	echo "<br />So ($u)$k = 1 + &#981;($m)$v";
	echo "<br />From Euler's Formula, we know b<sup>&#981;(m)</sup> = $b<sup>&#981;($m)</sup> = 1";
	echo "<br />So b<sup>uk</sup> = b<sup>1+&#981;(m)v</sup> = b * (b<sup>&#981;(m)</sup>)<sup>v</sup> = b * 1<sup>v</sup> = b";
	echo "<br />We know x<sup>k</sup> = b, and b<sup>uk</sup> = b, so x = b<sup>u</sup> = $b<sup>$u</sup>";
	echo "<br />Therefore, we just need to solve x <font face='Symbol'> &#186; </font> $b<sup>$u</sup> mod $m";
	echo "<br />We can find this through successive squaring.";
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
		
		if ($a_diop < $b_diop){
			$temp = $b_diop;
			$b_diop = $a_diop;
			$a_diop = $temp;
		}
		
		$gcd = $b_diop;
	
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