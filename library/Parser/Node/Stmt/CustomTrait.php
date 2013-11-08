<?php

namespace PHP2C\Parser\Node\Stmt;

use PHP2C\Parser\Node;

/**
 * @property string           $name  Name
 * @property Node[] $stmts Statements
 */
class CustomTrait extends Node\Stmt
{
    /**
     * Constructs a trait node.
     *
     * @param string           $name       Name
     * @param Node[] $stmts      Statements
     * @param array            $attributes Additional attributes
     */
    public function __construct($name, array $stmts = array(), array $attributes = array()) {
        parent::__construct(
            array(
                'name'  => $name,
                'stmts' => $stmts,
            ),
            $attributes
        );
    }
}