<?php

require dirname(__DIR__) . '/vendor/autoload.php';

new \Netcarver\Textile\Website\Phpdoc\Generate(
    dirname(__DIR__) . '/build/phpdoc/structure.xml',
    dirname(__DIR__) . '/source/docs/api'
);
