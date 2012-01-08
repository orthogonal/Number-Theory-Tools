<?php //successive.php
	$a = $_POST['square_a'];
	$k = $_POST['square_k'];
	$m = $_POST['square_m'];
	
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
?>