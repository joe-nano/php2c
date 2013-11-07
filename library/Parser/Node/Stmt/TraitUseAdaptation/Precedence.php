<?php

namespace PHP2C\Parser\Node\Stmt\TraitUseAdaptation;

use PHP2C\Parser\Node\Stmt\TraitUseAdaptation,
	PHP2C\Parser\Node\Name;

/**
 * @property Name   $trait     Trait name
 * @property string                $method    Method name
 * @property Name[] $insteadof Overwritten traits
 */
class Precedence extends TraitUseAdaptation
{
    /**
     * Constructs a trait use precedence adaptation node.
     *
     * @param Name   $trait       Trait name
     * @param string                $method      Method name
     * @param Name[] $insteadof   Overwritten traits
     * @param array                 $attributes  Additional attributes
     */
    public function __construct(Name $trait, $method, array $insteadof, array $attributes = array()) {
        parent::__construct(
            array(
                'trait'     => $trait,
                'method'    => $method,
                'insteadof' => $insteadof,
            ),
            $attributes
        );
    }
}