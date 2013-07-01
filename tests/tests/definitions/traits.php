<?php

namespace
{

	use A\B\C;
	use D as E;
	use F\Z, G\H, I\J\K as L;


	trait TFoo
	{

		function bar()
		{
			echo 'hello';
		}

	}



	class Wee
	{

		use TFoo;

	}

}



namespace A
{

	use A\B\C;
	use D as E;
	use F\Z, G\H, I\J\K as L;
	use TFoo;


	trait TBar
	{

		function foo()
		{
			echo 'world';
		}

	}



	class Wee
	{

		use TFoo, TBar;

	}

}
