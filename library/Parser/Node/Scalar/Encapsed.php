<?php

/**
 * @property array $parts Encaps list
 */
class PHPParser_Node_Scalar_Encapsed extends \PHP2C\Parser\Node\Scalar
{
    /**
     * Constructs an encapsed string node.
     *
     * @param array $parts      Encaps list
     * @param array $attributes Additional attributes
     */
    public function __construct(array $parts = array(), array $attributes = array()) {
        parent::__construct(
            array(
                'parts' => $parts
            ),
            $attributes
        );
    }
}