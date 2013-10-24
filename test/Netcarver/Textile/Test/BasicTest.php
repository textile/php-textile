<?php

namespace Netcarver\Textile\Test;
use Symfony\Component\Yaml\Yaml;

class BasicTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provider
     */

    public function testAdd($expect, $input, $name)
    {
        $this->assertEquals($expect, $input, 'In section: '.$name);
    }
 
    public function provider()
    {
        chdir(dirname(dirname(dirname(__DIR__))));
        $out = array();

        if ($files = glob('*/*.yaml'))
        {
            foreach ($files as $file)
            {
                $yaml = Yaml::parse($file);

                foreach ($yaml as $name => $test) {
                    if (!isset($test['input']) || !isset($test['expect'])) {
                        continue;
                    }

                    if (isset($test['assert']) && $test['assert'] === 'skip') {
                        continue;
                    }

                    if (isset($test['doctype'])) {
                        $textile = new \Netcarver\Textile\Parser($test['doctype']);
                    }
                    else
                    {
                        $textile = new \Netcarver\Textile\Parser();
                    }

                    if (isset($test['setup'][0])) {
                        foreach ($test['setup'][0] as $method => $value) {
                            $textile->$method($value);
                        }
                    }

                    if (isset($test['method'])) {
                        $method = trim($test['method']);
                    }
                    else {
                        $method = 'textileThis';
                    }

                    if (isset($test['arguments'][0])) {
                        $args = array_values($test['arguments'][0]);
                    }
                    else {
                        $args = array();
                    }

                    $expect = rtrim($test['expect']);
                    array_unshift($args, $test['input']);
                    $input = rtrim(call_user_func_array(array($textile, $method), $args));

                    foreach (array('expect', 'input') as $variable) {
                        $$variable = preg_replace(
                            array(
                                '/ id="(fn|note)[a-z0-9]*"/',
                                '/ href="#(fn|note)[a-z0-9]*"/',
                            ),
                            '',
                            $$variable
                        );
                    }

                    $out[] = array($expect, $input, $name);
                }
            }
        }

        return $out;
    }
}
