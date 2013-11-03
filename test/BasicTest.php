<?php

use Symfony\Component\Yaml\Yaml;

class BasicTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provider
     */

    public function testAdd($name, $test)
    {
        if (isset($test['doctype'])) {
            $textile = new Textile($test['doctype']);
        } else {
            $textile = new Textile();
        }

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
            $$variable = preg_replace(
                array(
                    '/ id="(fn|note)[a-z0-9\-]*"/',
                    '/ href="#(fn|note)[a-z0-9\-]*"/',
                ),
                '',
                $$variable
            );
        }

        $this->assertEquals($expect, $input, 'In section: '.$name);
        $this->assertEquals('', implode(', ', array_keys(get_object_vars($textile))), 'Leaking public class properties.');
    }

    public function testGetVersion()
    {
        $textile = new Textile();
        $this->assertRegExp('/^[0-9]+\.[0-9]+\.[0-9]+(:?-[A-Za-z0-9.]+)?(?:\+[A-Za-z0-9.]+)?$/', $textile->getVersion());
    }

    /**
     * @expectedException \InvalidArgumentException
     */

    public function testInvalidSymbol()
    {
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
        $textile = new Textile();
        $this->assertEquals('TestValue', $textile->setRelativeImagePrefix('abc')->setSymbol('test', 'TestValue')->getSymbol('test'));
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
        $this->assertEquals('&amp; &amp; &#124; &amp;#x0022 &#x0022;', $textile->textileEncode('& &amp; &#124; &#x0022 &#x0022;'));
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
