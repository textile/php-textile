<?php

/**
 * Textile - A Humane Web Text Generator.
 *
 * @link https://github.com/textile/php-textile
 */

namespace Netcarver\Textile\Test;

use Netcarver\Textile\Test\Parser\DeprecatedPrepare;
use Netcarver\Textile\Test\Parser\DeprecatedTextileCommon;
use PHPUnit\Framework\TestCase;
use Netcarver\Textile\Parser;

class ParserTest extends TestCase
{
    /**
     * @var Parser
     */
    private $parser;

    protected function setUp(): void
    {
        $this->parser = new Parser();
    }

    public function testGetVersion()
    {
        $this->assertIsString(
            $this->parser->getVersion()
        );
    }

    public function testInvalidSymbol()
    {
        $this->expectException('\InvalidArgumentException');
        $this->parser->getSymbol('invalidSymbolName');
    }

    public function testSetGetSymbol()
    {
        $value = 'TestValue';

        $this->parser->setSymbol('test', $value);

        $this->assertSame(
            $value,
            $this->parser->getSymbol('test')
        );

        $result = $this->parser->getSymbol();

        $this->assertArrayHasKey(
            'test',
            $result
        );

        $this->assertSame(
            $value,
            $result['test']
        );
    }

    public function testSetRelativeImagePrefixChaining()
    {
        $this->expectError();

        $symbol = $this->parser
            ->setRelativeImagePrefix('abc')
            ->setSymbol('test', 'TestValue')
            ->getSymbol('test');

        $this->assertEquals('TestValue', $symbol);
    }

    public function testSetGetDimensionlessImage()
    {
        $this->assertFalse(
            $this->parser->getDimensionlessImages()
        );

        $this->parser->setDimensionlessImages(true);

        $this->assertTrue(
            $this->parser->getDimensionlessImages()
        );
    }

    public function testEncode()
    {
        $result = $this->parser->textileEncode('& &amp; &#124; &#x0022 &#x0022;');

        $this->assertSame(
            '&amp; &amp; &#124; &amp;#x0022 &#x0022;',
            $result
        );
    }

    public function testDeprecatedEncodingArgument()
    {
        $this->expectDeprecation();

        $this->assertSame(
            'content',
            @$this->parser->textileThis('content', false, true)
        );

        $this->assertSame(
            'content',
            $this->parser->textileEncode('content')
        );

        $this->parser->textileThis('content', false, true);
    }

    public function testDeprecatedTextileCommon()
    {
        $this->expectDeprecation();

        $parser = new DeprecatedTextileCommon();

        $this->assertSame(
            ' content',
            @$parser->testTextileCommon(' content', false)
        );

        $this->assertSame(
            ' content',
            @$parser->testTextileCommon(' content', true)
        );

        $parser->testTextileCommon('content', false);
    }

    public function testDeprecatedPrepare()
    {
        $this->expectDeprecation();

        $parser = new DeprecatedPrepare();

        $this->assertSame(
            ' content',
            @$parser->parse(' content')
        );

        $parser->parse('content');
    }

    public function testDeprecatedTextileRestricted()
    {
        $this->expectDeprecation();

        $this->assertSame(
            ' content',
            @$this->parser->textileRestricted(' content')
        );

        $this->parser->textileRestricted('content');
    }

    public function testDeprecatedTextileThis()
    {
        $this->expectDeprecation();

        $this->assertSame(
            ' content',
            @$this->parser->textileThis(' content')
        );

        $this->parser->textileThis('content');
    }

    public function testDeprecatedSetRelativeImagePrefix()
    {
        $this->expectDeprecation();

        @$this->parser->setRelativeImagePrefix('/1/');

        $this->assertSame(
            ' <img alt="" src="/1/2.jpg" /> <a href="/1/2">1</a>',
            $this->parser->parse(' !2.jpg! "1":2')
        );

        $this->parser->setRelativeImagePrefix('/1/');
    }

    public function testInvalidDocumentType()
    {
        $this->expectException('\InvalidArgumentException');

        new Parser('InvalidDocumentType');
    }

    public function testInstanceSharingAndFootnoteIndex()
    {
        $previous = array('', '<p><strong>strong</strong></p>');

        for ($i = 1; $i <= 100; $i++) {
            $content = "Note[1]\n\nfn1. Footnote";
            $parsed[0] = $this->parser->parse($content);
            $parsed[1] = $this->parser->parse('*strong*');
            $this->assertNotSame($parsed[0], $previous[0]);
            $this->assertSame($previous[1], $parsed[1]);
            $previous[0] = $parsed[0];
            $previous[1] = $parsed[1];
        }
    }

    public function testLineSpaceEscaping()
    {
        $this->assertSame(
            ' <strong>line</strong>',
            $this->parser->parse(' *line*')
        );
    }

    public function testDocumentRoot()
    {
        $this->parser->setDocumentRootDirectory(__DIR__);

        $this->assertSame(
            __DIR__,
            rtrim($this->parser->getDocumentRootDirectory(), '\\/')
        );
    }

    public function testDisallowImages()
    {
        $this->parser->setImages(false);

        $this->assertFalse(
            $this->parser->isImageTagEnabled()
        );

        $this->parser->setImages(true);

        $this->assertTrue(
            $this->parser->isImageTagEnabled()
        );
    }

    public function testLinkRelationShip()
    {
        $this->parser->setLinkRelationShip('test');

        $this->assertSame(
            'test',
            $this->parser->getLinkRelationShip()
        );
    }

    public function testEnableRestrictedMode()
    {
        $this->parser->setRestricted(true);

        $this->assertTrue(
            $this->parser->isRestrictedModeEnabled()
        );

        $this->parser->setRestricted(false);

        $this->assertFalse(
            $this->parser->isRestrictedModeEnabled()
        );
    }

    public function testImagePrefix()
    {
        $this->parser->setLinkPrefix('test');

        $this->assertSame(
            'test',
            $this->parser->getLinkPrefix()
        );
    }

    public function testLinkPrefix()
    {
        $this->parser->setImagePrefix('test');

        $this->assertSame(
            'test',
            $this->parser->getImagePrefix()
        );
    }

    public function testAlignClasses()
    {
        $this->assertFalse(
            $this->parser->isAlignClassesEnabled()
        );

        $this->parser->setDocumentType(Parser::DOCTYPE_HTML5);

        $this->assertTrue(
            $this->parser->isAlignClassesEnabled()
        );

        $this->parser->setAlignClasses(false);

        $this->assertFalse(
            $this->parser->isAlignClassesEnabled()
        );

        $this->parser->setDocumentType(Parser::DOCTYPE_XHTML);

        $this->assertFalse(
            $this->parser->isAlignClassesEnabled()
        );

        $this->parser->setAlignClasses(true);

        $this->assertTrue(
            $this->parser->isAlignClassesEnabled()
        );

        $this->parser->setAlignClasses(false);

        $this->assertFalse(
            $this->parser->isAlignClassesEnabled()
        );
    }
}
