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
	 * @param  \ReflectionClass $context
	 * @return string
	 */
	function getClass($alias, \ReflectionClass $context)
	{
		if (!strlen($alias)) {
			return $alias;
		}

		if (substr($alias, 0, 1) === '\\') {
			return substr($alias, 1);
		}

		$file = $context->getFileName();

		if (!isset($this->map[$file])) {
			if ($this->cache === NULL) {
				$list = Parser::parse($file);

			} else {
				$key = self::C_FILE . $file;
				$list = $this->cache->load($key);

				if ($list === NULL) {
					$list = $this->cache->save($key, Parser::parse($file), array(
						NCache::FILES => array($file),
					));
				}
			}

			$this->map[$file] = $list;
		}

		$namespace = $context->getNamespaceName();

		if (!isset($this->map[$file][$namespace])) {
			throw new Exception\NamespaceNotFoundException;
		}

		if (!isset($this->map[$file][$namespace][$alias])) {
			return ltrim(trim($namespace, '\\') . '\\', '\\') . $alias;
		}

		return $this->map[$file][$namespace][$alias];
	}

}
