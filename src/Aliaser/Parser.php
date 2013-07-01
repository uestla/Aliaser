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


class Parser
{

	const S_IN_NAMESPACE = 1;
	const S_IN_USE = 2;
	const S_IN_USE_AS = 4;



	/**
	 * @param  string $file
	 * @return array
	 */
	static function parse($file)
	{
		$aliases = array();
		$source = file_get_contents($file);

		if ($source === FALSE) {
			throw new Exception\FileNotReadableException;
		}

		$state = NULL;
		$as = $use = $namespace = '';
		$mayComeUse = TRUE;

		foreach (@token_get_all($source) as $token) { // intentionally @
			if (is_array($token)) {
				switch ($token[0]) {
					case T_COMMENT:
					case T_DOC_COMMENT:
					case T_WHITESPACE:
						continue 2;

					case T_NAMESPACE:
						$namespace = '';
						$state = self::S_IN_NAMESPACE;
						continue 2;

					case T_USE:
						if ($mayComeUse) {
							$as = $use = '';
							$state = self::S_IN_USE;
						}

						continue 2;

					case T_AS:
						$state === self::S_IN_USE && ($state = self::S_IN_USE_AS);
						continue 2;

					case T_CLASS:
						$mayComeUse = FALSE;
						continue 2;

					case T_STRING:
					case T_NS_SEPARATOR:
						switch ($state) {
							case self::S_IN_NAMESPACE:
								$namespace .= $token[1];
								break;

							case self::S_IN_USE:
								$use .= $token[1];
								break;

							case self::S_IN_USE_AS:
								$as = $token[1];
								break;
						}

						continue 2;
				}
			}

			switch ($state) {
				case self::S_IN_NAMESPACE:
					$aliases[$namespace] = array();
					$mayComeUse = TRUE;
					break;

				case self::S_IN_USE:
				case self::S_IN_USE_AS:
					!isset($aliases[$namespace]) && ($aliases[$namespace] = array());
					$key = $as === '' ? basename(str_replace('\\', '/', $use)) : $as;
					$aliases[$namespace][$key] = ltrim($use, '\\');

					if ($token === ',') {
						$as = $use = '';
						continue 2;
					}

					break;
			}

			$state = NULL;
		}

		return $aliases;
	}

}
