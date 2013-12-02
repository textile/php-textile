<?php

use Symfony\Component\Yaml\Yaml;

class BasicTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provider
     */

    public function testAdd($name, $test)
    {
        $textile = new Textile();

        if (isset($test['setup'][0])) {
            foreach ($test['setup'][0] as $method => $value) {
                $textile->$method($value);
            }
        }

        if (isset($test['method'])) {
            $method = trim($test['method']);
        } else {
            $method = 'textileThis';
        }

        if (isset($test['arguments'][0])) {
            $args = array_values($test['arguments'][0]);
        } else {
            $args = array();
        }

        $expect = rtrim($test['expect']);
        array_unshift($args, $test['input']);
        $input = rtrim(call_user_func_array(array($textile, $method), $args));

        foreach (array('expect', 'input') as $variable) {
            $$variable = str_replace("\t", '', preg_replace(
                array(
                    '/ id="(fn|note)[a-z0-9\-]*"/',
                    '/ href="#(fn|note)[a-z0-9\-]*"/',
                ),
                '',
                $$variable
            ));
        }

        $this->assertEquals($expect, $input, 'In section: '.$name);
    }

    public function provider()
    {
        $out = array();
        chdir(__DIR__ . '/fixtures');

        if ($files = glob('*.yaml')) {
            foreach ($files as $file) {
                $yaml = Yaml::parse($file);

                foreach ($yaml as $name => $test) {
                    if (!isset($test['input']) || !isset($test['expect'])) {
                        continue;
                    }

                    if (isset($test['assert']) && $test['assert'] === 'skip') {
                        continue;
                    }

                    $out[] = array($name, $test);
                }
            }
        }

        return $out;
    }
}
