<?php


class ContainerTest extends PHPUnit_Framework_TestCase
{

	function testSimple()
	{
		$aliaser = SL::aliaser();
		$file = __DIR__ . '/definitions/simple.php';

		$this->assertEquals('A\B\C', $aliaser->getClass('C', $file));
		$this->assertEquals('D', $aliaser->getClass('E', $file));
		$this->assertEquals('F\Z', $aliaser->getClass('Z', $file));
		$this->assertEquals('G\H', $aliaser->getClass('H', $file));
		$this->assertEquals('I\J\K', $aliaser->getClass('L', $file));
		$this->assertEquals('X', $aliaser->getClass('X', $file));
		$this->assertEquals('OtherClasses', $aliaser->getClass('OtherClasses', $file));
	}



	function testSingleSpace()
	{
		$aliaser = SL::aliaser();
		$file = __DIR__ . '/definitions/singlespace.php';

		$this->assertEquals('A\B\C', $aliaser->getClass('C', $file, 'Foo'));
		$this->assertEquals('D', $aliaser->getClass('E', $file, 'Foo'));
		$this->assertEquals('F', $aliaser->getClass('F', $file, 'Foo'));
		$this->assertEquals('G\H', $aliaser->getClass('H', $file, 'Foo'));
		$this->assertEquals('I\J\K', $aliaser->getClass('L', $file, 'Foo'));
		$this->assertEquals('Foo\Bar', $aliaser->getClass('Bar', $file, 'Foo'));
		$this->assertEquals('Foo\OtherClasses', $aliaser->getClass('OtherClasses', $file, 'Foo'));
	}



	function testMultiSpace()
	{
		$aliaser = SL::aliaser();
		$file = __DIR__ . '/definitions/multispace.php';

		$this->assertEquals('A\B\C', $aliaser->getClass('C', $file));
		$this->assertEquals('D', $aliaser->getClass('E', $file));
		$this->assertEquals('F\Z', $aliaser->getClass('Z', $file));
		$this->assertEquals('G\H', $aliaser->getClass('H', $file));
		$this->assertEquals('I\J\K', $aliaser->getClass('L', $file));
		$this->assertEquals('Foo', $aliaser->getClass('Foo', $file));
		$this->assertEquals('OtherClasses', $aliaser->getClass('OtherClasses', $file));

		$this->assertEquals('A\B\C', $aliaser->getClass('C', $file, 'Foo'));
		$this->assertEquals('D', $aliaser->getClass('E', $file, 'Foo'));
		$this->assertEquals('F', $aliaser->getClass('F', $file, 'Foo'));
		$this->assertEquals('G\H', $aliaser->getClass('H', $file, 'Foo'));
		$this->assertEquals('I\J\K', $aliaser->getClass('L', $file, 'Foo'));
		$this->assertEquals('Foo\Foo', $aliaser->getClass('Foo', $file, 'Foo'));
		$this->assertEquals('Foo\OtherClasses', $aliaser->getClass('OtherClasses', $file, 'Foo'));
	}



	function testReflection()
	{
		$aliaser = SL::aliaser();
		$ref = new ReflectionClass('Foo\Foo');

		$file = $ref->getFileName();
		$namespace = $ref->getNamespaceName();

		$this->assertEquals('A\B\C', $aliaser->getClass('C', $file, $namespace));
		$this->assertEquals('D', $aliaser->getClass('E', $file, $namespace));
		$this->assertEquals('F', $aliaser->getClass('F', $file, $namespace));
		$this->assertEquals('G\H', $aliaser->getClass('H', $file, $namespace));
		$this->assertEquals('I\J\K', $aliaser->getClass('L', $file, $namespace));
		$this->assertEquals('Foo\OtherClasses', $aliaser->getClass('OtherClasses', $file, $namespace));
	}

}
