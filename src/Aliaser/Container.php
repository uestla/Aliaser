<?php

/**
 * This file is part of the Aliaser library
 *
 * Copyright (c) 2013 Petr Kessler (http://kesspess.1991.cz)
 *
 * @license  MIT
 * @link     https://github.com/uestla/Aliaser
 */

namespace Aliaser;

use Nette\Caching\Cache as NCache;
use Nette\Caching\IStorage as NIStorage;


class Container
{

	/** @var array */
	private static $map = array();

	/** @var NCache */
	private static $cache = NULL;

	const C_FILE = 'file-';



	/** @throws Exception\StaticClassException */
	final function __construct()
	{
		throw new Exception\StaticClassException;
	}



	/**
	 * @param  string $alias
	 * @param  \ReflectionClass $context
	 * @return string
	 * @throws Exception\NamespaceNotFoundException
	 */
	static function getClass($alias, \ReflectionClass $context)
	{
		if (!strlen($alias)) {
			return $alias;
		}

		if (strncmp($alias, '\\', 1) === 0) {
			return substr($alias, 1);
		}

		$file = $context->getFileName();

		if (!isset(self::$map[$file])) {
			if (self::$cache === NULL) {
				$list = Parser::parse($file);

			} else {
				$key = self::C_FILE . $file;
				$list = self::$cache->load($key);

				if ($list === NULL) {
					$list = self::$cache->save($key, Parser::parse($file), array(
						NCache::FILES => array($file),
					));
				}
			}

			self::$map[$file] = $list;
		}

		$namespace = $context->getNamespaceName();

		if (!isset(self::$map[$file][$namespace])) {
			throw new Exception\NamespaceNotFoundException("Namespace '$namespace' not found in '$file'.");
		}

		$parts = explode('\\', $alias);
		$first = array_shift($parts);

		if (!isset(self::$map[$file][$namespace][$first])) {
			return ltrim(trim($namespace, '\\') . '\\', '\\') . $alias;
		}

		$appendix = implode('\\', $parts);
		return self::$map[$file][$namespace][$first] . (strlen($appendix) ? '\\' . $appendix : '');
	}



	/**
	 * @param  string $callback
	 * @param  \ReflectionClass $context
	 * @return string
	 * @throws Exception\FunctionNotFoundException
	 */
	static function getCallback($callback, \ReflectionClass $context)
	{
		if (!strlen($callback)) {
			return $callback;
		}

		if (strncmp($callback, '\\', 1) === 0) {
			return substr($callback, 1);
		}

		if (($a = strpos($callback, '::')) !== FALSE) { // Class::method
			return self::getClass(substr($callback, 0, $a), $context) . '::' . substr($callback, $a + 2);
		}

		$candidates = array();

		if (($b = strpos($callback, '\\')) !== FALSE) {
			$candidates[] = self::getClass(substr($callback, 0, $b), $context) . '\\' . substr($callback, $b + 1);

		} else {
			// namespaced name first, then global space
			$candidates[] = $context->getNamespaceName() . '\\' . $callback;
			$candidates[] = $callback;
		}

		foreach ($candidates as $function) {
			if (function_exists($function)) {
				return $function;
			}
		}

		throw new Exception\FunctionNotFoundException("Function '$callback' not found in file '{$context->getFileName()}'.");
	}



	/**
	 * @param  NIStorage $storage
	 * @return void
	 */
	static function setCacheStorage(NIStorage $storage)
	{
		self::$cache = new NCache($storage, __CLASS__);
	}



	/** @return NIStorage */
	static function getCacheStorage()
	{
		return self::$cache->getStorage();
	}

}
