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

        $yaml = Yaml::parse('basic.yaml');

        foreach ($yaml as $name => $test) {
            if (!isset($test['input']) || !isset($test['expect'])) {
                continue;
            }

            if (isset($test['assert']) && $test['assert'] === 'skip') {
                continue;
            }

            $textile = new \Netcarver\Textile\Parser();

            if (isset($test['setup'][0]))
            {
                foreach ($test['setup'][0] as $method => $value)
                {
                    $textile->$method($value);
                }
            }

            $expect = rtrim($test['expect']);
            $input = $textile->textileThis($test['input']);

            foreach (array('expect', 'input') as $variable)
            {
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

        return $out;
    }
}
