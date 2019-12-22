<?php

declare(strict_types=1);

namespace Netcarver\Textile\Test\Unit;

use Netcarver\Textile\Tag;
use PHPUnit\Framework\TestCase;

final class TagTest extends TestCase
{
    public function testTagAttributesGenerator(): void
    {
        $tag = new Tag(null, ['name' => 'value']);
        $this->assertEquals(' name="value"', (string) $tag);
    }
}
