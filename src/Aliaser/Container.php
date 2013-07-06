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
	 */
	static function getClass($alias, \ReflectionClass $context)
	{
		if (!strlen($alias)) {
			return $alias;
		}

		if (substr($alias, 0, 1) === '\\') {
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
			throw new Exception\NamespaceNotFoundException;
		}

		if (!isset(self::$map[$file][$namespace][$alias])) {
			return ltrim(trim($namespace, '\\') . '\\', '\\') . $alias;
		}

		return self::$map[$file][$namespace][$alias];
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
