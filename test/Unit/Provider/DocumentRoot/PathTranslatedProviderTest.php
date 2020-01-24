<?php

declare(strict_types=1);

namespace Netcarver\Textile\Test\Unit\Provider\DocumentRoot;

use Netcarver\Textile\Provider\DocumentRoot\PathTranslatedProvider;
use PHPUnit\Framework\TestCase;

final class PathTranslatedProviderTest extends TestCase
{
    public function testDocumentRootAlwaysProvided(): void
    {
        $documentRootProvider = new PathTranslatedProvider();

        $this->assertIsString($documentRootProvider->getPath());

        $this->assertIsBool($documentRootProvider->isAvailable());
    }
}
