<?php

namespace PHP2C\Parser\Node\Expr;

/**
 * @property PHPParser_Node_Expr_ArrayItem[] $items Items
 */
class CustomArray extends \PHP2C\Parser\Node\Expr
{
    /**
     * Constructs an array node.
     *
     * @param PHPParser_Node_Expr_ArrayItem[] $items      Items of the array
     * @param array                           $attributes Additional attributes
     */
    public function __construct(array $items = array(), array $attributes = array()) {
        parent::__construct(
            array(
                'items' => $items
            ),
            $attributes
        );
    }
}