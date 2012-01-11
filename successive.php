<?php //successive.php
	$a = $_POST['square_a'];
	$k = $_POST['square_k'];
	$m = $_POST['square_m'];
	
	/*The algorithm for successive squaring is as follows:
	We want to find a^k mod m.  First, write k as a sum of powers of 2.
	Suppose it's w+x+y+z.  Then we have a^k = a^(w+x+y+z) = a^w * a^x * a^y * a^z
	Then we just have to find those and multiply them together.  We find them mod m, so it's not a huge multiplication.
	Since they're based on powers of 2, we can just find all the powers of 2 of a, which will just be the previous power of 2 of a square.
	i.e. a^8 = (a^4)^2 mod m.
	*/
	
	//kfactors is all the powers of 2 that sum together to get k.
	//kpowers is the powers that 2 is raised to to get the kfactors.
	$kfactors = array();
	$kpowers = array();
	
	$tempk = $k;
	$i = 1;
	$j = 0;
	
	while ($tempk != 0){
		//We want to find the highest power of 2 that can go into k, then subtract that and repeat.
		//So, multiply i by 2 until it's greater than k.  Then divide by 2 and subtract it out.
		//j is the power of 2 that is equal to 1.
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
	
	//str2 is the kfactors.  So it would be like 5 = 4 + 1.
	//This loop also echoes 5 = 2^2 + 2^0.
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
	
	//Now write a^k = a^w * a^x etc. So the user understands what the algorithm is doing.
	echo "<br />$a<sup>$k</sup> = ";
	for ($i = 0; $i < count($kfactors); $i++){
		echo "$a<sup>$kfactors[$i]</sup>";
		if ($i < (count($kfactors) - 1)) echo " * ";
	}
	
	//Next, the powers-of-2 list.
	//Note that the k-factors and k-powers are in DECREASING order.  So the power/factor in the 0 index will be the highest one.
	//However, we want to go in order from lowest to highest.  That's why this starts at the back and goes to the smallest ($stop).
	echo "<br /><br />";
	$last = 1;
	$i = 1;
	$stop = $kfactors[0];		//The highest power of 2 that we care about is $stop.
	$j = count($kfactors) - 1;	//This is the last index of the arrays.
	//Go through all the k-factors.
	while ($i <= $stop){
		if ($i != 1){
			echo "$a<sup>$i</sup> <font face='Symbol'> &#186; </font> ";
			echo "$a<sup>" .($i / 2) . " * 2</sup> mod $m <font face='Symbol'> &#186; </font> $last<sup>2</sup> mod $m";
			echo " <font face='Symbol'> &#186; </font> " . pow($last, 2) . " mod $m <font face='Symbol'> &#186; </font> " . bcpowmod($last, 2, $m);
			$last = bcpowmod($last, 2, $m);
		}
		//If i = 1, then we don't need to write all the squaring stuff because we don't square anything, we just mod the original a.
		else{
			echo "$a<sup>1</sup> mod $m <font face='Symbol'> &#186; </font> " . ($a % $m);
			$last = $a % $m;
		}
		//We write every power of 2, since we need to square each time to get the next one, but the only ones that matter are the kfactors.
		//Remember, the kfactors are powers of 2, so if we square enough times, we'll get a to all the kfactors.
		//When we reach a kfactor, overwrite that kfactor with the result of a to that kfactor (this may be confusing but it's to conserve memory).
		if ($i == $kfactors[$j]){
			$kfactors[$j] = $last;
			$j--;
		}
		$i *= 2;
		echo "<br />";
	}		
	
	$result = 1;
	echo "<br />$a<sup>$k</sup> <font face='Symbol'> &#186; </font> ";
	//This loop is just the result of a^k = a^w * a^x * ....
	for ($i = 0; $i < count($kfactors); $i++){
		echo "$kfactors[$i]";		//a^(kfactor)
		$result *= $kfactors[$i];
		$result %= $m;
		if ($i < (count($kfactors) - 1)) echo " * ";
	}
	echo " mod $m";
	echo "<br />$a<sup>$k</sup> mod $m <font face='Symbol'> &#186; </font> " . ($result % $m);
?>