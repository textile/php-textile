<?php

declare(strict_types=1);

namespace Netcarver\Textile\Test\Unit\Provider\DocumentRoot;

use Netcarver\Textile\Provider\DocumentRoot\ServerDocumentRootProvider;
use PHPUnit\Framework\TestCase;

final class ServerDocumentRootProviderTest extends TestCase
{
    public function testDocumentRootAlwaysProvided(): void
    {
        $documentRootProvider = new ServerDocumentRootProvider();

        $this->assertIsString($documentRootProvider->getPath());

        $this->assertIsBool($documentRootProvider->isAvailable());
    }
}
