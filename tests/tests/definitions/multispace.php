<?php

namespace
{

	use A\B\C;
	use D as E;
	use F\Z, G\H, I\J\K as L;

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

	class Foo
	{
		private static function bar()
		{
			return 'hello';
		}
	}

}



namespace Foo
{

	use A\B\C;
	use D as E;
	use F, G\H, I\J\K as L;

	/**
	 * Expectations:
	 *
	 * C -> A\B\C
	 * E -> D
	 * F -> F
	 * H -> G\H
	 * L -> I\J\K
	 * other: Foo\<class_name>
	 */

	class Foo
	{
		private static function bar()
		{
			return 'world';
		}
	}

}
