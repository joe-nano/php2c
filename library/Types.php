<?php

namespace PHP2C;

/**
 * Class Types
 * @package PHP2C
 */
class Types {
	const PHP_NULL = 0;
	const PHP_STRING = 1;
	const PHP_INT = 2;
	const PHP_BOOL = 3;
	const PHP_ARRAY = 4;
	const PHP_RESOURCE = 5;
	const PHP_OBJECT = 6;

	const INT = 'int';
	const UINT = 'uint';
	const DOUBLE = 'double';
	const BOOL = 'bool';
	const ULONG = 'ulong';
	const VOID = 'void';
	const STRING = 'string';
	const NULL = 'null';

	/**
	 * @return array
	 */
	public function getPHPTypes()
	{
		return array(
			'PHP_NULL' => self::PHP_NULL,
			'PHP_STRING' => self::PHP_STRING,
			'PHP_INT' => self::PHP_INT,
			'PHP_BOOL' => self::PHP_BOOL,
			'PHP_ARRAY' => self::PHP_ARRAY,
			'PHP_RESOURCE' => self::PHP_RESOURCE,
			'PHP_OBJECT' => self::PHP_OBJECT
		);
	}
} 