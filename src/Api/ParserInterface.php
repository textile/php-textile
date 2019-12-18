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

namespace Netcarver\Textile\Api;

/**
 * Textile parser.
 */
interface ParserInterface
{
    /**
     * Parses the given Textile input according to the previously set options.
     *
     * The parser's features can be changed by using the various public setter
     * methods this class has. The most basic use case is:
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * echo $parser->parse('h1. Hello World!');
     *
     * The above parses trusted input in full-feature mode, generating:
     *
     * bc. <h1>Hello World!</h1>
     *
     * Additionally the parser can be run in safe, restricted mode using the
     * Parser::setRestricted() method.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * echo $parser
     *     ->setRestricted(true)
     *     ->parse('h1. Hello World!');
     *
     * This enables restricted mode and allows safe parsing of untrusted input.
     * PHP-Textile will disable unsafe attributes, links and escapes any raw
     * HTML input. This option should be enabled when parsing untrusted user
     * input.
     *
     * If restricted mode is disabled, the parser allows users to mix raw HTML
     * and Textile.
     *
     * @param  string $text The Textile input to parse
     * @return string Parsed Textile input
     * @since  3.6.0
     * @api
     */
    public function parse(string $text): string;
}
