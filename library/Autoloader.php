<?php

namespace PHP2C;

/**
 * @codeCoverageIgnore
 */
class Autoloader
{
	static public function register()
	{
		ini_set('unserialize_callback_func', 'spl_autoload_call');
		spl_autoload_register(array(__CLASS__, 'autoload'));
	}

	static public function autoload($class)
	{
		$class = str_replace('PHP2C', 'library', $class);
		$file = dirname(dirname(__FILE__)) . '/' . str_replace("\\", DIRECTORY_SEPARATOR, strtr($class, '_', '/')) . '.php';

		if (is_file($file)) {
			require $file;
		}
	}
}