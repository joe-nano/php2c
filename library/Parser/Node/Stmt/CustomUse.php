<?php

namespace PHP2C\Parser\Node\Stmt;

use PHP2C\Parser\Node\Stmt,
	PHP2C\Parser\Node;

/**
 * @property Stmt\UseUse[] $uses Aliases
 */
class CustomUse extends Node\Stmt
{
    /**
     * Constructs an alias (use) list node.
     *
     * @param Stmt\UseUse[] $uses       Aliases
     * @param array                        $attributes Additional attributes
     */
    public function __construct(array $uses, array $attributes = array()) {
        parent::__construct(
            array(
                'uses' => $uses,
            ),
            $attributes
        );
    }
}