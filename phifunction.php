<?php //phifunction.php
	$x = $_POST['phi_x'];
	
	$options = array();	
	//Make an array of all the factors of x ($i) and their exponents ($options[$i])	
	//The methodology for this is basically the same as in the prime factorization from before.
	$temp = $x;
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
	for ($i = 0; $i <= $x; $i++){	//Check every number.  Only the ones with values in the array will do anything.
		if ($options[$i] != 0){		
			if (!$flag) echo "$x = ";	//If it is the first factor, then write "x = ", otherwise put a * in front of it coming from the previous factor.
			else echo " * ";
			
			$phi *= (pow($i, $options[$i]) - pow($i, ($options[$i] - 1)));	//Multiply by p^k - p^(k-1) at each p.
			
			echo "$i<sup>$options[$i]</sup>";		//Update the strings accordingly.
			if ($i != $x){
				if ($flag){
					$str1 = $str1 . " * &#981;($i<sup>$options[$i]</sup>)";
					$str2 = $str2 . " * ($i" . (($options[$i] == 1) ? " - 1)" : "<sup>$options[$i]</sup> - $i<sup>" . ($options[$i] - 1) . "</sup>)");
					$str3 = $str3 . " * (" . pow($i, $options[$i]) . " - " . pow($i, $options[$i] - 1) . ")";
				}
				else{
					$str1 = "&#981;($x) = &#981;($i<sup>$options[$i]</sup>)";
					$str2 = "&#981;($x) = ($i" . (($options[$i] == 1) ? " - 1)" : "<sup>$options[$i]</sup> - $i<sup>" . ($options[$i] - 1) . "</sup>)");
					$str3 = "&#981;($x) = (" . pow($i, $options[$i]) . " - " . pow($i, $options[$i] - 1) . ")";
					$flag = true;
				}
			}
		}
	}
	
	//If the flag never fell, then there were no factors, so it was prime.
	if (!$flag) echo "<br />$x is prime.  &#981;($x) = " . ($x - 1) . ".";
	else echo "<br />$str1<br />$str2<br />$str3<br />&#981;($x) = $phi";
?>