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

    /**
     * Formats long description.
     *
     * @param SimpleXMLElement $xml
     */

    protected function formatLongDescription($xml)
    {
        $description = $xml->docblock->{'long-description'};

        if (count($description)) {
            $paragraphs = explode("\n\n", (string) $description);

            foreach ($paragraphs as &$paragraph) {
                if (strpos($paragraph, '<code>') === 0) {
                    $paragraph = 'bc(language-php). ' . trim(substr($paragraph, 6, -7));
                } else {
                    $paragraph = str_replace("\n", ' ', trim($paragraph));
                }
            }

            return implode("\n\n", $paragraphs);
        }

        return '';
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

                if ($description = $this->formatLongDescription($method)) {
                    $methodpage[] = $description;
                }

                $contents[] = '"' . (string) $method->name . '":' . (string) $method->name;

                file_put_contents($mkdir . '/' . (string) $method->name . '.textile', implode("\n\n", $methodpage)."\n");
            }

            $classpage[] = $header;
            $classpage[] = 'h1. ' . $class->full_name;
            $classpage[] = (string) $class->docblock->description;

            if ($description = $this->formatLongDescription($class)) {
                $classpage[] = $description;
            }

            if ($contents) {
                $classpage[] = '* '.implode("\n* ", $contents);
            }

            file_put_contents($this->dir . '/classes/'.str_replace('\\', '/', strval($class->full_name)).'.textile', implode("\n\n", $classpage)."\n");
        }
    }
}

new Generate('./tmp/phpdoc/structure.xml', './source/docs');
