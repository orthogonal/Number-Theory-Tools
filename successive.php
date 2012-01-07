<?php //successive.php
	$a = $_POST['square_a'];
	$k = $_POST['square_k'];
	$m = $_POST['square_m'];
	
	echo (pow($a, $k) % $m);
?>