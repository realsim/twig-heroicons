<?php
/**
 * Created by simpson <simpsonwork@gmail.com>
 * Date: 25.01.2021
 * Time: 19:50
 */

namespace Mechanic\Twig\Extra\Heroicons\Node;

use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Node;

final class HeroiconNode extends Node
{
    public function __construct(AbstractExpression $icon, ?AbstractExpression $cssClasses, ?AbstractExpression $cssStyle, int $lineno = 0, string $tag = null)
    {
        $nodes = ['icon' => $icon];

        if (null !== $cssClasses) {
            $nodes['class'] = $cssClasses;
        }

        if (null !== $cssStyle) {
            $nodes['style'] = $cssStyle;
        }

        parent::__construct($nodes, [], $lineno, $tag);
    }

    public function compile(Compiler $compiler)
    {
        $svgDirectory = __DIR__.'/../../resources/svg';

        $svgPath = $compiler->getVarName();
        $svgSource = $compiler->getVarName();
        $compiler
            ->write(sprintf("$%s = '%s/' . ", $svgPath, $svgDirectory))
            ->subcompile($this->getNode('icon'))
            ->raw(" . '.svg';\n")
            ->write(sprintf("if (file_exists($%s)) {\n", $svgPath))
            ->indent()
            ->write(sprintf("$%s = file_get_contents($%s);\n", $svgSource, $svgPath))
            ->write("echo '<svg ';\n")
        ;

        $this->addHtmlAttribute($compiler, 'class');
        $this->addHtmlAttribute($compiler, 'style');

        $compiler
            ->write(sprintf("echo str_replace('<svg ', '', $%s);\n", $svgSource))
            ->outdent()
            ->write("} else {\n")
            ->indent()
            ->write('echo "<!-- Heroicon does not exist: " . ')
            ->subcompile($this->getNode('icon'))
            ->raw(" . ' -->';\n")
            ->outdent()
            ->write("}\n")
        ;
    }

    private function addHtmlAttribute(Compiler $compiler, string $attribute)
    {
        if (!$this->hasNode($attribute)) {
            return;
        }

        $compiler
            ->write(sprintf("echo '%s=\"' . ", $attribute))
            ->subcompile($this->getNode($attribute))
            ->raw(" . '\" ';\n")
        ;
    }
}
