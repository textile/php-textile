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

namespace Netcarver\Textile\Api\Document;

/**
 * Document block.
 */
interface BlockInterface
{
    /**
     * Gets content.
     *
     * @return string
     */
    public function getContent(): string;

    /**
     * Sets content.
     *
     * @param string $content
     *
     * @return $this
     */
    public function setContent(string $content): self;

    /**
     * Whether the block is eaten and not rendered.
     *
     * @return bool
     */
    public function isEaten(): bool;

    /**
     * Sets whether the block is eaten and not rendered.
     *
     * @param bool $status
     *
     * @return $this
     */
    public function setEaten(bool $status): self;

    /**
     * Gets outer opening.
     *
     * @return string
     */
    public function getOuterOpen(): string;

    /**
     * Sets outer opening.
     *
     * @param string $content
     *
     * @return $this
     */
    public function setOuterOpen(string $content): self;

    /**
     * Gets inner opening.
     *
     * @return string
     */
    public function getInnerOpen(): string;

    /**
     * Sets inner opening.
     *
     * @param string $content
     *
     * @return $this
     */
    public function setInnerOpen(string $content): self;

    /**
     * Gets inner closing.
     *
     * @return string
     */
    public function getInnerClose(): string;

    /**
     * Sets inner close.
     *
     * @param string $content
     *
     * @return $this
     */
    public function setInnerClose(string $content): self;

    /**
     * Gets outer closing.
     *
     * @return string
     */
    public function getOuterClose(): string;

    /**
     * Sets outer closing.
     *
     * @param string $content
     *
     * @return $this
     */
    public function setOuterClose(string $content): self;
}
