<?php

namespace Netcarver\Textile\Test;

ini_set('memory_limit', '512M');

error_reporting(E_ALL);

include dirname(__DIR__) . '/vendor/autoload.php';
$loader = new \Composer\Autoload\ClassLoader();
$loader->add('Netcarver\\Textile\\Test\\', __DIR__);
$loader->register();
