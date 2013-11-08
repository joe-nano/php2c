<?php

namespace PHP2C\Parser\Node\Stmt;

use PHP2C\Parser\Node\Stmt,
	PHP2C\Parser\Node;

/**
 * @property Constant[] $consts Constant declarations
 */
class Constant extends Stmt
{
    /**
     * Constructs a const list node.
     *
     * @param Constant[] $consts     Constant declarations
     * @param array                  $attributes Additional attributes
     */
    public function __construct(array $consts, array $attributes = array()) {
        parent::__construct(
            array(
                'consts' => $consts,
            ),
            $attributes
        );
    }
}