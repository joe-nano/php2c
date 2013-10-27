<?php

namespace PHP2C\Defines;

class Manager {
	/**
	 * List of defines
	 * @var array
	 */
	protected $_defines = array();

	/**
	 * @param string $path
	 */
	public function add($path)
	{
		if (!is_string($path)) {
			throw new \InvalidArgumentException('$path must be only string type');
		}

		$this->_defines[$path] = $path;
	}

	/**
	 * @return array
	 */
	public function get()
	{
		return $this->_headers;
	}
}