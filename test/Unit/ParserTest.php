<?php

declare(strict_types=1);

namespace Netcarver\Textile\Test\Unit;

use InvalidArgumentException;
use Netcarver\Textile\Parser;
use PHPUnit\Framework\TestCase;

final class ParserTest extends TestCase
{
    /**
     * Textile parser.
     *
     * @var Parser
     */
    private $parser;

    public function setUp(): void
    {
        $this->parser = new Parser();
    }

    public function testInvalidSymbol(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->parser->getSymbol('invalidSymbolName');
    }

    public function testSetGetSymbol(): void
    {
        $this->assertEquals('TestValue', $this->parser->setSymbol('test', 'TestValue')->getSymbol('test'));
        $this->assertArrayHasKey('test', (array) $this->parser->getSymbol());
    }

    public function testSetGetDimensionlessImage(): void
    {
        $this->assertFalse($this->parser->getDimensionlessImages());
        $this->assertTrue($this->parser->setDimensionlessImages(true)->getDimensionlessImages());
    }

    public function testEncode(): void
    {
        $encoded = $this->parser->textileEncode('& &amp; &#124; &#x0022 &#x0022;');
        $this->assertEquals('&amp; &amp; &#124; &amp;#x0022 &#x0022;', $encoded);
    }

    public function testInvalidDocumentType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Parser('InvalidDocumentType');
    }

    public function testInstanceSharingAndFootnoteIndex(): void
    {
        $previous = ['', '<p><strong>strong</strong></p>'];

        for ($i = 1; $i <= 100; $i++) {
            $content = "Note[1]\n\nfn1. Footnote";
            $parsed[0] = $this->parser->parse($content);
            $parsed[1] = $this->parser->parse('*strong*');
            $this->assertTrue($parsed[0] !== $previous[0]);
            $this->assertEquals($previous[1], $parsed[1]);
            $previous[0] = $parsed[0];
            $previous[1] = $parsed[1];
        }
    }

    public function testLineSpaceEscaping(): void
    {
        $this->assertEquals(' <strong>line</strong>', $this->parser->parse(' *line*'));
    }

    public function testDocumentRoot(): void
    {
        $this->parser->setDocumentRootDirectory(__DIR__);
        $this->assertEquals(__DIR__, \rtrim($this->parser->getDocumentRootDirectory(), '\\/'));
    }

    public function testDisallowImages(): void
    {
        $this->assertFalse($this->parser->setImages(false)->isImageTagEnabled());
        $this->assertTrue($this->parser->setImages(true)->isImageTagEnabled());
    }

    public function testLinkRelationShip(): void
    {
        $this->assertEquals('test', $this->parser->setLinkRelationShip('test')->getLinkRelationShip());
    }

    public function testEnableRestrictedMode(): void
    {
        $this->assertTrue($this->parser->setRestricted(true)->isRestrictedModeEnabled());
        $this->assertFalse($this->parser->setRestricted(false)->isRestrictedModeEnabled());
    }

    public function testImagePrefix(): void
    {
        $this->assertEquals('test', $this->parser->setLinkPrefix('test')->getLinkPrefix());
    }

    public function testLinkPrefix(): void
    {
        $this->assertEquals('test', $this->parser->setImagePrefix('test')->getImagePrefix());
    }
}
