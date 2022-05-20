<?php

/**
 * Textile - A Humane Web Text Generator.
 *
 * @link https://github.com/textile/php-textile
 */

namespace Netcarver\Textile\Test;

use PHPUnit\Framework\TestCase;
use Netcarver\Textile\Tag;

class TagTest extends TestCase
{
    public function testTagAttributesGenerator()
    {
        $attributes = new Tag(null, array('name' => 'value'));
        $this->assertEquals(' name="value"', (string) $attributes);
    }
}
