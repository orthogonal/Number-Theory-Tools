<?php //eratosthenes.php
	$x = $_POST['eratos_x'];
	$stop = sqrt($x);
	$options = array();
	
	set_time_limit(240);
	
	for ($i = 2; $i <= $x; $i++)
		array_push($options, $i);

	for ($i = 2; $i < $stop; $i++)
		for ($j = $i; $j < $x; $j++)
			if ($options[$j] % $i == 0)
				$options[$j] = 1;
	
	echo "The prime numbers less than or equal to $x are: ";
	for ($i = 0; $i < $x; $i++)
		if ($options[$i] != 1)
			echo "$options[$i], ";
		

?>