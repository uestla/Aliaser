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
use Nette\Caching\Storages\DevNullStorage as NDevNullStorage;


class Container
{

	/** @var Parser */
	private $parser;

	/** @var array */
	private $map;

	/** @var NCache */
	private $cache = NULL;

	const C_FILE = 'file-';



	/** @param  NIStorage */
	function __construct(NIStorage $storage = NULL)
	{
		$this->parser = new Parser;
		$storage !== NULL && ($this->cache = new NCache($storage, __CLASS__));
	}



	/**
	 * @param  string $alias
	 * @param  string $file
	 * @param  string $namespace
	 * @return string
	 */
	function getClass($alias, $file, $namespace = '')
	{
		if (!strlen($alias) || substr($alias, 0, 1) === '\\') {
			return $alias;
		}

		$path = realpath($file);
		if ($path === FALSE) {
			throw new Exception\FileNotFoundException;
		}

		if (!isset($this->map[$path])) {
			if ($this->cache === NULL) {
				$list = Parser::parse($path);

			} else {
				$key = self::C_FILE . $path;
				$list = $this->cache->load($key);

				if ($list === NULL) {
					$list = $this->cache->save($key, Parser::parse($path), array(
						NCache::FILES => array($path),
					));
				}
			}

			$this->map[$path] = $list;
		}

		if (!isset($this->map[$path][$namespace])) {
			throw new Exception\NamespaceNotFoundException;
		}

		if (!isset($this->map[$path][$namespace][$alias])) {
			return ltrim(trim($namespace, '\\') . '\\', '\\') . $alias;
		}

		return $this->map[$path][$namespace][$alias];
	}

}
