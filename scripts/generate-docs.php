<?php

require dirname(__DIR__) . '/vendor/autoload.php';

new \Netcarver\Textile\Website\Phpdoc\Generate(
    './tmp/phpdoc/structure.xml',
    './source/docs/api'
);
