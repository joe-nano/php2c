<?php

namespace PHP2C\Parser\Node\Expr;

use PHP2C\Parser\Node;

/**
 * @property Node\Name|Node\Expr $class Class name
 * @property Node\Arg[]                    $args  Arguments
 */
class CustomNew extends Node\Expr
{
    /**
     * Constructs a function call node.
     *
     * @param Node\Name|Node\Expr $class      Class name
     * @param Node\Arg[]                    $args       Arguments
     * @param array                                   $attributes Additional attributes
     */
    public function __construct($class, array $args = array(), array $attributes = array()) {
        parent::__construct(
            array(
                'class' => $class,
                'args'  => $args
            ),
            $attributes
        );
    }
}