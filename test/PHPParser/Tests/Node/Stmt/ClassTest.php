<?php

use PHP2C\Parser\Node\Stmt\CustomClass,
	PHP2C\Parser\Node\Stmt\ClassMethod,
	PHP2C\Parser\Node\Stmt;

class PHPParser_Tests_Node_Stmt_ClassTest extends \PHPUnit_Framework_TestCase
{
    public function testIsAbstract() {
        $class = new CustomClass('Foo', array('type' => CustomClass::MODIFIER_ABSTRACT));
        $this->assertTrue($class->isAbstract());

        $class = new CustomClass('Foo');
        $this->assertFalse($class->isAbstract());
    }

    public function testIsFinal() {
        $class = new CustomClass('Foo', array('type' => CustomClass::MODIFIER_FINAL));
        $this->assertTrue($class->isFinal());

        $class = new CustomClass('Foo');
        $this->assertFalse($class->isFinal());
    }

    public function testGetMethods() {
        $methods = array(
            new ClassMethod('foo'),
            new ClassMethod('bar'),
            new ClassMethod('fooBar'),
        );
        $class = new CustomClass('Foo', array(
            'stmts' => array(
                new Stmt\TraitUse(array()),
                $methods[0],
                new Stmt\Constant(array()),
                $methods[1],
                new Stmt\Property(0, array()),
                $methods[2],
            )
        ));

        $this->assertEquals($methods, $class->getMethods());
    }
}