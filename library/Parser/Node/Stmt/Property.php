<?php

namespace PHP2C\Parser\Node\Stmt;

use PHP2C\Parser\Node\Stmt\CustomClass,
	PHP2C\Parser\Node\Stmt;

/**
 * @property int                                    $type  Modifiers
 * @property Property[] $props Properties
 */
class Property extends Stmt
{
    /**
     * Constructs a class property list node.
     *
     * @param int                                    $type       Modifiers
     * @param Property[] $props      Properties
     * @param array                                  $attributes Additional attributes
     */
    public function __construct($type, array $props, array $attributes = array()) {
        parent::__construct(
            array(
                'type'  => $type,
                'props' => $props,
            ),
            $attributes
        );
    }

    public function isPublic() {
        return (bool) (	$this->type & CustomClass::MODIFIER_PUBLIC);
    }

    public function isProtected() {
        return (bool) ($this->type & CustomClass::MODIFIER_PROTECTED);
    }

    public function isPrivate() {
        return (bool) ($this->type & CustomClass::MODIFIER_PRIVATE);
    }

    public function isStatic() {
        return (bool) ($this->type & CustomClass::MODIFIER_STATIC);
    }
}