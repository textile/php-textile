<?php

namespace Netcarver\Textile\Test;

error_reporting(E_ALL);

/**
 * Initialises tests.
 */

class Bootstrap
{
    /**
     * Constructor.
     */

    public function __construct()
    {
        set_error_handler(array($this, 'errorHandler'));
        include dirname(__DIR__) . '/vendor/autoload.php';
        $loader = new \Composer\Autoload\ClassLoader();
        $loader->add('Netcarver\\Textile\\Test\\', __DIR__);
        $loader->register();
    }

    /**
     * Error handler.
     *
     * @param int    $errno
     * @param string $errstr
     * @param string $errfile
     * @param int    $errline
     */

    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        throw new \Exception($errstr . ' in ' . $errfile . ' on line ' . $errline);
    }
}

new Bootstrap();
