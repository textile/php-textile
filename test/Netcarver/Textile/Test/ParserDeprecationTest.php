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

class ParserDeprecationTest extends TestCase
{
    /**
     * @var Parser
     */
    private $parser;

    protected function setUp(): void
    {
        $this->parser = new Parser();

        set_error_handler(static function ($errorNumber) {
            if (!($errorNumber & error_reporting())) {
                return false;
            }

            throw new \Exception('', E_USER_DEPRECATED);
        }, E_USER_DEPRECATED);
    }

    protected function tearDown(): void
    {
        restore_error_handler();
    }

    public function testSetRelativeImagePrefixChaining()
    {
        $this->expectExceptionCode(E_USER_DEPRECATED);

        $symbol = @$this->parser
            ->setRelativeImagePrefix('abc')
            ->setSymbol('test', 'TestValue')
            ->getSymbol('test');

        $this->assertEquals('TestValue', $symbol);

        $this->parser->setRelativeImagePrefix('abc');
    }

    public function testDeprecatedEncodingArgument()
    {
        $this->expectExceptionCode(E_USER_DEPRECATED);

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
        $this->expectExceptionCode(E_USER_DEPRECATED);

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
        $this->expectExceptionCode(E_USER_DEPRECATED);

        $parser = new DeprecatedPrepare();

        $this->assertSame(
            ' content',
            @$parser->parse(' content')
        );

        $parser->parse('content');
    }

    public function testDeprecatedTextileRestricted()
    {
        $this->expectExceptionCode(E_USER_DEPRECATED);

        $this->assertSame(
            ' content',
            @$this->parser->textileRestricted(' content')
        );

        $this->parser->textileRestricted('content');
    }

    public function testDeprecatedTextileThis()
    {
        $this->expectExceptionCode(E_USER_DEPRECATED);

        $this->assertSame(
            ' content',
            @$this->parser->textileThis(' content')
        );

        $this->parser->textileThis('content');
    }

    public function testDeprecatedSetRelativeImagePrefix()
    {
        $this->expectExceptionCode(E_USER_DEPRECATED);

        @$this->parser->setRelativeImagePrefix('/1/');

        $this->assertSame(
            ' <img alt="" src="/1/2.jpg" /> <a href="/1/2">1</a>',
            $this->parser->parse(' !2.jpg! "1":2')
        );

        $this->parser->setRelativeImagePrefix('/1/');
    }
}
