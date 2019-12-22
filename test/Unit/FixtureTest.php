<?php

declare(strict_types=1);

namespace Netcarver\Textile\Test\Unit;

use Netcarver\Textile\Parser;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

final class FixtureTest extends TestCase
{
    /**
     * Run fixture tests.
     *
     * @param string $file
     * @param string $name
     * @param mixed[] $test
     *
     * @dataProvider dataProvider
     */
    public function testFixtures(string $file, string $name, array $test): void
    {
        $class = $test['class'] ?? Parser::class;
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

        // phpcs:ignore
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

    /**
     * Fixture provider.
     *
     * @return array[]
     */
    public function dataProvider(): array
    {
        \chdir(\dirname(__DIR__));

        $out = [];

        $files = \glob('*/*.yaml');

        if ($files) {
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
}
