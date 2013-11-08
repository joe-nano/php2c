<?php

require_once dirname(__FILE__) . '/CodeTestAbstract.php';

class PHPParser_Tests_ParserTest extends PHPParser_Tests_CodeTestAbstract
{
    /**
     * @dataProvider provideTestParse
     */
    public function testParse($name, $code, $dump) {
        $parser = new \PHP2C\Parser(new PHPParser_Lexer_Emulative);
        $dumper = new \PHP2C\Parser\NodeDumper;

        $stmts = $parser->parse($code);
        $this->assertEquals(
            $this->canonicalize($dump),
            $this->canonicalize($dumper->dump($stmts)),
            $name
        );
    }

    public function provideTestParse() {
        return $this->getTests(dirname(__FILE__) . '/../../code/parser', 'test');
    }

    /**
     * @dataProvider provideTestParseFail
     */
    public function testParseFail($name, $code, $msg) {
        $parser = new \PHP2C\Parser(new PHPParser_Lexer_Emulative);

        try {
            $parser->parse($code);

            $this->fail(sprintf('"%s": Expected PHPParser_Error', $name));
        } catch (\PHP2C\Parser\Error $e) {
            $this->assertEquals($msg, $e->getMessage(), $name);
        }
    }

    public function provideTestParseFail() {
        return $this->getTests(dirname(__FILE__) . '/../../code/parser', 'test-fail');
    }
}