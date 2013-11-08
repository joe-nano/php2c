<?php

namespace PHP2C\Parser\Node\Expr;

use PHP2C\Parser\Node\Expr;

/**
 * @property Expr $expr Expression
 */
class CustomPrint extends Expr
{
    /**
     * Constructs an print() node.
     *
     * @param Expr $expr       Expression
     * @param array               $attributes Additional attributes
     */
    public function __construct(Expr $expr, array $attributes = array()) {
        parent::__construct(
            array(
                'expr' => $expr
            ),
            $attributes
        );
    }
}