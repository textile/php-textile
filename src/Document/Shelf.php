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

namespace Netcarver\Textile\Document;

use Netcarver\Textile\Api\Document\ShelfInterface;
use Netcarver\Textile\Api\Provider\UniqueIdentifierProviderInterface;
use Netcarver\Textile\Provider\UniqueIdentifierProvider;

/**
 * Shelved content.
 */
class Shelf implements ShelfInterface
{
    /**
     * Unique identifier provider.
     *
     * @var UniqueIdentifierProviderInterface
     */
    private $uniqueIdentifierProvider;

    /**
     * Unique identifier.
     *
     * @var string
     */
    private $uniqueIdentifier;

    /**
     * Token to content mapping.
     *
     * @var string[]
     */
    private $shelf = [];

    /**
     * Reference index.
     *
     * @var int
     */
    private $index = 0;

    /**
     * Constructor.
     *
     * @param UniqueIdentifierProviderInterface|null $uniqueIdentifierProvider
     */
    public function __construct(
        ?UniqueIdentifierProviderInterface $uniqueIdentifierProvider = null
    ) {
        $this->uniqueIdentifierProvider = $uniqueIdentifierProvider ?? new UniqueIdentifierProvider();
    }

    /**
     * {@inheritdoc}
     */
    public function shelve(string $value): string
    {
        $token = $this->getToken();

        $this->shelf[$token] = $value;

        return $token;
    }

    /**
     * {@inheritdoc}
     */
    public function replace(string $content): string
    {
        if ($this->shelf) {
            $previous = null;
            $needles = \array_keys($this->shelf);

            while ($previous !== $content) {
                $previous = $content;
                $content = \str_replace($needles, $this->shelf, $content);
            }
        }

        return $content;
    }

    /**
     * Gets unique identifier token.
     *
     * @return string
     */
    private function getToken(): string
    {
        if ($this->uniqueIdentifier === null) {
            $this->uniqueIdentifier = $this->uniqueIdentifierProvider->getToken();
        }

        return 'textileRef:' . $this->uniqueIdentifier . ':' . ($this->index++) . ':shelve';
    }
}
