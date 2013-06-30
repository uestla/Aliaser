<?php

use Nette\Diagnostics\Debugger;

require_once 'Nette/loader.php';
require_once 'PHPUnit/Autoload.php';
require_once __DIR__ . '/SL.php';

Debugger::$maxLen = FALSE;
Debugger::$maxDepth = FALSE;
Debugger::$strictMode = TRUE;
Debugger::enable(Debugger::DEVELOPMENT, FALSE);

$loader = new Nette\Loaders\RobotLoader;
$loader->setCacheStorage(SL::cacheStorage());
$loader->addDirectory(__DIR__ . '/../');
$loader->register();

function id($a) { return $a; }
