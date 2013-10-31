<?php

namespace PHP2C\Parser\Node;

/**
 * @property string                          $name    Name
 * @property null|PHPParser_Node_Expr        $default Default value
 * @property null|string|PHPParser_Node_Name $type    Typehint
 * @property bool                            $byRef   Whether is passed by reference
 */
class Param extends \PHP2C\Parser\NodeAbstract
{
    /**
     * Constructs a parameter node.
     *
     * @param string                          $name       Name
     * @param null|PHPParser_Node_Expr        $default    Default value
     * @param null|string|PHPParser_Node_Name $type       Typehint
     * @param bool                            $byRef      Whether is passed by reference
     * @param array                           $attributes Additional attributes
     */
    public function __construct($name, $default = null, $type = null, $byRef = false, array $attributes = array()) {
        parent::__construct(
            array(
                'name'    => $name,
                'default' => $default,
                'type'    => $type,
                'byRef'   => $byRef
            ),
            $attributes
        );
    }
}