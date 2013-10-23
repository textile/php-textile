<?php

error_reporting(E_ALL);

/*
include dirname(__DIR__) . '/src/Netcarver/Textile/Parser.php';
include dirname(__DIR__) . '/src/Netcarver/Textile/DataBag.php';
include dirname(__DIR__) . '/src/Netcarver/Textile/Tag.php';
*/

include dirname(__DIR__) . '/vendor/autoload.php';
$loader = new \Composer\Autoload\ClassLoader();
$loader->add('Netcarver\\Textile\\Test\\', __DIR__);
$loader->register();
