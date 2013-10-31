<?php

class PHPParser_Node_Scalar_FileConst extends \PHP2C\Parser\Node\Scalar
{
    /**
     * Constructs a __FILE__ const node
     *
     * @param array $attributes Additional attributes
     */
    public function __construct(array $attributes = array()) {
        parent::__construct(array(), $attributes);
    }
}