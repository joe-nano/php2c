<?php

namespace PHP2C\Headers;


class Manager {
	/**
	 * List of headers
	 * @var array
	 */
	protected $_headers = array();

	/**
	 * @param string $path
	 */
	public function add($path)
	{
		if (!is_string($path)) {
			throw new \InvalidArgumentException('$path must be only string type');
		}

		$this->_headers[$path] = $path;
	}

	/**
	 * @return array
	 */
	public function get()
	{
		return $this->_headers;
	}
} 