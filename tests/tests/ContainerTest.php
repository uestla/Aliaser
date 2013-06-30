<?php


class ContainerTest extends PHPUnit_Framework_TestCase
{

	function testSimple()
	{
		$aliaser = SL::aliaser();
		$ref = new ReflectionClass('X');

		$this->assertEquals('A\B\C', $aliaser->getClass('C', $ref));
		$this->assertEquals('D', $aliaser->getClass('E', $ref));
		$this->assertEquals('F\Z', $aliaser->getClass('Z', $ref));
		$this->assertEquals('G\H', $aliaser->getClass('H', $ref));
		$this->assertEquals('I\J\K', $aliaser->getClass('L', $ref));
		$this->assertEquals('X', $aliaser->getClass('X', $ref));
		$this->assertEquals('OtherClasses', $aliaser->getClass('OtherClasses', $ref));
	}



	function testSingleSpace()
	{
		$aliaser = SL::aliaser();
		$ref = new ReflectionClass('Foo\Bar');

		$this->assertEquals('A\B\C', $aliaser->getClass('C', $ref));
		$this->assertEquals('D', $aliaser->getClass('E', $ref));
		$this->assertEquals('F', $aliaser->getClass('F', $ref));
		$this->assertEquals('G\H', $aliaser->getClass('H', $ref));
		$this->assertEquals('I\J\K', $aliaser->getClass('L', $ref));
		$this->assertEquals('Foo\Bar', $aliaser->getClass('Bar', $ref));
		$this->assertEquals('Foo\OtherClasses', $aliaser->getClass('OtherClasses', $ref));
	}



	function testMultiSpace()
	{
		$aliaser = SL::aliaser();
		$fooRef = new ReflectionClass('Foo');

		$this->assertEquals('A\B\C', $aliaser->getClass('C', $fooRef));
		$this->assertEquals('D', $aliaser->getClass('E', $fooRef));
		$this->assertEquals('F\Z', $aliaser->getClass('Z', $fooRef));
		$this->assertEquals('G\H', $aliaser->getClass('H', $fooRef));
		$this->assertEquals('I\J\K', $aliaser->getClass('L', $fooRef));
		$this->assertEquals('Foo', $aliaser->getClass('Foo', $fooRef));
		$this->assertEquals('OtherClasses', $aliaser->getClass('OtherClasses', $fooRef));

		$fooFooRef = new ReflectionClass('Foo\Foo');

		$this->assertEquals('A\B\C', $aliaser->getClass('C', $fooFooRef));
		$this->assertEquals('D', $aliaser->getClass('E', $fooFooRef));
		$this->assertEquals('F', $aliaser->getClass('F', $fooFooRef));
		$this->assertEquals('G\H', $aliaser->getClass('H', $fooFooRef));
		$this->assertEquals('I\J\K', $aliaser->getClass('L', $fooFooRef));
		$this->assertEquals('Foo\Foo', $aliaser->getClass('Foo', $fooFooRef));
		$this->assertEquals('Foo\OtherClasses', $aliaser->getClass('OtherClasses', $fooFooRef));
	}

}
