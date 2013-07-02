<?php

use Aliaser\Container as Aliaser;


class ContainerTest extends PHPUnit_Framework_TestCase
{

	function testSimple()
	{
		$ref = new ReflectionClass('X');

		$this->assertEquals('A\B\C', Aliaser::getClass('C', $ref));
		$this->assertEquals('D', Aliaser::getClass('E', $ref));
		$this->assertEquals('F\Z', Aliaser::getClass('Z', $ref));
		$this->assertEquals('G\H', Aliaser::getClass('H', $ref));
		$this->assertEquals('I\J\K', Aliaser::getClass('L', $ref));
		$this->assertEquals('X', Aliaser::getClass('X', $ref));
		$this->assertEquals('OtherClasses', Aliaser::getClass('OtherClasses', $ref));
	}



	function testSingleSpace()
	{
		$ref = new ReflectionClass('Foo\Bar');

		$this->assertEquals('A\B\C', Aliaser::getClass('C', $ref));
		$this->assertEquals('D', Aliaser::getClass('E', $ref));
		$this->assertEquals('F', Aliaser::getClass('F', $ref));
		$this->assertEquals('G\H', Aliaser::getClass('H', $ref));
		$this->assertEquals('I\J\K', Aliaser::getClass('L', $ref));
		$this->assertEquals('Foo\Bar', Aliaser::getClass('Bar', $ref));
		$this->assertEquals('Foo\OtherClasses', Aliaser::getClass('OtherClasses', $ref));
	}



	function testMultiSpace()
	{
		$fooRef = new ReflectionClass('Foo');

		$this->assertEquals('A\B\C', Aliaser::getClass('C', $fooRef));
		$this->assertEquals('D', Aliaser::getClass('E', $fooRef));
		$this->assertEquals('F\Z', Aliaser::getClass('Z', $fooRef));
		$this->assertEquals('G\H', Aliaser::getClass('H', $fooRef));
		$this->assertEquals('I\J\K', Aliaser::getClass('L', $fooRef));
		$this->assertEquals('Foo', Aliaser::getClass('Foo', $fooRef));
		$this->assertEquals('OtherClasses', Aliaser::getClass('OtherClasses', $fooRef));

		$fooFooRef = new ReflectionClass('Foo\Foo');

		$this->assertEquals('A\B\C', Aliaser::getClass('C', $fooFooRef));
		$this->assertEquals('D', Aliaser::getClass('E', $fooFooRef));
		$this->assertEquals('F', Aliaser::getClass('F', $fooFooRef));
		$this->assertEquals('G\H', Aliaser::getClass('H', $fooFooRef));
		$this->assertEquals('I\J\K', Aliaser::getClass('L', $fooFooRef));
		$this->assertEquals('Foo\Foo', Aliaser::getClass('Foo', $fooFooRef));
		$this->assertEquals('Foo\OtherClasses', Aliaser::getClass('OtherClasses', $fooFooRef));
	}



	function testTypes()
	{
		$ref = new ReflectionClass('Model\Entities\TypesEntity');

		$this->assertEquals('object', Aliaser::getClass('\object', $ref));
		$this->assertEquals('resource', Aliaser::getClass('\resource', $ref));
		$this->assertEquals('mixed', Aliaser::getClass('\mixed', $ref));
		$this->assertEquals('number', Aliaser::getClass('\number', $ref));
		$this->assertEquals('callback', Aliaser::getClass('\callback', $ref));
		$this->assertEquals('void', Aliaser::getClass('\void', $ref));
	}



	function testTraits()
	{
		$ref = new ReflectionClass('Wee');

		$this->assertEquals('A\B\C', Aliaser::getClass('C', $ref));
		$this->assertEquals('D', Aliaser::getClass('E', $ref));
		$this->assertEquals('F\Z', Aliaser::getClass('Z', $ref));
		$this->assertEquals('G\H', Aliaser::getClass('H', $ref));
		$this->assertEquals('I\J\K', Aliaser::getClass('L', $ref));
		$this->assertEquals('Wee', Aliaser::getClass('Wee', $ref));
		$this->assertEquals('OtherClasses', Aliaser::getClass('OtherClasses', $ref));
	}

}
