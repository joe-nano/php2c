<?php

namespace PHP2C\Parser\Node\Stmt;

use PHP2C\Parser\Node\Stmt,
	PHP2C\Parser\Node;

/**
 * @property Node\Expr[] $exprs Expressions
 */
class CustomEcho extends Stmt
{
    /**
     * Constructs an echo node.
     *
     * @param Node\Expr[] $exprs      Expressions
     * @param array                 $attributes Additional attributes
     */
    public function __construct(array $exprs, array $attributes = array()) {
        parent::__construct(
            array(
                'exprs' => $exprs,
            ),
            $attributes
        );
    }
}