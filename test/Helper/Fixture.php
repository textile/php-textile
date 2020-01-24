<?php

declare(strict_types=1);

namespace Netcarver\Textile\Test\Helper;

use Netcarver\Textile\Api\ParserInterface;
use Netcarver\Textile\Parser;

/**
 * Test fixture.
 *
 * @internal
 */
final class Fixture
{
    /**
     * Test data.
     *
     * @var array
     */
    private $data;

    /**
     * Constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Gets input.
     *
     * @return string
     */
    public function getInput(): string
    {
        $value = $this->data['input'] ?? '';

        if (\is_string($value)) {
            return $this->normalize($value);
        }

        return '';
    }

    /**
     * Gets expected.
     *
     * @return string
     */
    public function getExpected(): string
    {
        $value = $this->data['expect'] ?? '';

        if (\is_string($value)) {
            return $this->strip($this->normalize($value));
        }

        return '';
    }

    public function getParsed(): string
    {
        return $this->strip($this->getParser()->parse($this->getInput()));
    }

    /**
     * Whether the fixture is skipped.
     *
     * @return bool
     */
    public function isSkipped(): bool
    {
        return $this->data['skip'] ?? false;
    }

    /**
     * Whether the fixture is valid.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return !empty($this->data);
    }

    private function getParser(): ParserInterface
    {
        $class = $this->data['class'] ?? Parser::class;

        // phpcs:ignore
        $object = new $class;

        foreach ($this->data['setup'] ?? [] as $setup) {
            foreach ($setup as $method => $value) {
                $object->$method($value);
            }
        }

        return $object;
    }

    private function normalize(string $input): string
    {
        return \strtr($input, [
            '\x20' => ' ',
        ]);
    }

    private function strip(string $input): string
    {
        $strip = [
            '/ id="(fn|note)[a-z0-9\-]*"/',
            '/ href="#(fn|note)[a-z0-9\-]*"/',
        ];

        return \rtrim((string) \preg_replace($strip, '', $input));
    }
}
