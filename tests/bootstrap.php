<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/SL.php';

$loader = new Nette\Loaders\RobotLoader;
$loader->setCacheStorage(SL::cacheStorage());
$loader->addDirectory(__DIR__ . '/../');
$loader->register();

Aliaser\Container::setCacheStorage(SL::cacheStorage());
