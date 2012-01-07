<?php //eratosthenes.php
	$x = $_POST['eratos_x'];
	$stop = sqrt($x);
	$options = array();				//This is a list of all the potential primes, or will be.
	
	set_time_limit(240);			//This can take a while, 240 is in seconds.  It can be longer.
	
	for ($i = 2; $i <= $x; $i++)	//Add every number between 2 and the maximum number to the array.
		array_push($options, $i);	//Each index holds itself plus 2, so $options[1] = 3, etc.

	for ($i = 2; $i <= $stop; $i++)	
		for ($j = $i; $j < $x; $j++)
			if ($options[$j] % $i == 0)
				$options[$j] = 1;		//Change all the numbers that have prime factors to 1.
	
	echo "The prime numbers less than or equal to $x are: ";
	for ($i = 0; $i < $x; $i++)
		if ($options[$i] != 1)			//Anything that isn't 1 then is prime.
			echo "$options[$i], ";
		

?>