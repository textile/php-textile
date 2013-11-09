<?php

namespace Netcarver\Phpdoc;
use SimpleXMLElement;

class Generate
{
    protected $dir;

    public function __construct($filename, $output)
    {
        $xml = new SimpleXMLElement($filename, 0, true);
        $this->dir = $output;
        $this->getClasses($xml);
    }

    public function getClasses($xml)
    {
        mkdir($this->dir . '/classes');

        $header = implode("\n", array(
            '---',
            'layout: default',
            'title: Docs',
            'name: docs',
            '---',
        ));

        foreach ($xml->xpath('file/class|file/interface') as $class) {

            $classpage = array();
            $mkdir = $this->dir . '/classes';

            foreach (explode('\\', (string) $class->full_name) as $directory) {
                $mkdir .= '/' . $directory;
                mkdir($mkdir);
            }

            $contents = array();

            foreach ($class->xpath('method') as $method) {
                $methodpage = array();
                $methodpage[] = $header;
                $methodpage[] = 'h1. ' . $method->full_name;

                foreach ($method->argument as $argument) {
                    
                }

                $return = $method->xpath('docblock/tag[@name="return"]');

                if (count($return)) {
                    $return = (string) $return[0]['type'];
                } else {
                    $return = 'mixed';
                }

                $methodpage[] = 'bc. '.$return.' '.$method->full_name;
                $methodpage[] = (string) $method->docblock->description;
                $description = $method->docblock->{'long-description'};

                if (count($description)) {
                    $methodpage[] = preg_replace('/(\S)\n(?!\n)/', '$1 ', (string) $description);
                }

                $example = $method->xpath('docblock/tag[@name="example"]');

                if (count($example)) {
                    $methodpage[] = 'bc. ' . $example[0]['description'];
                }

                $contents[] = '"' . (string) $method->name . '":' . (string) $method->name;

                file_put_contents($mkdir . '/' . (string) $method->name . '.textile', implode("\n\n", $methodpage)."\n");
            }

            $classpage[] = $header;
            $classpage[] = 'h1. ' . $class->full_name;
            $classpage[] = (string) $class->docblock->description;

            if ($class->docblock->{'long-description'}) {
                $classpage[] = preg_replace('/(\S)\n(?!\n)/', '$1 ', (string) $class->docblock->{'long-description'});
            }

            if ($contents) {
                $classpage[] = '* '.implode("\n* ", $contents);
            }

            file_put_contents($this->dir . '/classes/'.str_replace('\\', '/', strval($class->full_name)).'.textile', implode("\n\n", $classpage)."\n");
        }
    }
}

new Generate('./tmp/phpdoc/structure.xml', './source/docs');
