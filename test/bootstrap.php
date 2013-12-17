<?php

namespace Netcarver\Textile\Test;

error_reporting(E_ALL);

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    throw new \Exception($errstr . ' in ' . $errfile . ' on line ' . $errline);
});

include dirname(__DIR__) . '/vendor/autoload.php';
$loader = new \Composer\Autoload\ClassLoader();
$loader->add('Netcarver\\Textile\\Test\\', __DIR__);
$loader->register();
