<?php //linearcongruence.php
	$a = $_POST['lincong_a'];
	$c = $_POST['lincong_c'];
	$m = $_POST['lincong_m'];
	
	$original_m = $m;
	
	//We want to find x such that ax = c mod m
	
	echo $a . "x <font face='Symbol'> &#8801; </font> $c mod $m<br />";
	//First, cast out m from a and c.
	if ($c >= $m || $a >= $m){
		if ($c >= $m)
			$c = $c % $m;
		if ($a >= $m)
			$a = $a % $m;
		echo "<br />Cast out $m from both sides<br />";
		echo $a . "x <font face='Symbol'> &#8801; </font> $c mod $m<br />";
	}
	
	//If c is 0, then ax = 0 mod m, so x is just 0.
	//If a is 0, then if c isn't 0 then there is no solution.  If c was 0, the line checking on a is never reached.
	if ($c == 0)
		exit ("<br />x = 0");
	if ($a == 0)
		exit ("<br />There is no solution!");
		
	//OK, so now we know that a < m.  
	//The next step is to find gcd(a, m) and make sure it divides c.
	//This is just the GCD algorithm, copied straight from gcd.php
	
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
	
	//If the gcd doesn't divide c, then there is no solution. i.e. 2x = 3 mod 10 will get 2, 4, 6, 8, 10, but never 3.
	if ($c % $gcd != 0)
		exit ("<br />There is no solution because $gcd does not divide $c");
		
	//Divide everything by the gcd to simplify.  This will be accounted for later, but it works.
	$c /= $gcd;
	$a /= $gcd;
	$m /= $gcd;
	
	echo "<br />Divide the entire equation (including m) by $gcd<br />";
	echo $a . "x <font face='Symbol'> &#8801; </font>  $c mod $m";
	
	//We want to find something to multiply ax by so that we can cast out m's to get 1.  
	//Then we'll just have 1 = something times c mod m.
	$i = 1;
	while (($a * $i - 1) % $m != 0)
		$i++;
		
	$c *= $i;
	$a *= $i;
	echo "<br />Multiply both sides by $i.<br />";
	echo $a . "x <font face='Symbol'> &#8801; </font> $c mod $m<br />";
	
	//Cast out m from all sides to get x = n mod m.
	if ($c >= $m || $a >= $m){
		if ($c >= $m)
			$c = $c % $m;
		if ($a >= $m)
			$a = $a % $m;
		echo "<br />Cast out $m from both sides<br />";
		echo $a . "x <font face='Symbol'> &#8801; </font> $c mod $m<br />";
	}
	
	//So n is one solution.  But we want something mod the original m, so add the reduced m to n as much as possible.
	//Note that since gcd(original m, new m) = new m, this cycles, so we only have to do it until we get over the original m.
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