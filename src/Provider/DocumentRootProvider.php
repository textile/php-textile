<?php

/**
 * Textile - A Humane Web Text Generator.
 *
 * @link https://github.com/textile/php-textile
 */

declare(strict_types=1);

/*
 * Copyright (c) 2019, PHP-Textile Team
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice,
 * this list of conditions and the following disclaimer.
 *
 * * Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation
 * and/or other materials provided with the distribution.
 *
 * * Neither the name Textile nor the names of its contributors may be used to
 * endorse or promote products derived from this software without specific
 * prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace Netcarver\Textile\Provider;

use Netcarver\Textile\Api\Provider\DocumentRootProviderInterface;
use Netcarver\Textile\Provider\DocumentRoot\CommandLineProvider;
use Netcarver\Textile\Provider\DocumentRoot\PathTranslatedProvider;
use Netcarver\Textile\Provider\DocumentRoot\ServerDocumentRootProvider;

/**
 * Document root provider.
 */
class DocumentRootProvider implements DocumentRootProviderInterface
{
    /**
     * Document root providers.
     *
     * @var DocumentRootProviderInterface[]
     */
    private $providers;

    /**
     * Document root path.
     *
     * @var string
     */
    private $path;

    /**
     * Constructor.
     *
     * @param DocumentRootProviderInterface[]|null $providers
     */
    public function __construct(
        ?array $providers = null
    ) {
        $this->providers = $providers ?? [
            new CommandLineProvider(),
            new ServerDocumentRootProvider(),
            new PathTranslatedProvider(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailable(): bool
    {
        return $this->getPath() !== '';
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        if ($this->path === null) {
            $this->path = $this->getProvidedPath() ?? '';
        }

        return $this->path;
    }

    /**
     * Gets a matching provided path.
     *
     * @return string|null
     */
    private function getProvidedPath(): ?string
    {
        foreach ($this->providers as $provider) {
            if ($provider->isAvailable()) {
                return $provider->getPath();
            }
        }

        return null;
    }
}
