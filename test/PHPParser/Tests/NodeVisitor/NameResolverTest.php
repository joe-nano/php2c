<?php

use PHP2C\Parser;

class PHPParser_Tests_NodeVisitor_NameResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers PHPParser_NodeVisitor_NameResolver
     */
    public function testResolveNames() {
        $code = <<<EOC
<?php

namespace Foo {
    use Hallo as Hi;

    new Bar();
    new Hi();
    new Hi\\Bar();
    new \\Bar();
    new namespace\\Bar();

    bar();
    hi();
    Hi\\bar();
    foo\\bar();
    \\bar();
    namespace\\bar();
}
namespace {
    use Hallo as Hi;

    new Bar();
    new Hi();
    new Hi\\Bar();
    new \\Bar();
    new namespace\\Bar();

    bar();
    hi();
    Hi\\bar();
    foo\\bar();
    \\bar();
    namespace\\bar();
}
EOC;
        $expectedCode = <<<EOC
namespace Foo {
    use Hallo as Hi;
    new \\Foo\\Bar();
    new \\Hallo();
    new \\Hallo\\Bar();
    new \\Bar();
    new \\Foo\\Bar();
    bar();
    hi();
    \\Hallo\\bar();
    \\Foo\\foo\\bar();
    \\bar();
    \\Foo\\bar();
}
namespace {
    use Hallo as Hi;
    new \\Bar();
    new \\Hallo();
    new \\Hallo\\Bar();
    new \\Bar();
    new \\Bar();
    bar();
    hi();
    \\Hallo\\bar();
    \\foo\\bar();
    \\bar();
    \\bar();
}
EOC;

        $parser        = new Parser(new Parser\Lexer\Emulative);
        $prettyPrinter = new Parser\PrettyPrinter\CustomDefault;
        $traverser     = new Parser\NodeTraverser;
        $traverser->addVisitor(new Parser\NodeVisitor\NameResolver);

        $stmts = $parser->parse($code);
        $stmts = $traverser->traverse($stmts);

        $this->assertEquals($expectedCode, $prettyPrinter->prettyPrint($stmts));
    }

    /**
     * @covers PHPParser_NodeVisitor_NameResolver
     */
    public function testResolveLocations() {
        $code = <<<EOC
<?php
namespace NS;

class A extends B implements C {
    use A;
}

interface A extends C {
    public function a(A \$a);
}

A::b();
A::\$b;
A::B;
new A;
\$a instanceof A;

namespace\a();
namespace\A;

try {
    \$someThing;
} catch (A \$a) {
    \$someThingElse;
}
EOC;
        $expectedCode = <<<EOC
namespace NS;

class A extends \\NS\\B implements \\NS\\C
{
    use \\NS\\A;
}
interface A extends \\NS\\C
{
    public function a(\\NS\\A \$a);
}
\\NS\\A::b();
\\NS\\A::\$b;
\\NS\\A::B;
new \\NS\\A();
\$a instanceof \\NS\\A;
\\NS\\a();
\\NS\\A;
try {
    \$someThing;
} catch (\\NS\\A \$a) {
    \$someThingElse;
}
EOC;

        $parser        = new Parser(new Parser\Lexer\Emulative);
        $prettyPrinter = new Parser\PrettyPrinter\CustomDefault;
        $traverser     = new Parser\NodeTraverser;
        $traverser->addVisitor(new Parser\NodeVisitor\NameResolver);

        $stmts = $parser->parse($code);
        $stmts = $traverser->traverse($stmts);

        $this->assertEquals($expectedCode, $prettyPrinter->prettyPrint($stmts));
    }

    public function testNoResolveSpecialName() {
        $stmts = array(new Parser\Node\Expr\CustomNew(new Parser\Node\Name('self')));

        $traverser = new Parser\NodeTraverser;
        $traverser->addVisitor(new Parser\NodeVisitor\NameResolver);

        $this->assertEquals($stmts, $traverser->traverse($stmts));
    }

    protected function createNamespacedAndNonNamespaced(array $stmts) {
        return array(
            new Parser\Node\Stmt\CustomNamespace(new Parser\Node\Name('NS'), $stmts),
            new Parser\Node\Stmt\CustomNamespace(null,                          $stmts),
        );
    }

    public function testAddNamespacedName() {
        $stmts = $this->createNamespacedAndNonNamespaced(array(
            new Parser\Node\Stmt\CustomClass('A'),
            new Parser\Node\Stmt\CustomInterface('B'),
            new Parser\Node\Stmt\CustomFunction('C'),
            new Parser\Node\Stmt\Constant(array(
                new Parser\Node\Constant('D', new PHPParser_Node_Scalar_String('E'))
            )),
        ));

        $traverser = new PHPParser_NodeTraverser;
        $traverser->addVisitor(new PHPParser_NodeVisitor_NameResolver);

        $stmts = $traverser->traverse($stmts);

        $this->assertEquals('NS\\A', (string) $stmts[0]->stmts[0]->namespacedName);
        $this->assertEquals('NS\\B', (string) $stmts[0]->stmts[1]->namespacedName);
        $this->assertEquals('NS\\C', (string) $stmts[0]->stmts[2]->namespacedName);
        $this->assertEquals('NS\\D', (string) $stmts[0]->stmts[3]->consts[0]->namespacedName);
        $this->assertEquals('A',     (string) $stmts[1]->stmts[0]->namespacedName);
        $this->assertEquals('B',     (string) $stmts[1]->stmts[1]->namespacedName);
        $this->assertEquals('C',     (string) $stmts[1]->stmts[2]->namespacedName);
        $this->assertEquals('D',     (string) $stmts[1]->stmts[3]->consts[0]->namespacedName);
    }

    public function testAddTraitNamespacedName() {
        $stmts = $this->createNamespacedAndNonNamespaced(array(
            new PHPParser_Node_Stmt_Trait('A')
        ));

        $traverser = new PHPParser_NodeTraverser;
        $traverser->addVisitor(new PHPParser_NodeVisitor_NameResolver);

        $stmts = $traverser->traverse($stmts);

        $this->assertEquals('NS\\A', (string) $stmts[0]->stmts[0]->namespacedName);
        $this->assertEquals('A',     (string) $stmts[1]->stmts[0]->namespacedName);
    }

    /**
     * @expectedException        PHPParser_Error
     * @expectedExceptionMessage Cannot use "C" as "B" because the name is already in use on line 2
     */
    public function testAlreadyInUseError() {
        $stmts = array(
            new PHPParser_Node_Stmt_Use(array(
                new PHPParser_Node_Stmt_UseUse(new PHPParser_Node_Name('A\B'), 'B', array('startLine' => 1)),
                new PHPParser_Node_Stmt_UseUse(new PHPParser_Node_Name('C'),   'B', array('startLine' => 2)),
            ))
        );

        $traverser = new PHPParser_NodeTraverser;
        $traverser->addVisitor(new PHPParser_NodeVisitor_NameResolver);
        $traverser->traverse($stmts);
    }
}