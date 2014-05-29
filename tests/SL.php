<?php


class SL
{

	/** @var array */
	private static $services = array();


	/** @return Nette\Caching\Storages\FileStorage */
	static function cacheStorage()
	{
		return self::get('cacheStorage', function () {
			return new Nette\Caching\Storages\FileStorage(__DIR__ . '/temp');
		});
	}


	/**
	 * @param  string $key
	 * @param  Closure $factory
	 * @return mixed
	 */
	private static function get($key, Closure $factory)
	{
		if (!isset(self::$services[$key])) {
			self::$services[$key] = $factory();
		}

		return self::$services[$key];
	}

}
