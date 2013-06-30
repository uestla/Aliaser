<?php

use \A\B\C;
use D as E;
use F\Z , G\H, I\J\K as L;



/**
 * Expectations:
 *
 * C -> A\B\C
 * E -> D
 * F -> F
 * H -> G\H
 * L -> I\J\K
 * other: <class_name>
 */


class X
{

	function foo()
	{
		return new \DateTime;
	}

}
