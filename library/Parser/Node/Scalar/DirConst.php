<?php

namespace PHP2C\Parser\Node\Scalar;

class DirConst extends \PHP2C\Parser\Node\Scalar
{
    /**
     * Constructs a __DIR__ const node
     *
     * @param array $attributes Additional attributes
     */
    public function __construct(array $attributes = array()) {
        parent::__construct(array(), $attributes);
    }
}