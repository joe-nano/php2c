<?php

use PHP2C\Parser as Parser,
	PHP2C\Parser\Node\Expr\ConstFetch,
	PHP2C\Parser\Node\Scalar\LNumber,
	PHP2C\Parser\Node\Scalar\DNumber,
	PHP2C\Parser\Node\Scalar\String,
	PHP2C\Parser\Node\Scalar\DirConst,
	PHP2C\Parser\Node\Expr\ArrayItem,
	PHP2C\Parser\Node\Expr\CustomArray;

class PHPParser_Tests_Builder_PropertyTest extends \PHPUnit_Framework_TestCase
{
    public function createPropertyBuilder($name) {
        return new \Parser\Builder\Property($name);
    }

    public function testModifiers() {
        $node = $this->createPropertyBuilder('test')
            ->makePrivate()
            ->makeStatic()
            ->getNode()
        ;

        $this->assertEquals(
            new PHPParser_Node_Stmt_Property(
                PHPParser_Node_Stmt_Class::MODIFIER_PRIVATE
              | PHPParser_Node_Stmt_Class::MODIFIER_STATIC,
                array(
                    new PHPParser_Node_Stmt_PropertyProperty('test')
                )
            ),
            $node
        );

        $node = $this->createPropertyBuilder('test')
            ->makeProtected()
            ->getNode()
        ;

        $this->assertEquals(
            new PHPParser_Node_Stmt_Property(
                PHPParser_Node_Stmt_Class::MODIFIER_PROTECTED,
                array(
                    new PHPParser_Node_Stmt_PropertyProperty('test')
                )
            ),
            $node
        );

        $node = $this->createPropertyBuilder('test')
            ->makePublic()
            ->getNode()
        ;

        $this->assertEquals(
            new PHPParser_Node_Stmt_Property(
                PHPParser_Node_Stmt_Class::MODIFIER_PUBLIC,
                array(
                    new PHPParser_Node_Stmt_PropertyProperty('test')
                )
            ),
            $node
        );
    }

    /**
     * @dataProvider provideTestDefaultValues
     */
    public function testDefaultValues($value, $expectedValueNode) {
        $node = $this->createPropertyBuilder('test')
            ->setDefault($value)
            ->getNode()
        ;

        $this->assertEquals($expectedValueNode, $node->props[0]->default);
    }

    public function provideTestDefaultValues() {
        return array(
            array(
                null,
                new ConstFetch(new Parser\Node\Name('null'))
            ),
            array(
                true,
                new ConstFetch(new Parser\Node\Name('true'))
            ),
            array(
                false,
                new ConstFetch(new Parser\Node\Name('false'))
            ),
            array(
                31415,
                new LNumber(31415)
            ),
            array(
                3.1415,
                new DNumber(3.1415)
            ),
            array(
                'Hallo World',
                new String('Hallo World')
            ),
            array(
                array(1, 2, 3),
                new CustomArray(array(
                    new ArrayItem(new LNumber(1)),
                    new ArrayItem(new LNumber(2)),
                    new ArrayItem(new LNumber(3)),
                ))
            ),
            array(
                array('foo' => 'bar', 'bar' => 'foo'),
                new CustomArray(array(
                    new ArrayItem(
                        new String('bar'),
                        new String('foo')
                    ),
                    new ArrayItem(
                        new String('foo'),
                        new String('bar')
                    ),
                ))
            ),
            array(
                new DirConst,
                new DirConst
            )
        );
    }
}