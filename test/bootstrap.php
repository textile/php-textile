<?php

declare(strict_types=1);

\ini_set('memory_limit', '512M');
\error_reporting(\E_ALL);
require \dirname(__DIR__) . '/vendor/autoload.php';
(new \Netcarver\Textile\Test\Info())->print();
