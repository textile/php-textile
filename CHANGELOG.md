# Changelog

Here's a summary of changes in each release. The list doesn't include some small changes or updates to test cases.

## [Version 3.7.4 - 2019/12/15](https://github.com/textile/php-textile/releases/tag/v3.7.4)

* Fix: Issue where an inline tag preceding the last character, that is a glyph, is not rendered if the block tags are disabled with `Parser::setBlockTags` (closes #198).

## [Version 3.7.3 - 2019/08/30](https://github.com/textile/php-textile/releases/tag/v3.7.3)

* Fix: Issues where divider tags placed on their own line within a paragraph, would disable Textile processing for that paragraph block (closes #194).

## [Version 3.7.2 - 2019/06/08](https://github.com/textile/php-textile/releases/tag/v3.7.2)

* Fix: Quote and bracket processing around span and other inline tags (closes #191 and #192).

## [Version 3.7.1 - 2019/01/26](https://github.com/textile/php-textile/releases/tag/v3.7.1)

* Fix: Fix and omit anchor links prefixing (closes #190).
* Fix: Alignment attribute can be specified last within a block tag definition (closes #189).

## [Version 3.7.0 - 2018/12/15](https://github.com/textile/php-textile/releases/tag/v3.7.0)

* Add: Option to disable specific substitution symbols by setting them to `FALSE` (closes #158).
* Add: Option to apply classes, such as language-identifiers, to the code element within a `bc` (closes #96).
* Add: `Parser::configure()`, the method can be extended to create pre-configured parser classes without having to inherit full constructor.
* Add: Automatic paragraph wrapping now checks the contents and does not wrap paragraphs blocks already wrapped in non-phrasing HTML tags (closes #22 and #63).
* Add: Option to disable Textile formatting for blocks wrapped in non-standard HTML-like tags.
* Add: `Parser::setImagePrefix()`, `Parser::setLinkPrefix()`, `Parser::getImagePrefix()` and `Parser::getLinkPrefix()` (closes #169).
* Add: `Parser::setRawBlocks()` and `Parser::isRawBlocksEnabled()`.
* Fix: problems with list parsing - no longer matches inline-syntax, such as `strong` tags, as list item markers (closes #172).
* Fix: Check for starting list depth (closes #24).
* Deprecate: `Parser::setRelativeImagePrefix()` and `Parser::$relativeImagePrefix` in favour of the new decoupled methods.

## [Version 3.6.1 - 2018/10/21](https://github.com/textile/php-textile/releases/tag/v3.6.1)

* Fix: Problems with attribute parsing under PHP >= 7.1 (closes #175 and #176).
* Fix: Missing deprecation notices, where they were annotated, but no notices were raised.
* Internal: Add test fixture for Unicode characters in image title attributes.
* Internal: Tidy entity encoding process (closes #182).
* Internal: Drop legacy PHP 5.5 and 5.4 unit test targets due to test suite's dependencies' requirements.
* Internal: Test suite compatibility issues under PHP >= 7.2 (closes #184).

## [Version 3.6.0 - 2016/11/17](https://github.com/textile/php-textile/releases/tag/v3.6.0)

* Add: More versatile parsing method, `Parser::parse()`.
* Add: `Parser::setRestricted()` and `Parser::isRestrictedModeEnabled()`.
* Add: `Parser::setLite()` and `Parser::isLiteModeEnabled()`.
* Add: `Parser::setDocumentType()` and `Parser::getDocumentType()`.
* Add: `Parser::setDocumentRootDirectory()` and `Parser::getDocumentRootDirectory()`.
* Add: `Parser::setImages()` and `Parser::isImageTagEnabled()`.
* Add: `Parser::setBlockTags()` and `Parser::isBlockTagEnabled()` (closes #138).
* Add: `Parser::setLinkRelationShip()` and `Parser::getLinkRelationShip()`.
* Add: `Parser::setLineWrap()` and `Parser::isLineWrapEnabled()` (closes #139).
* Change: Make dimension glyph replacements a little stricter.
* Change: Various code cleanups, typo corrections and refactoring.
* Change: Documentation fixes and extensions.
* Deprecate: `Parser::textileThis()`, `Parser::textileRestricted()` and `Parser::textileCommon()` in favour of the more versatile `Parser::parse()`.
* Fix: Allow link text that contains newline characters (closes #154, #155 and #167).
* Fix: Empty-like link texts (closes #141).
* Fix: Empty-like RedCloth definitions (closes #142).
* Fix: Empty-like table summaries (closes #143).
* Fix: Image dimension generation on Windows when document root can not be resolved (closes #140).
* Fix: HTTP protocol restrictions not affecting images (closes #144).
* Fix: `Parser::relURL()` now supports unicode characters (closes #146).
* Fix: Do not encode `+` characters in `tel` links (closes #156).
* Fix: Prevent hyphenated class on `td` cells adding incorrect style (closes #164).
* Fix: Jail image dimensions reads to images within the document root path (closes #145).

## [Version 3.5.5 - 2014/01/02](https://github.com/textile/php-textile/releases/tag/v3.5.5)

* Change: Clean user-supplied styles prior to sorting and re-formatting.
* Change: Refactored link detection code.
* Fix: Footnote reference numbers support unicode characters.
* Fix: Rendering of left and right image alignment in non-lite restricted mode (closes #132).
* Fix: Wrong triggered error type when using the deprecated `$encode` option of `Parser::textileThis()`.
* Fix: Attribute regular expression to stop it matching multiple times (closes #131).
* Fix: Rendering of lists in table cells with span attributes set (closes #135).
* Fix: Throws an exception if `Parser::__construct()` is given invalid document type, instead of eating it silently and returning document using the default content-type you weren't wishing for.
* Internal: Remove dead code and duplicated procedures as outlined by code coverage reports.
* Internal: Remove unused internal method `Parser::fSpecial()`.
* Internal: Test code coverage, coding style and run unit tests against [HHVM](http://hhvm.com).
* Internal: Use named sub-patterns in regular expressions (closes #121).

## [Version 3.5.4 - 2013/11/06](https://github.com/textile/php-textile/releases/tag/v3.5.4)

* Fix: broken image alignment in HTML5 mode (closes #123).
* Fix: duplicate HTML IDs that occur when a footnote isn't referenced in the content (closes #125).
* Fix: Don't include image alignment to the URL in restricted mode.
* Fix: Detect and process quoted quote symbols.
* Fix: New link parser (closes #86, #87 and #128).

## [Version 3.5.3 - 2013/10/30](https://github.com/textile/php-textile/releases/tag/v3.5.3)

* Change: Unify and consistent Redcloth-style definition list attribute order.
* Change: Reduce list and blockquote indentation level to match paragraphs and other block tags.
* Fix: Double image URL encoding (closes #102).
* Fix: URL reference token spoofing.
* Fix: Broken parser output when `$strict` argument was set to `TRUE` (closes #119).
* Fix: Memory leaking tag cache. Tag cache is never reset between `textileThis() and `textileRestricted()` calls referencing the same instance.
* Fix: Rare instances where a link displays a wrong URL mentioned elsewhere in the document.
* Fix: Invalid markup generated when Redcloth-style definition list is used inside a table cell.
* Fix: Link aliases follow same allowed URL schemes as normal links.
* Fix: Restrict how spans are parsed (closes #106).
* Fix: Citations on spans (closes #120).
* Internal: Update `hasRawText()` and `fPBr()` to detect a wider range of raw HTML and XHTML.
* Internal: Refactor `parseAttribsToArray()` slightly.

## [Version 3.5.2 - 2013/10/25](https://github.com/textile/php-textile/releases/tag/v3.5.2)

* Fix: Improved support for Redcloth-style definition lists. Allows multiple terms and linebreaks within.
* Fix: Incorrectly rendered `rel` attributes (closes #103).
* Fix: `getSymbol()` actually returns the named symbol (closes #104).
* Fix: Unicode link aliases that were broken on some PCRE_UTF8 supporting systems.
* Fix: Collapsing whitespace and preserve newlines. Preserves whitespace inside extended `bc`, `notextile` and `pre` blocks, rather than collapsing two or more empty lines down to one. Renders whitespace as it was defined, rather than using hard-coded single linefeed to separate lines (closes #109 and #111).
* Fix: The number of code tags rendered inside long code blocks (closes #116).
* Fix: Token spoofing from the document body by randomizing generated token references (closes #115).
* Fix: Add image dimensions to images even when Textile is run via command line. On CLI, images are looked from the current working directory.
* Fix: Add `br` tags to headings instead of leaving linebreaks untouched.
* Internal: Define class properties as protected rather than not at all, causing them to be created dynamically as public.
* Internal: Move internal property definitions from the constructor to class definition.
* Internal: Added runnable PHPUnit tests, integration with Travis CI.
* Internal: Removed error suppression, the code doesn't intentionally produce notices.

## [Version 3.5.1 - 2013/01/01](https://github.com/textile/php-textile/releases/tag/v3.5.1)

* Add: `setDimensionlessImages()` and `getDimensionlessImages()` to disable width and height generation for relative images and better support content for responsive layouts (closes #100).
* Fix: Remove horizontal alignment from inline tags (closes #66).
* Fix: Automatic relative image width and height generation (closes #101).
* Fix: Allow dots (`.`) in class attributes (closes #97).

## [Version 3.5.0 - 2012/12/12](https://github.com/textile/php-textile/releases/tag/v3.5.0)

* Add: Support installation via [Composer](https://getcomposer.org/).
* Add: Extend recognition of dimension sign to more complex cases. `-0.5 x -.1 x +100` to `-0.5 × -.1 × +100`, or if PCRE is built with unicode support currency symbols are supported such as `10 x -€ 110,00` to `10 × -€ 110,00`.
* Add: Self-referencing links can now be combined with link aliases, e.g. `"$":alias1`.
* Add: Allow nesting unordered, ordered and definition lists.
* Add: `Parser::textileEncode()` method. This is preferred over calling `Parser::textileThis()` with the `$encode` flag argument.
* Change: Do not indent generated paragraphs with single tab character (closes #90).
* Fix: Memory leaks and performance degradation when reusing same Textile parser instance multiple times.
* Fix: Improve PCRE named capture group compatibility (closes #78).
* Fix: Improve parsing of large, >= 10 000 character, documents (closes #81).
* Fix: Improve parsing of inline tags within table cells when the cell contains no leading or trailing whitespace.
* Fix: Improve parsing of lists within table cells (closes #79).
* Fix: Undefined offset notice when parsing notextile (`==`) tags (closes #83).
* Fix: Undefined variable notice when parsing Redcloth-style definition lists.
* Fix: Improve left and right alignment attribute notation (`>`, `<`) support in different contexts.
* Fix: Preserve relative `../` notation in image URLs (closes #69).
* Fix: Do not double-encode `@` or `%` in urls.
* Fix: Improve detection of open quotes in situations such as `["(Berk). Hilton"]` where the open quote was previously incorrectly detected as encoded.
* Fix: Parsing links directly followed by `:`, `;` or `?` character. Previously the following character was consumed into the link URL.
* Internal: Unified method names & coding styles according to PSR-1 & PSR-2.
* Internal: Follow PSR-0, PSR-1 and PSR-2 standards.
* Internal: Remove legacy SVN references and old Textpattern CMS integration methods.
* Internal: Refactored code, removed internal deprecated methods.
* Internal: Added visibility to all properties and methods.
* Internal: Drop PHP4-style constructors in favor of `__construct()` method.
* Remove: `Textile` class, and constants, from global namespace and split it into multi-file PSR-0 namespaced classes `\Netcarver\Textile\Parser`, `\Netcarver\Textile\DataBag` and `\Netcarver\Textile\Tag`.
* Remove: Drop PHP < 5.3 compatibility, now requires PHP >= 5.3.

## [Version 2.4.1 - 2012/08/23](https://github.com/textile/php-textile/releases/tag/v2.4.1)

* Fix: Add `sftp`, `callto`, `tel` and `file` schemes to the URI whitelist in unrestricted mode.
* Fix: Support international format `tel` URIs when used via link aliases.
* Fix: Extend link alias syntax to all available URI schemes in unrestricted mode.
* Fix: Reverted looser matching of list-like structures as it introduced problems in block-level elements that can legitimately have literals or other non-lists in them that are similar to textile's lists (closes #65).
* Fix: Strong tags containing a numeric value right at the start of the line, are not incorrectly parsed into into lists (closes #61).
* Fix: Reverted line break formatting within table cells as it intervened with list syntax parsing (closes #71).
* Fix: Double glyph parsing within table cells (closes #67).

## [Version 2.4.0 - 2012/05/07](https://github.com/textile/php-textile/releases/tag/v2.4.0)

* Add: `start` attribute to ordered lists.
* Add: Basic Redcloth-style definition list syntax support.
* Add: Convert linebreaks to `<br/>` inside table cells.
* Add: HTML comment tag support.
* Add: Ability to customise footnote references and anchors.
* Add: Adjoined lists when spawned across multiple blocks.
* Add: Allow note list references to be customised.
* Fix: Unicode support within reference links.
* Fix: `https` scheme support reference links.
* Fix: Loosen recognition of note definitions and note lists to reduce false and ignored matches.
* Fix: Allow apostrophe between `)` and a word character.
* Internal: Small code cleanups.
* Internal: Conditionally use unicode PCRE in span tag regular expression pattern (closes #53).

## [Version 2.3.2 - 2012/03/20](https://github.com/textile/php-textile/releases/tag/v2.3.2)

* Add: Support use of multiple classes in block tags.
* Add: HTML5 doctype support. Doctype can be set from the `Textile` class constructor.
* Change: When targeting HTML5, `abbr` are generated instead of `acronym`.
* Change: When targeting HTML5, alignment is applied using classes rather than HTML `align` attribute.
* Change: Apply safe auto-assigned classes also in restricted mode.
* Change: Generated note list link is wrapped in HTML `sup` tag rather than other way around (closes #20).
* Change: Allow any of hard-coded set of `¤§µ¶†‡•∗∴◊♠♣♥♦` as a note list back-reference character (closes #38).
* Change: self-referencing link text does not contain the scheme.
* Fix: Retain trailing `[` within inline tags.
* Fix: Encode unicode characters in link URLs.
* Fix: Remove attributes from HTML `code` tags generated by `bc` block code tag.
* Fix: En-dash glyph formatting and conflicts with other formatters (closes #50).

## [Version 2.3.0 - 2012/01/10](https://github.com/textile/php-textile/releases/tag/v2.3)

* Change: Allow pipe closure of captions.
* Change: Allow missing closing pipe in `colgroup`.
* Change: Add `rel` attributes to linked images.
* Fix: PHP >= 5.3.0 compatibility, drop use of deprecated `split` function.
* Fix: Potential DoS in `Textile::cleanba()`.
* Fix: Issues where a class would eat the note label.
* Fix: Sanitise image URLs.
* Fix: Allow inline span tags to be applied within non-English quotation marks.
* Fix: Allow non-English quotation marks inside inline span tags.
* Fix: Note-style links can use index 0.
* Fix: Encode quotes in restricted mode, rather than improperly leaving them as is.
* Fix: Improve lang, style, id and class handling.
* Fix: Center aligned cells aren't treated as captions.
* Fix: Disallow unsafe block attributes in restricted mode.

## [Version 2.2.0 - 2010/09/22](https://github.com/textile/php-textile/releases/tag/v2.2public)

This is our first standalone release split from revision 3359 of [Textpattern CMS](https://textpattern.com). Here are the changes since PHP-Textile v2.0.0:

* Add: `colgroup`, `thead`, `tbody` and `tfoot` syntax in tables.
* Add: Definition list syntax.
* Add: Format glyphs such as fractions, plus-minus and degrees.
* Add: Auto-numbered note lists.
* Add: Textile comment tag. Comments aren't displayed in the generated markup.
* Add: self-links where the URL can be used as the link text, e.g. `"$":http://example.com`.
* Change: Less restrictive paragraph breaking.
* Change: Output cleaner inline styles.
* Change: Remove horizontal and vertical alignment attributes from list elements.
* Change: Lists can use dot terminator.
* Fix: Allow duplicate note lists with different back-reference characters.
* Fix: Properly parse empty table cells.
* Fix: Optimize style attribute processing.
* Fix: More restrictive apostrophe encoding and matching.
* Fix: Allow linebreaks in table cells.
* Fix: Duplicate footnote IDs.
* Fix: Auto-generated `caps` span isn't added to acronyms.
