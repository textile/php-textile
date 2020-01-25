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

namespace Netcarver\Textile;

use Netcarver\Textile\Api\ConfigInterface;

/**
 * Textile parser configuration.
 */
final class Config implements ConfigInterface
{
    /**
     * Whether raw blocks are enabled.
     *
     * @var bool
     */
    private $rawBlocksEnabled = false;

    /**
     * Whether block tags are enabled.
     *
     * @var bool
     */
    private $blockTagsEnabled = true;

    /**
     * Whether lines are wrapped.
     *
     * @var bool
     */
    private $lineWrapEnabled = true;

    /**
     * Link relationship.
     *
     * @var string
     */
    private $linkRelationShip;

    /**
     * Restricted mode.
     *
     * @var bool
     */
    private $restricted = false;

    /**
     * Whether image tag is enabled.
     *
     * @var bool
     */
    private $isImageTagEnabled = true;

    /**
     * Lite mode.
     *
     * @var bool
     */
    private $lite = false;

    /**
     * Relative link prefix.
     *
     * @var string
     */
    private $linkPrefix = '';

    /**
     * Prefix applied to relative images.
     *
     * @var string
     */
    private $imagePrefix = '';

    /**
     * Server document root.
     *
     * @var string
     */
    private $documentRoot;

    /**
     * Target document type.
     *
     * @var string
     */
    private $documentType;

    /**
     * Substitution symbols.
     *
     * Basic symbols used in textile glyph replacements. To override these, call
     * setSymbol method before calling Parser::parse().
     *
     * @var string[]|null[]|false[]
     */
    private $symbols = [
        'quote_single_open'  => '&#8216;',
        'quote_single_close' => '&#8217;',
        'quote_double_open'  => '&#8220;',
        'quote_double_close' => '&#8221;',
        'apostrophe' => '&#8217;',
        'prime' => '&#8242;',
        'prime_double' => '&#8243;',
        'ellipsis' => '&#8230;',
        'emdash' => '&#8212;',
        'endash' => '&#8211;',
        'dimension' => '&#215;',
        'trademark' => '&#8482;',
        'registered' => '&#174;',
        'copyright' => '&#169;',
        'half' => '&#189;',
        'quarter' => '&#188;',
        'threequarters' => '&#190;',
        'degrees' => '&#176;',
        'plusminus' => '&#177;',
        'fn_ref_pattern' => '<sup{atts}>{marker}</sup>',
        'fn_foot_pattern' => '<sup{atts}>{marker}</sup>',
        'nl_ref_pattern' => '<sup{atts}>{marker}</sup>',
        'caps' => '<span class="caps">{content}</span>',
        'acronym' => null,
    ];

    /**
     * Whether images are rendered with dimensions.
     *
     * @var bool
     */
    private $dimensionlessImages = false;

    /**
     * {@inheritdoc}
     */
    public function setDocumentType(string $name): ConfigInterface
    {
        $this->documentType = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDocumentType(): string
    {
        return (string) $this->documentType;
    }

    /**
     * {@inheritdoc}
     */
    public function setDocumentRootDirectory(string $path): ConfigInterface
    {
        $this->documentRoot = \rtrim($path, '\\/') . \DIRECTORY_SEPARATOR;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDocumentRootDirectory(): string
    {
        return (string) $this->documentRoot;
    }

    /**
     * {@inheritdoc}
     */
    public function setLite(bool $lite): ConfigInterface
    {
        $this->lite = $lite;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isLiteModeEnabled(): bool
    {
        return (bool) $this->lite;
    }

    /**
     * {@inheritdoc}
     */
    public function setImages(bool $enabled): ConfigInterface
    {
        $this->isImageTagEnabled = $enabled;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isImageTagEnabled(): bool
    {
        return $this->isImageTagEnabled;
    }

    /**
     * {@inheritdoc}
     */
    public function setLinkRelationShip($relationship): ConfigInterface
    {
        $this->linkRelationShip = (string) \implode(' ', (array) $relationship);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLinkRelationShip(): string
    {
        return (string) $this->linkRelationShip;
    }

    /**
     * {@inheritdoc}
     */
    public function setRestricted(bool $enabled): ConfigInterface
    {
        $this->restricted = $enabled;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isRestrictedModeEnabled(): bool
    {
        return (bool) $this->restricted;
    }

    /**
     * {@inheritdoc}
     */
    public function setRawBlocks(bool $enabled): ConfigInterface
    {
        $this->rawBlocksEnabled = $enabled;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isRawBlocksEnabled(): bool
    {
        return (bool) $this->rawBlocksEnabled;
    }

    /**
     * {@inheritdoc}
     */
    public function setBlockTags(bool $enabled): ConfigInterface
    {
        $this->blockTagsEnabled = $enabled;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isBlockTagEnabled(): bool
    {
        return (bool) $this->blockTagsEnabled;
    }

    /**
     * {@inheritdoc}
     */
    public function setLineWrap(bool $enabled): ConfigInterface
    {
        $this->lineWrapEnabled = (bool) $enabled;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isLineWrapEnabled(): bool
    {
        return (bool) $this->lineWrapEnabled;
    }

    /**
     * {@inheritdoc}
     */
    public function setSymbol(string $name, $value): ConfigInterface
    {
        if ($value !== false) {
            $value = (string) $value;
        }

        $this->symbols[$name] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSymbol(?string $name = null)
    {
        if ($name !== null) {
            if (isset($this->symbols[$name])) {
                return $this->symbols[$name];
            }

            throw new \InvalidArgumentException('The specified name does not match any symbols.');
        }

        return $this->symbols;
    }

    /**
     * {@inheritdoc}
     */
    public function setImagePrefix(string $prefix): ConfigInterface
    {
        $this->imagePrefix = $prefix;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getImagePrefix(): string
    {
        return (string) $this->imagePrefix;
    }

    /**
     * {@inheritdoc}
     */
    public function setLinkPrefix(string $prefix): ConfigInterface
    {
        $this->linkPrefix = $prefix;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLinkPrefix(): string
    {
        return (string) $this->linkPrefix;
    }

    /**
     * {@inheritdoc}
     */
    public function setDimensionlessImages(bool $dimensionless = true): ConfigInterface
    {
        $this->dimensionlessImages = $dimensionless;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDimensionlessImages(): bool
    {
        return (bool) $this->dimensionlessImages;
    }
}
