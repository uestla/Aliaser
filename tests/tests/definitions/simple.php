<?php

use \A\B\C;
use D as E;
use F\Z , G\H, I\J\K as L;
use Easy\Peasy;



/**
 * Expectations:
 *
 * C -> A\B\C
 * E -> D
 * F -> F
 * H -> G\H
 * L -> I\J\K
 * Peasy\Leasy\Feazy -> Easy\Peasy\Leasy\Feazy
 * other: <class_name>
 */


class X
{

	function foo()
	{
		return new \DateTime;
	}

}



$foo = 'bar';
$lambda = function () use ($foo) {
	return $foo . strrev($foo);
};
