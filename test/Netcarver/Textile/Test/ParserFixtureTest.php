<?php

/**
 * Textile - A Humane Web Text Generator.
 *
 * @link https://github.com/textile/php-textile
 */

namespace Netcarver\Textile\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

class ParserFixtureTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testFixture($test)
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

        $this->assertSame($expect, $input);

        $public = implode(', ', array_keys(get_object_vars($textile)));

        $this->assertEmpty($public, 'Leaking public class properties.');
    }

    public function dataProvider()
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

                    $out[$file . ':' . $name] = array(
                        'test' => $test,
                    );
                }
            }
        }

        return $out;
    }
}
