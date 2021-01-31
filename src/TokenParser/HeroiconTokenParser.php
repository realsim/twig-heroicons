<?php
/**
 * Created by simpson <simpsonwork@gmail.com>
 * Date: 25.01.2021
 * Time: 19:48
 */

namespace Mechanic\Twig\Extra\Heroicons\TokenParser;

use Mechanic\Twig\Extra\Heroicons\Node\HeroiconNode;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

final class HeroiconTokenParser extends AbstractTokenParser
{
    public function parse(Token $token): HeroiconNode
    {
        $icon = $this->parser->getExpressionParser()->parseExpression();
        $stream = $this->parser->getStream();

        $cssClasses = null;
        if ($stream->nextIf(Token::NAME_TYPE, 'class')) {
            $cssClasses = $this->parser->getExpressionParser()->parseExpression();
        }

        $cssStyle = null;
        if ($stream->nextIf(Token::NAME_TYPE, 'style')) {
            $cssStyle = $this->parser->getExpressionParser()->parseExpression();
        }

        $stream->expect(Token::BLOCK_END_TYPE);

        return new HeroiconNode($icon, $cssClasses, $cssStyle, $token->getLine(), $this->getTag());
    }

    public function getTag(): string
    {
        return 'heroicon';
    }
}
