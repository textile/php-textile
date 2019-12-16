<?php

declare(strict_types=1);

/**
 * Textile - A Humane Web Text Generator.
 *
 * @link https://github.com/textile/php-textile
 */

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
 * Textile parser configuration.
 */
interface ConfigInterface
{
    /**
     * Sets the output document type.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * echo $parser
     *     ->setDocumentType('html5')
     *     ->parse('HTML(HyperText Markup Language)");
     *
     * @param  string $doctype Either 'xhtml' or 'html5'
     * @return self   This instance
     * @since  3.6.0
     * @see    Parser::getDocumentType()
     */
    public function setDocumentType(string $doctype): self;

    /**
     * Gets the current output document type.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * echo $parser->getDocumentType();
     *
     * @return string The document type
     * @since  3.6.0
     * @see    Parser::setDocumentType()
     */
    public function getDocumentType(): string;

    /**
     * Sets the document root directory path.
     *
     * This method sets the path that is used to resolve relative file paths
     * within local filesystem. This is used to fetch image dimensions, for
     * instance.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * $parser->setDocumentRootDirectory('/path/to/document/root/dir');
     *
     * If not set, document root defaults to the current working directory if
     * PHP-Textile is used via CLI. On server environment, DOCUMENT_ROOT or
     * PATH_TRANSLATED server variable is used based on which ever is available.
     *
     * @param  string $path The root path
     * @return self   This instance
     * @since  3.6.0
     * @see    Parser::getDocumentRootDirectory()
     */
    public function setDocumentRootDirectory(string $path): self;

    /**
     * Gets the current document root directory path.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * echo $parser->getDocumentRootDirectory();
     *
     * @return string Path to the document root directory
     * @since  3.6.0
     * @see    Parser::setDocumentRootDirectory()
     */
    public function getDocumentRootDirectory(): string;

    /**
     * Enables lite mode.
     *
     * If enabled, allowed tags are limited. Parser will prevent the use extra
     * Textile formatting, accepting only paragraphs and blockquotes as valid
     * block tags.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * $parser
     *     ->setLite(true)
     *     ->parse('h1. Headings are disabled too');
     *
     * Generates:
     *
     * bc. <p>h1. Headings are disabled too</p>
     *
     * This doesn't prevent unsafe input values. If you wish to parse untrusted
     * user-given Textile input, also enable the restricted parser mode with
     * Parser::setRestricted().
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * echo $parser
     *     ->setRestricted(true)
     *     ->setLite(true)
     *     ->parse('h1. Hello World!');
     *
     * @param  bool   $lite TRUE to enable
     * @return self   This instance
     * @since  3.6.0
     * @see    Parser::isLiteModeEnabled()
     * @see    Parser::setRestricted()
     */
    public function setLite(bool $lite): self;

    /**
     * Gets the lite mode status.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * if ($parser->isLiteModeEnabled() === true) {
     *     echo 'Lite mode is enabled.';
     * }
     *
     * @return bool TRUE if enabled, FALSE otherwise
     * @since  3.6.0
     * @see    Parser::setLite()
     */
    public function isLiteModeEnabled(): bool;

    /**
     * Disables and enables images.
     *
     * If disabled, image tags are not generated. This option is ideal for
     * minimalist output such as text-only comments.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * echo $parser
     *     ->setImages(true)
     *     ->parse('!image.png!');
     *
     * Generates:
     *
     * bc. <p>!image.png!</p>
     *
     * @param  bool   $enabled TRUE to enable, FALSE to disable
     * @return self   This instance
     * @since  3.6.0
     * @see    Parser::isImageTagEnabled()
     */
    public function setImages(bool $enabled): self;

    /**
     * Whether images are enabled.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * if ($parser->isImageTagEnabled() === true) {
     *     echo 'Images are enabled.';
     * }
     *
     * @return bool TRUE if enabled, FALSE otherwise
     * @since  3.6.0
     * @see    Parser::setImages()
     */
    public function isImageTagEnabled(): bool;

    /**
     * Sets link relationship status value.
     *
     * This method sets the HTML relationship tokens that are applied to links
     * generated by PHP-Textile.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * echo $parser
     *     ->setLinkRelationShip('nofollow')
     *     ->parse('"Link":http://example.com/');
     *
     * Generates:
     *
     * bc. <p><a href="http://example.com/" rel="nofollow">Link</a></p>
     *
     * @param  string|string[] $relationship The HTML rel attribute value
     * @return self         This instance
     * @since  3.6.0
     * @see    Parser::getLinkRelationShip()
     */
    public function setLinkRelationShip($relationship): self;

    /**
     * Gets the link relationship status value.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * echo $parse
     *     ->setLinkRelationShip('nofollow')
     *     ->getLinkRelationShip();
     *
     * The above outputs "nofollow".
     *
     * @return string The value
     * @since  3.6.0
     * @see    Parser::setLinkRelationShip()
     */
    public function getLinkRelationShip(): string;

    /**
     * Enables restricted parser mode.
     *
     * This option should be enabled when parsing untrusted user input,
     * including comments or forum posts. When enabled, the parser escapes any
     * raw HTML input, ignores unsafe attributes and links only whitelisted URL
     * schemes.
     *
     * For instance the following malicious input:
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * echo $parser
     *     ->setRestricted(true)
     *     ->parse('Innocent _looking_ "link":javacript:window.alert().');
     *
     * Returns safe, sanitized HTML with valid Textile input still parsed:
     *
     * bc. <p>Innocent <em>looking</em> &#8220;link&#8221;:javacript:window.alert().</p>
     *
     * If left disabled, the parser allows users to mix raw HTML and Textile.
     * Using the parser in non-restricted on untrusted input, like comments
     * and forum posts, will lead to XSS issues, as users will be able to use
     * any HTML code, JavaScript links and Textile attributes in their input.
     *
     * @param  bool   $enabled TRUE to enable, FALSE to disable
     * @return self   This instance
     * @since  3.6.0
     * @see    Parser::isRestrictedModeEnabled()
     */
    public function setRestricted(bool $enabled): self;

    /**
     * Whether restricted parser mode is enabled.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * if ($parser->isRestrictedModeEnabled() === true) {
     *     echo 'PHP-Textile is in restricted mode.';
     * }
     *
     * @return bool   TRUE if enabled, FALSE otherwise
     * @since  3.6.0
     * @see    Parser::setRestricted()
     */
    public function isRestrictedModeEnabled(): bool;

    /**
     * Enables and disables raw blocks.
     *
     * When raw blocks are enabled, any paragraph blocks wrapped in a tag
     * not matching Parser::$blockContent or Parser::$phrasingContent will not
     * be parsed, and instead is left as is.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * echo $parser
     *     ->setRawBlocks(true)
     *     ->parse('<div>A *raw* block.</div>');
     *
     * The above generates:
     *
     * bc. <div>A *raw* block.</div>
     *
     * @param  bool   $enabled TRUE to enable, FALSE to disable
     * @return self   This instance
     * @since  3.7.0
     * @see    Parser::isRawBlocksEnabled()
     * @see    Parser::isRawBlock()
     */
    public function setRawBlocks(bool $enabled): self;

    /**
     * Whether raw blocks are enabled.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * if ($parser->isRawBlocksEnabled() === true) {
     *     echo 'Raw blocks are enabled';
     * }
     *
     * @return bool TRUE if enabled, FALSE otherwise
     * @since  3.7.0
     * @see    Parser::setRawBlocks()
     */
    public function isRawBlocksEnabled(): bool;

    /**
     * Enables and disables block-level tags and formatting features.
     *
     * When disabled, block-level tags aren't rendered. This allows PHP-Textile
     * to operate on a single line of text, rather than blocks of text and does
     * not wrap the output in paragraph tags.
     *
     * bc. $parser = new \Netcarving\Textile\Parser();
     * echo $parser
     *     ->setBlockTags(false)
     *     ->parse('h1. Hello *strong* world!');
     *
     * The above generates:
     *
     * bc. h1. Hello <strong>strong</strong> world!
     *
     * @param  bool   $enabled TRUE to enable, FALSE to disable
     * @return self   This instance
     * @since  3.6.0
     * @see    Parser::isBlockTagEnabled()
     */
    public function setBlockTags(bool $enabled): self;

    /**
     * Whether block-level tags are enabled and parsed.
     *
     * bc. $parser = new \Netcarving\Textile\Parser();
     * if ($parser->isBlockTagAllowed() === true) {
     *     echo 'Block tags are enabled.';
     * }
     *
     * @return bool TRUE if enabled, FALSE otherwise
     * @since  3.6.0
     * @see    Parser::setBlockTags()
     */
    public function isBlockTagEnabled(): bool;

    /**
     * Enables and disables line-wrapping.
     *
     * If enabled, line-breaks are replaced by target document's break tag. If
     * disabled, input document's line-breaks are ignored. This setting can be
     * used if the the input document's lines are pre-wrapped. For instance,
     * in case the input is from CLI content, or source code documentation.
     *
     * bc. $parser = new \Netcarving\Textile\Parser();
     * echo $parser
     *     ->setLineWrap(false)
     *     ->parse("Hello\nworld!");
     *
     * The above generates:
     *
     * bc. <p>Hello world!</p>
     *
     * @param  bool   $enabled TRUE to enable, FALSE to disable
     * @return self   This instance
     * @since  3.6.0
     * @see    Parser::isLineWrapEnabled()
     */
    public function setLineWrap(bool $enabled): self;

    /**
     * Whether line-wrapping is enabled.
     *
     * bc. $parser = new \Netcarving\Textile\Parser();
     * if ($parser->isLineWrapEnabled() === true) {
     *     echo 'Line-wrapping is enabled.';
     * }
     *
     * @return bool TRUE if enabled, FALSE otherwise
     * @see    Parser::setLineWrap()
     * @since  3.6.0
     */
    public function isLineWrapEnabled(): bool;

    /**
     * Sets a substitution symbol.
     *
     * This method lets you to redefine a substitution symbol. The following
     * sets the 'half' glyph:
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * echo $parser
     *     ->setSymbol('half', '1&#8260;2')
     *     ->parse('Hello [1/2] World!');
     *
     * Generates:
     *
     * bc. <p>Hello 1&#⁄2 World!</p>
     *
     * Symbol can be set to FALSE to disable it:
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * $parser->setSymbol('dimension', false);
     *
     * See Parser::getSymbol() to find out all available symbols.
     *
     * @param  string      $name  Name of the symbol to assign a new value to
     * @param  string|bool $value New value for the symbol, or FALSE to disable
     * @return self        This instance
     * @see    Parser::getSymbol()
     */
    public function setSymbol(string $name, $value): self;

    /**
     * Gets a symbol definitions.
     *
     * This method gets a symbol definition by name, or the full symbol table
     * as an array.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * echo $parser->getSymbol('dimension');
     *
     * To get all available symbol definitions:
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * print_r($parser->getSymbol());
     *
     * @param  string|null $name The name of the symbol, or NULL if requesting the symbol table
     * @return string[]|false[]|null[]|string The symbol table or the requested symbol
     * @throws \InvalidArgumentException
     * @see    Parser::setSymbol()
     */
    public function getSymbol(?string $name = null);

    /**
     * Sets base relative image prefix.
     *
     * The given string is used to prefix relative image paths, usually an
     * absolute HTTP address pointing a the site's image, or upload, directory.
     * PHP-Textile to convert relative paths to absolute, or prefixed paths.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * $parser->setImagePrefix('https://static.example.com/images/');
     *
     * @param  string $prefix The prefix
     * @return self   This instance
     * @since  3.7.0
     * @see    Parser::getImagePrefix()
     */
    public function setImagePrefix(string $prefix): self;

    /**
     * Gets base relative image prefix.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * echo $parser->getImagePrefix();
     *
     * @return string The prefix
     * @since  3.7.0
     * @see    Parser::setImagePrefix()
     */
    public function getImagePrefix(): string;

    /**
     * Sets base relative link prefix.
     *
     * The given string is used to prefix relative link paths. This allows
     * PHP-Textile convert relative paths to absolute, or prefixed, links.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * $parser->setLinkPrefix('https://example.com/');
     *
     * @param  string $prefix The prefix
     * @return self   This instance
     * @since  3.7.0
     * @see    Parser::getLinkPrefix()
     */
    public function setLinkPrefix(string $prefix): self;

    /**
     * Gets base relative link prefix.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * echo $parser->getLinkPrefix();
     *
     * @return string The prefix
     * @since  3.7.0
     * @see    Parser::setLinkPrefix()
     */
    public function getLinkPrefix(): string;

    /**
     * Enables dimensionless images.
     *
     * If enabled, image width and height attributes will not be included in
     * rendered image tags. Normally, PHP-Textile will add width and height
     * to images linked with a local relative path, as long as the image file
     * can be accessed.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * echo $parser
     *     ->setDimensionlessImages(true)
     *     ->parse('!image.jpg!');
     *
     * @param  bool   $dimensionless TRUE to disable image dimensions, FALSE to enable
     * @return self   This instance
     * @see    Parser::getDimensionlessImages()
     */
    public function setDimensionlessImages(bool $dimensionless = true): self;

    /**
     * Whether dimensionless images are enabled.
     *
     * bc. $parser = new \Netcarver\Textile\Parser();
     * if ($parser->getDimensionlessImages() === true) {
     *     echo 'Images do not get dimensions.';
     * }
     *
     * @return bool TRUE if images will not get dimensions, FALSE otherwise
     * @see    Parser::setDimensionlessImages()
     */
    public function getDimensionlessImages(): bool;
}
