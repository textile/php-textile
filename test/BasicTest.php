<?php

declare(strict_types=1);

namespace Netcarver\Textile\Test;

use InvalidArgumentException;
use Netcarver\Textile\Parser as Textile;
use Netcarver\Textile\Tag;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

final class BasicTest extends TestCase
{
    /**
     * @param string $file
     * @param string $name
     * @param mixed[] $test
     * @dataProvider dataProvider
     */
    public function testFixtures(string $file, string $name, array $test): void
    {
        $class = $test['class'] ?? Textile::class;
        $textile = new $class();

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

        $args = [];

        foreach ($test['arguments'] ?? [] as $argument) {
            foreach ($argument as $value) {
                $args[] = $value;
            }
        }

        foreach (['expect', 'input'] as $field) {
            $test[$field] = \strtr($test[$field], [
                '\x20' => ' ',
            ]);
        }

        $method = isset($test['method']) ? \trim($test['method']) : 'parse';
        $expect = \rtrim($test['expect']);

        \array_unshift($args, $test['input']);

        /** @var callable $callback */
        $callback = [$textile, $method];

        $input = \rtrim(\call_user_func_array($callback, $args));

        foreach (['expect', 'input'] as $variable) {
            $$variable = \preg_replace(
                [
                    '/ id="(fn|note)[a-z0-9\-]*"/',
                    '/ href="#(fn|note)[a-z0-9\-]*"/',
                ],
                '',
                $$variable
            );
        }

        $this->assertEquals($expect, $input, $name . ' in ' . $file);
        $public = \implode(', ', \array_keys(\get_object_vars($textile)));
        $this->assertEquals('', $public, 'Leaking public class properties.');
    }

    public function testInvalidSymbol(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $textile = new Textile();
        $textile->getSymbol('invalidSymbolName');
    }

    public function testSetGetSymbol(): void
    {
        $textile = new Textile();
        $this->assertEquals('TestValue', $textile->setSymbol('test', 'TestValue')->getSymbol('test'));
        $this->assertArrayHasKey('test', (array) $textile->getSymbol());
    }

    public function testSetGetDimensionlessImage(): void
    {
        $textile = new Textile();
        $this->assertFalse($textile->getDimensionlessImages());
        $this->assertTrue($textile->setDimensionlessImages(true)->getDimensionlessImages());
    }

    public function testEncode(): void
    {
        $textile = new Textile();
        $encoded = $textile->textileEncode('& &amp; &#124; &#x0022 &#x0022;');
        $this->assertEquals('&amp; &amp; &#124; &amp;#x0022 &#x0022;', $encoded);
    }

    /**
     * @return array[]
     */
    public function dataProvider(): array
    {
        \chdir(__DIR__);
        $out = [];

        if ($files = \glob('*/*.yaml')) {
            foreach ($files as $file) {
                $yaml = Yaml::parseFile($file);

                foreach ($yaml as $name => $test) {
                    if (!\is_array($test) || !isset($test['input']) || !isset($test['expect'])) {
                        continue;
                    }

                    if (isset($test['assert']) && $test['assert'] === 'skip') {
                        continue;
                    }

                    $out[] = [$file, $name, $test];
                }
            }
        }

        return $out;
    }

    public function testTagAttributesGenerator(): void
    {
        $attributes = new Tag(null, ['name' => 'value']);
        $this->assertEquals(' name="value"', (string) $attributes);
    }

    public function testInvalidDocumentType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Textile('InvalidDocumentType');
    }

    public function testInstanceSharingAndFootnoteIndex(): void
    {
        $parser = new Textile();
        $previous = ['', '<p><strong>strong</strong></p>'];

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

    public function testLineSpaceEscaping(): void
    {
        $parser = new Textile();
        $this->assertEquals(' <strong>line</strong>', $parser->parse(' *line*'));
    }

    public function testDocumentRoot(): void
    {
        $parser = new Textile();
        $parser->setDocumentRootDirectory(__DIR__);
        $this->assertEquals(__DIR__, \rtrim($parser->getDocumentRootDirectory(), '\\/'));
    }

    public function testDisallowImages(): void
    {
        $parser = new Textile();
        $this->assertFalse($parser->setImages(false)->isImageTagEnabled());
        $this->assertTrue($parser->setImages(true)->isImageTagEnabled());
    }

    public function testLinkRelationShip(): void
    {
        $parser = new Textile();
        $this->assertEquals('test', $parser->setLinkRelationShip('test')->getLinkRelationShip());
    }

    public function testEnableRestrictedMode(): void
    {
        $parser = new Textile();
        $this->assertTrue($parser->setRestricted(true)->isRestrictedModeEnabled());
        $this->assertFalse($parser->setRestricted(false)->isRestrictedModeEnabled());
    }

    public function testImagePrefix(): void
    {
        $parser = new Textile();
        $this->assertEquals('test', $parser->setLinkPrefix('test')->getLinkPrefix());
    }

    public function testLinkPrefix(): void
    {
        $parser = new Textile();
        $this->assertEquals('test', $parser->setImagePrefix('test')->getImagePrefix());
    }
}
