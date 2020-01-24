<?php

declare(strict_types=1);

namespace Netcarver\Textile\Test\Unit\Provider\DocumentRoot;

use Netcarver\Textile\Provider\DocumentRoot\CommandLineProvider;
use PHPUnit\Framework\TestCase;

final class CommandLineProviderTest extends TestCase
{
    public function testDocumentRootAlwaysProvided(): void
    {
        $documentRootProvider = new CommandLineProvider();

        $this->assertIsString($documentRootProvider->getPath());

        $this->assertIsBool($documentRootProvider->isAvailable());
    }
}
