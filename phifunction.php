<?php //phifunction.php
	$x = $_POST['phi_x'];
	
	$options = array();
		
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
	$flag = false;
	$str1 = "";
	$str2 = "";
	$str3 = "";
	for ($i = 0; $i <= $x; $i++){
		if ($options[$i] != 0){
			if (!$flag) echo "$x = ";
			else echo " * ";
			
			$phi *= (pow($i, $options[$i]) - pow($i, ($options[$i] - 1)));
			
			echo "$i<sup>$options[$i]</sup>";
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
	
	if (!$flag) echo "$x is prime.  &#981;(x) = " . ($x - 1) . ".";
	else echo "<br />$str1<br />$str2<br />$str3<br />&#981;(x) = $phi";
?>