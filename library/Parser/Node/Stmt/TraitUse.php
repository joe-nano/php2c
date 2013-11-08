<?php

namespace PHP2C\Parser\Node\Stmt;

use PHP2C\Parser\Node;

/**
 * @property Node\Name[]                    $traits      Traits
 * @property Node\Stmt\TraitUseAdaptation[] $adaptations Adaptations
 */
class TraitUse extends Node\Stmt
{
    /**
     * Constructs a trait use node.
     *
     * @param Node\Name[]                    $traits      Traits
     * @param Node\Stmt\TraitUseAdaptation[] $adaptations Adaptations
     * @param array                                    $attributes  Additional attributes
     */
    public function __construct(array $traits, array $adaptations = array(), array $attributes = array()) {
        parent::__construct(
            array(
                'traits'      => $traits,
                'adaptations' => $adaptations,
            ),
            $attributes
        );
    }
}