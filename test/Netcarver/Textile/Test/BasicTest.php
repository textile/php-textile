<?php

namespace Netcarver\Textile\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use Netcarver\Textile\Parser as Textile;
use Netcarver\Textile\Tag;

class BasicTest extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function testAdd($file, $name, $test)
    {
        if (isset($test['class'])) {
            $class = $test['class'];
        } else {
            $class = '\Netcarver\Textile\Parser';
        }

        $textile = new $class;

        if (isset($test['doctype'])) {
            $textile->setDocumentType($test['doctype']);
        }

        if (isset($test['setup'])) {
            foreach ($test['setup'] as $setup) {
                foreach ($setup as $method => $value) {
                    $textile = $textile->$method($value);
                }
            }
        }

        if (isset($test['method'])) {
            $method = trim($test['method']);
        } else {
            $method = 'parse';
        }

        $args = array();

        if (isset($test['arguments'])) {
            foreach ($test['arguments'] as $argument) {
                foreach ($argument as $value) {
                    $args[] = $value;
                }
            }
        }

        foreach (array('expect', 'input') as $field) {
            $test[$field] = strtr($test[$field], array(
                '\x20' => ' ',
            ));
        }

        $expect = rtrim($test['expect']);
        array_unshift($args, $test['input']);
        $input = rtrim(call_user_func_array(array($textile, $method), $args));

        foreach (array('expect', 'input') as $variable) {
            $$variable = preg_replace(
                array(
                    '/ id="(fn|note)[a-z0-9\-]*"/',
                    '/ href="#(fn|note)[a-z0-9\-]*"/',
                ),
                '',
                $$variable
            );
        }

        $this->assertEquals($expect, $input, $name . ' in ' . $file);
        $public = implode(', ', array_keys(get_object_vars($textile)));
        $this->assertEquals('', $public, 'Leaking public class properties.');
    }

    public function testGetVersion()
    {
        $textile = new Textile();

        $this->assertIsString(
            $textile->getVersion()
        );
    }

    public function testInvalidSymbol()
    {
        $this->expectException('\InvalidArgumentException');
        $textile = new Textile();
        $textile->getSymbol('invalidSymbolName');
    }

    public function testSetGetSymbol()
    {
        $textile = new Textile();
        $this->assertEquals('TestValue', $textile->setSymbol('test', 'TestValue')->getSymbol('test'));
        $this->assertArrayHasKey('test', $textile->getSymbol());
    }

    public function testSetRelativeImagePrefixChaining()
    {
        $this->expectError();
        $textile = new Textile();
        $symbol = $textile->setRelativeImagePrefix('abc')->setSymbol('test', 'TestValue')->getSymbol('test');
        $this->assertEquals('TestValue', $symbol);
    }

    public function testSetGetDimensionlessImage()
    {
        $textile = new Textile();
        $this->assertFalse($textile->getDimensionlessImages());
        $this->assertTrue($textile->setDimensionlessImages(true)->getDimensionlessImages());
    }

    public function testEncode()
    {
        $textile = new Textile();
        $encoded = $textile->textileEncode('& &amp; &#124; &#x0022 &#x0022;');
        $this->assertEquals('&amp; &amp; &#124; &amp;#x0022 &#x0022;', $encoded);
    }

    public function provider()
    {
        chdir(dirname(dirname(dirname(__DIR__))));
        $out = array();

        if ($files = glob('*/*.yaml')) {
            foreach ($files as $file) {
                $yaml = Yaml::parseFile($file);

                foreach ($yaml as $name => $test) {
                    if (!is_array($test) || !isset($test['input']) || !isset($test['expect'])) {
                        continue;
                    }

                    if (isset($test['assert']) && $test['assert'] === 'skip') {
                        continue;
                    }

                    $out[] = array($file, $name, $test);
                }
            }
        }

        return $out;
    }

    public function testTagAttributesGenerator()
    {
        $attributes = new Tag(null, array('name' => 'value'));
        $this->assertEquals(' name="value"', (string) $attributes);
    }

    public function testDeprecatedEncodingArgument()
    {
        $this->expectDeprecation();
        $parser = new Textile();
        $this->assertEquals('content', @$parser->textileThis('content', false, true));
        $this->assertEquals('content', $parser->textileEncode('content'));
        $parser->textileThis('content', false, true);
    }

    public function testDeprecatedTextileCommon()
    {
        $this->expectDeprecation();
        $parser = new Parser\DeprecatedTextileCommon();
        $this->assertEquals(' content', @$parser->testTextileCommon(' content', false));
        $this->assertEquals(' content', @$parser->testTextileCommon(' content', true));
        $parser->testTextileCommon('content', false);
    }

    public function testDeprecatedPrepare()
    {
        $this->expectDeprecation();
        $parser = new Parser\DeprecatedPrepare();
        $this->assertEquals(' content', @$parser->parse(' content'));
        $parser->parse('content');
    }

    public function testDeprecatedTextileRestricted()
    {
        $this->expectDeprecation();
        $parser = new Textile();
        $this->assertEquals(' content', @$parser->textileRestricted(' content'));
        $parser->textileRestricted('content');
    }

    public function testDeprecatedTextileThis()
    {
        $this->expectDeprecation();
        $parser = new Textile();
        $this->assertEquals(' content', @$parser->textileThis(' content'));
        $parser->textileThis('content');
    }

    public function testDeprecatedSetRelativeImagePrefix()
    {
        $this->expectDeprecation();
        $parser = new Textile();
        @$parser->setRelativeImagePrefix('/1/');
        $this->assertEquals(
            ' <img alt="" src="/1/2.jpg" /> <a href="/1/2">1</a>',
            $parser->parse(' !2.jpg! "1":2')
        );
        $parser->setRelativeImagePrefix('/1/');
    }

    public function testInvalidDocumentType()
    {
        $this->expectException('\InvalidArgumentException');
        new Textile('InvalidDocumentType');
    }

    public function testInstanceSharingAndFootnoteIndex()
    {
        $parser = new Textile();
        $previous = array('', '<p><strong>strong</strong></p>');

        for ($i = 1; $i <= 100; $i++) {
            $content = "Note[1]\n\nfn1. Footnote";
            $parsed[0] = $parser->parse($content);
            $parsed[1] = $parser->parse('*strong*');
            $this->assertTrue($parsed[0] !== $previous[0]);
            $this->assertEquals($previous[1], $parsed[1]);
            $previous[0] = $parsed[0];
            $previous[1] = $parsed[1];
        }
    }

    public function testLineSpaceEscaping()
    {
        $parser = new Textile();
        $this->assertEquals(' <strong>line</strong>', $parser->parse(' *line*'));
    }

    public function testDocumentRoot()
    {
        $parser = new Textile();
        $parser->setDocumentRootDirectory(__DIR__);
        $this->assertEquals(__DIR__, rtrim($parser->getDocumentRootDirectory(), '\\/'));
    }

    public function testDisallowImages()
    {
        $parser = new Textile();
        $this->assertFalse($parser->setImages(false)->isImageTagEnabled());
        $this->assertTrue($parser->setImages(true)->isImageTagEnabled());
    }

    public function testLinkRelationShip()
    {
        $parser = new Textile();
        $this->assertEquals('test', $parser->setLinkRelationShip('test')->getLinkRelationShip());
    }

    public function testEnableRestrictedMode()
    {
        $parser = new Textile();
        $this->assertTrue($parser->setRestricted(true)->isRestrictedModeEnabled());
        $this->assertFalse($parser->setRestricted(false)->isRestrictedModeEnabled());
    }

    public function testImagePrefix()
    {
        $parser = new Textile();
        $this->assertEquals('test', $parser->setLinkPrefix('test')->getLinkPrefix());
    }

    public function testLinkPrefix()
    {
        $parser = new Textile();
        $this->assertEquals('test', $parser->setImagePrefix('test')->getImagePrefix());
    }
}
