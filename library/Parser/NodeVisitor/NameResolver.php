<?php

namespace PHP2C\Parser\NodeVisitor;

use PHP2C\Parser\NodeVisitorAbstract,
	PHP2C\Parser\Node,
	PHP2C\Parser\Error;

class NameResolver extends NodeVisitorAbstract
{
    /**
     * @var null|Node\Name Current namespace
     */
    protected $namespace;

    /**
     * @var array Currently defined namespace and class aliases
     */
    protected $aliases;

    public function beforeTraverse(array $nodes) {
        $this->namespace = null;
        $this->aliases   = array();
    }

    public function enterNode(Node $node) {
        if ($node instanceof Node\Stmt\CustomNamespace) {
            $this->namespace = $node->name;
            $this->aliases   = array();
        } elseif ($node instanceof Node\Stmt\UseUse) {
            if (isset($this->aliases[$node->alias])) {
                throw new Error(
                    sprintf(
                        'Cannot use "%s" as "%s" because the name is already in use',
                        $node->name, $node->alias
                    ),
                    $node->getLine()
                );
            }

            $this->aliases[$node->alias] = $node->name;
        } elseif ($node instanceof Node\Stmt\CustomClass) {
            if (null !== $node->extends) {
                $node->extends = $this->resolveClassName($node->extends);
            }

            foreach ($node->implements as &$interface) {
                $interface = $this->resolveClassName($interface);
            }

            $this->addNamespacedName($node);
        } elseif ($node instanceof PHPParser_Node_Stmt_Interface) {
            foreach ($node->extends as &$interface) {
                $interface = $this->resolveClassName($interface);
            }

            $this->addNamespacedName($node);
        } elseif ($node instanceof Node\Stmt\CustomTrait) {
            $this->addNamespacedName($node);
        } elseif ($node instanceof Node\Stmt\CustomFunction) {
            $this->addNamespacedName($node);
        } elseif ($node instanceof Node\Stmt\Constant) {
            foreach ($node->consts as $const) {
                $this->addNamespacedName($const);
            }
        } elseif ($node instanceof Node\Expr\StaticCall
                  || $node instanceof Node\Expr\StaticPropertyFetch
                  || $node instanceof Node\Expr\ClassConstFetch
                  || $node instanceof Node\Expr\CustomNew
                  || $node instanceof Node\Expr\CustomInstanceof
        ) {
            if ($node->class instanceof Node\Name) {
                $node->class = $this->resolveClassName($node->class);
            }
        } elseif ($node instanceof Node\Stmt\CustomCatch) {
            $node->type = $this->resolveClassName($node->type);
        } elseif ($node instanceof Node\Expr\FuncCall
                  || $node instanceof Node\Expr\ConstFetch
        ) {
            if ($node->name instanceof Node\Name) {
                $node->name = $this->resolveOtherName($node->name);
            }
        } elseif ($node instanceof Node\Stmt\TraitUse) {
            foreach ($node->traits as &$trait) {
                $trait = $this->resolveClassName($trait);
            }
        } elseif ($node instanceof Node\Param
                  && $node->type instanceof Node\Name
        ) {
            $node->type = $this->resolveClassName($node->type);
        }
    }

    protected function resolveClassName(Node\Name $name) {
        // don't resolve special class names
        if (in_array((string) $name, array('self', 'parent', 'static'))) {
            return $name;
        }

        // fully qualified names are already resolved
        if ($name->isFullyQualified()) {
            return $name;
        }

        // resolve aliases (for non-relative names)
        if (!$name->isRelative() && isset($this->aliases[$name->getFirst()])) {
            $name->setFirst($this->aliases[$name->getFirst()]);
        // if no alias exists prepend current namespace
        } elseif (null !== $this->namespace) {
            $name->prepend($this->namespace);
        }

        return new Node\Name\FullyQualified($name->parts, $name->getAttributes());
    }

    protected function resolveOtherName(Node\Name $name) {
        // fully qualified names are already resolved and we can't do anything about unqualified
        // ones at compiler-time
        if ($name->isFullyQualified() || $name->isUnqualified()) {
            return $name;
        }

        // resolve aliases for qualified names
        if ($name->isQualified() && isset($this->aliases[$name->getFirst()])) {
            $name->setFirst($this->aliases[$name->getFirst()]);
        // prepend namespace for relative names
        } elseif (null !== $this->namespace) {
            $name->prepend($this->namespace);
        }

        return new Node\Name\FullyQualified($name->parts, $name->getAttributes());
    }

    protected function addNamespacedName(Node $node) {
        if (null !== $this->namespace) {
            $node->namespacedName = clone $this->namespace;
            $node->namespacedName->append($node->name);
        } else {
            $node->namespacedName = new Node\Name($node->name, $node->getAttributes());
        }
    }
}