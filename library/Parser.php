<?php

namespace PHP2C;


class Parser {
	public function parse($content)
	{
		$tokens = @token_get_all($content);
		var_dump($tokens);
	}
} 