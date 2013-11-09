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

    /**
     * Formats a path.
     *
     * @param SimpleXMLElement $xml
     */

    protected function formatPath($xml)
    {
        $path = str_replace(array('\\', '::'), '/', (string) $xml->full_name);
        return $this->encodeLink($path);
    }

    /**
     * Encodes a link.
     */

    protected function encodeLink($string)
    {
        return preg_replace('/[^a-z0-9\-\/_]/i', '', strtolower($string));
    }

    /**
     * Create a path structure.
     *
     * @param SimpleXMLElement $xml
     */

    protected function createDirectoryTree($xml)
    {
        $mkdir = $this->dir;

        if (!file_exists($mkdir)) {
            mkdir($mkdir);
        }

        foreach (explode('/', $this->formatPath($xml)) as $directory) {
            $mkdir .= '/' . $directory;

            if (!file_exists($mkdir)) {
                mkdir($mkdir);
            }
        }

        return true;
    }

    public function getClasses($xml)
    {
        $header = implode("\n", array(
            '---',
            'layout: default',
            'title: Docs',
            'name: docs',
            '---',
        ));

        foreach ($xml->xpath('file/class|file/interface') as $class) {

            $classpage = array();
            $this->createDirectoryTree($class);
            $contents = array();

            foreach ($class->xpath('method') as $method) {
                $methodpage = array();
                $methodpage[] = $header;
                $methodpage[] = 'h1. ' . $class->name . '::' . $method->name;
                $signature = $arguments = array();

                foreach ($method->argument as $argument) {
                    $arguments[(string) $argument->name] = array(
                        'name'        => (string) $argument->name,
                        'type'        => (string) $argument->type,
                        'default'     => (string) $argument->default,
                        'description' => '',
                    );
                }

                foreach ($method->xpath('docblock/tag[@name="param"]') as $param) {
                    $arguments[(string) $param['variable']]['type'] = (string) $param['type'];
                    $arguments[(string) $param['variable']]['description'] = (string) $param['description'];
                }

                foreach ($arguments as $argument) {
                    if ($argument['default']) {
                        $signature[] = '[' . $argument['type'] . ' ' . $argument['name'] . ' = ' . $argument['default']. ']';
                    } else {
                        $signature[] = $argument['type'] . ' ' . $argument['name'];
                    }
                }

                $return = $method->xpath('docblock/tag[@name="return"]');

                if (count($return)) {
                    $return = (string) $return[0]['type'];
                } else {
                    $return = 'mixed';
                }

                $methodpage[] = 'bc(language-php). ('.$return.') '.$class->full_name.'::'.$method->name.'('.implode(', ', $signature).')';
                $methodpage[] = (string) $method->docblock->description;

                if ($description = $this->formatLongDescription($method)) {
                    $methodpage[] = $description;
                }

                if ($arguments) {
                    $params = array();
                    $methodpage[] = 'h2. Parameters';

                    foreach ($arguments as $argument) {
                        if ($argument['default']) {
                            $params[] = '; ' . $argument['name'] . ' = @' . $argument['default'] . '@';
                        }
                        else {
                            $params[] = '; ' . $argument['name'];
                        }

                        $params[] = ': ' . $argument['type'] . ' ' . $argument['description'];
                    }

                    $methodpage[] = implode("\n", $params);
                }

                $contents[] = '"' . (string) $method->name . '":' . $this->encodeLink((string) $method->name);

                file_put_contents(
                    $this->dir . '/' . $this->formatPath($method) . '.textile',
                    implode("\n\n", $methodpage)."\n"
                );
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

            file_put_contents(
                $this->dir . '/' . $this->formatPath($class) . '.textile',
                implode("\n\n", $classpage)."\n"
            );
        }
    }
}

new Generate('./tmp/phpdoc/structure.xml', './source/docs/classes');
