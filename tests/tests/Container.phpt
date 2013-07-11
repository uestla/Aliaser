<?php

use Tester\Assert;
use Aliaser\Container as Aliaser;

require_once __DIR__ . '/../bootstrap.php';



$ref = new ReflectionClass('X');

Assert::equal('A\B\C', Aliaser::getClass('C', $ref));
Assert::equal('D', Aliaser::getClass('E', $ref));
Assert::equal('F\Z', Aliaser::getClass('Z', $ref));
Assert::equal('G\H', Aliaser::getClass('H', $ref));
Assert::equal('I\J\K', Aliaser::getClass('L', $ref));
Assert::equal('X', Aliaser::getClass('X', $ref));
Assert::equal('OtherClasses', Aliaser::getClass('OtherClasses', $ref));



$ref = new ReflectionClass('Foo\Bar');

Assert::equal('A\B\C', Aliaser::getClass('C', $ref));
Assert::equal('D', Aliaser::getClass('E', $ref));
Assert::equal('F', Aliaser::getClass('F', $ref));
Assert::equal('G\H', Aliaser::getClass('H', $ref));
Assert::equal('I\J\K', Aliaser::getClass('L', $ref));
Assert::equal('Foo\Bar', Aliaser::getClass('Bar', $ref));
Assert::equal('Foo\OtherClasses', Aliaser::getClass('OtherClasses', $ref));



$ref = new ReflectionClass('Foo');

Assert::equal('A\B\C', Aliaser::getClass('C', $ref));
Assert::equal('D', Aliaser::getClass('E', $ref));
Assert::equal('F\Z', Aliaser::getClass('Z', $ref));
Assert::equal('G\H', Aliaser::getClass('H', $ref));
Assert::equal('I\J\K', Aliaser::getClass('L', $ref));
Assert::equal('Foo', Aliaser::getClass('Foo', $ref));
Assert::equal('OtherClasses', Aliaser::getClass('OtherClasses', $ref));



$ref = new ReflectionClass('Foo\Foo');

Assert::equal('A\B\C', Aliaser::getClass('C', $ref));
Assert::equal('D', Aliaser::getClass('E', $ref));
Assert::equal('F', Aliaser::getClass('F', $ref));
Assert::equal('G\H', Aliaser::getClass('H', $ref));
Assert::equal('I\J\K', Aliaser::getClass('L', $ref));
Assert::equal('Foo\Foo', Aliaser::getClass('Foo', $ref));
Assert::equal('Foo\OtherClasses', Aliaser::getClass('OtherClasses', $ref));



$ref = new ReflectionClass('Model\Entities\TypesEntity');

Assert::equal('object', Aliaser::getClass('\object', $ref));
Assert::equal('resource', Aliaser::getClass('\resource', $ref));
Assert::equal('mixed', Aliaser::getClass('\mixed', $ref));
Assert::equal('number', Aliaser::getClass('\number', $ref));
Assert::equal('callback', Aliaser::getClass('\callback', $ref));
Assert::equal('void', Aliaser::getClass('\void', $ref));



$ref = new ReflectionClass('Wee');

Assert::equal('A\B\C', Aliaser::getClass('C', $ref));
Assert::equal('D', Aliaser::getClass('E', $ref));
Assert::equal('F\Z', Aliaser::getClass('Z', $ref));
Assert::equal('G\H', Aliaser::getClass('H', $ref));
Assert::equal('I\J\K', Aliaser::getClass('L', $ref));
Assert::equal('Wee', Aliaser::getClass('Wee', $ref));
Assert::equal('OtherClasses', Aliaser::getClass('OtherClasses', $ref));
