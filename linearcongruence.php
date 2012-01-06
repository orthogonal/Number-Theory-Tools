<?php //linearcongruence.php
	$a = $_POST['lincong_a'];
	$c = $_POST['lincong_c'];
	$m = $_POST['lincong_m'];
	
	$original_m = $m;
	
	echo $a . "x <font face='Symbol'> &#186; </font> $c mod $m<br />";
	if ($c >= $m || $a >= $m){
		if ($c >= $m)
			$c = $c % $m;
		if ($a >= $m)
			$a = $a % $m;
		echo "<br />Cast out $m from both sides<br />";
		echo $a . "x <font face='Symbol'> &#186; </font> $c mod $m<br />";
	}
	
	if ($c == 0)
		exit ("<br />x = 0");
	if ($a == 0)
		exit ("<br />There is no solution!");
		
	//OK, so a < m
	
	$gcd = $a;
	$r = 1;
	$x = $m;
	$y = $a;
	$div = 1;
	
	echo "<br />Find the gcd of $a and $m:<br />";
	while ($r != 0){
		$r = ($x % $y);
		$div = intval($x / $y);
		echo "$x = $div * $y + $r<br />";
		$x = $y;
		$y = $r;
		if ($r != 0)
			$gcd = $r;
	}

	echo "<br />The greatest common divisor of $a and $m is $gcd";
	
	if ($c % $gcd != 0)
		exit ("<br />There is no solution because $gcd does not divide $c");
		
	$c /= $gcd;
	$a /= $gcd;
	$m /= $gcd;
	
	echo "<br />Divide the entire equation (including m) by $gcd<br />";
	echo $a . "x <font face='Symbol'> &#186; </font>  $c mod $m";
	
	$i = 1;
	while (($a * $i - 1) % $m != 0)
		$i++;
		
	$c *= $i;
	$a *= $i;
	echo "<br />Multiply both sides by $i.<br />";
	echo $a . "x <font face='Symbol'> &#186; </font> $c mod $m<br />";
	
	if ($c >= $m || $a >= $m){
		if ($c >= $m)
			$c = $c % $m;
		if ($a >= $m)
			$a = $a % $m;
		echo "<br />Cast out $m from both sides<br />";
		echo $a . "x <font face='Symbol'> &#186; </font> $c mod $m<br />";
	}
	
	if ($m != $original_m){
		echo "<br />We want solutions mod $original_m, however.<br />";
		echo "x = ";
		while ($c < $original_m){
			echo "$c";
			$c += $m;
			if ($c < $original_m) echo ", ";
		}
	}
	else echo "<br />x = $c";
?>