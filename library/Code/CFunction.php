<?php

namespace PHP2C\Code;

class CFunction {
	protected $name;
	protected $returnType;
	protected $arguments;

	protected $code = [];

	public function addLine($code)
	{
		$this->code[] = "\t".$code . "\n";
	}

	public function output()
	{
		$code = $this->returnType . ' '.$this->name.'() {'."\n";
		$code .= implode('', $this->code);
		return $code .'}'."\n";
	}

	public function __construct($name, $returnType, $arguments)
	{
		$this->name = $name;
		$this->returnType = $returnType;
		$this->arguments = $arguments;
	}
} 