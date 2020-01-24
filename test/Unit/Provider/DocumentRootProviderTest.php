<?php

declare(strict_types=1);

namespace Netcarver\Textile\Test\Unit\Provider;

use Netcarver\Textile\Provider\DocumentRootProvider;
use PHPUnit\Framework\TestCase;

final class DocumentRootProviderTest extends TestCase
{
    public function testDocumentRootAlwaysProvided(): void
    {
        $documentRootProvider = new DocumentRootProvider();

        $this->assertNotEmpty($documentRootProvider->getPath());

        $this->assertTrue($documentRootProvider->isAvailable());
    }

    public function testNoProvidersAvailable(): void
    {
        $documentRootProvider = new DocumentRootProvider([]);

        $this->assertSame('', $documentRootProvider->getPath());

        $this->assertFalse($documentRootProvider->isAvailable());
    }
}
