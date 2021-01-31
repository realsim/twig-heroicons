<?php
/**
 * Created by simpson <simpsonwork@gmail.com>
 * Date: 25.01.2021
 * Time: 19:19
 */

namespace Mechanic\Twig\Extra\Heroicons;

use Mechanic\Twig\Extra\Heroicons\TokenParser\HeroiconTokenParser;
use Twig\Extension\AbstractExtension;

class HeroiconsExtension extends AbstractExtension
{
    public function getTokenParsers(): array
    {
        return [
            // {% heroicon ... %}
            new HeroiconTokenParser(),
        ];
    }
}
