<?php

namespace PHP2C\Parser\Node\Expr;

use PHP2C\Parser as Parser;

/**
 * @property Parser\Node\Name $name Constant name
 */
class ConstFetch extends \PHP2C\Parser\Node\Expr
{
    /**
     * Constructs a const fetch node.
     *
     * @param Parser\Node\Name $name       Constant name
     * @param array               $attributes Additional attributes
     */
    public function __construct(Parser\Node\Name $name, array $attributes = array()) {
        parent::__construct(
            array(
                'name'  => $name
            ),
            $attributes
        );
    }
}