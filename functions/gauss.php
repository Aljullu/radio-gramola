<?
/*****************
 * Codi agafat de:
 * http://www.mombu.com/php/php/t-generating-random-numbers-with-normal-distribution-3651341.html
 * ***************/
function gauss() { // N(0,1)
	// returns random number with normal distribution:
	// mean=0
	// std dev=1

	// auxilary vars
	$x=random_0_1();
	$y=random_0_1();

	// two independent variables with normal distribution N(0,1)
	$u=sqrt(-2*log($x))*cos(2*pi()*$y);
	$v=sqrt(-2*log($x))*sin(2*pi()*$y);

	// i will return only one, couse only one needed
	return $u;
}

function gauss_ms($m=0.0,$s=1.0) { // N(m,s)
	// returns random number with normal distribution:
	// mean=m
	// std dev=s

	return gauss()*$s+$m;
}

function random_0_1() { // auxiliary function
	// returns random number with flat distribution from 0 to 1
	return (float)rand()/(float)getrandmax();
} 

/**************
 * Codi propi
 * ************/
function randg($min, $max) {
	$value = gauss_ms(($max-$min)/2,($max-$min)/4);
	if ($value < $max && $value > $min) return $value;
	else return randg($min, $max);
}

function randgextended($min, $max, $m, $s) {
	$value = gauss_ms($m, $s);
	if ($value < $max && $value > $min) return $value;
	else return randgextended($min, $max, $m, $s);
}

?>
