<?php //pfac.php
	$x = $_POST['pfac_x'];
	$hold = $x;	//x is going to change, but we want to remember what it originally was.
	
	$i = 2;			//i is the number that we are testing as a factor.  We skip 1 since 1 isn't a factor.
	$first = true;	//This is to keep track of whether to add a * before the number.  The first time, you don't.
	$pow = 0;		//The power to raise the factor to.
	$flag = false;	//Flag keeps track of whether or not the number is being raised to a power greater than 1.
	$str = "$x = ";	//The string for the entire process, to be echoed at the end.
	while ($i <= $x){		//Go through every number less than or equal to x - not sqrt(x), for instance 21 = 7 * 3 but 7 > sqrt(x)
		if ($x % $i == 0){	//If x is dividible by i
			if (!$first && !$flag) $str = $str . " * ";	//If it's not the first factor, and this is the first test of this factor, add "*" since it's new.
			if (!$flag) $str = $str . "$i";				//If it's the first test of this factor, write the factor.  Otherwise we'll write a power.
			$pow++;										//Power always starts at 0, and resets after each new factor.
			$first = false;
			echo "$x / $i = " . ($x / $i) . "<br />";	//Output this line so the user can see the process.
			$x /= $i;									//Divide x by the factor and continue.
			$flag = true;								//Now we know that it's already been checked, so if x is divisible by it again, then there is a power.
		}
		else{
			if ($pow > 1)								//If there is a power, then reflect that in the string.
				$str = $str . "<sup>$pow</sup>";
			$flag = false;								//Reset since the next factor checked won't start with a power.
			$pow = 0;
			$i++;										//Check the next factor up.
		}
	}
	echo "<br />";
	if ($pow > 1)										//This has to be added at the end because the while statement and if-else statement conflict.
		$str = $str . "<sup>$pow</sup>";
	//Because this starts from the lowest possible number and divides by a factor until no longer possible at each consecutive factor,
	//we know that every factor will be prime.  If a factor were composite, it will have prime factors lower than it, and x would have been
	//divided by that already, so x wouldn't be divisible by the number because x wouldn't be divisible by its factors.  Contradiction!
	
	if ($str == "$hold = $hold") echo "$hold is prime";	//If the string didn't record anything except x = x, then that means x had no factors and was prime.
	else echo "$str";
?>