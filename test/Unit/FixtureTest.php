<?php

declare(strict_types=1);

namespace Netcarver\Textile\Test\Unit;

use Netcarver\Textile\Test\Helper\Fixture;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Symfony\Component\Yaml\Yaml;

final class FixtureTest extends TestCase
{
    /**
     * Change the working directory to the test directory.
     *
     * This jails the parser to it.
     */
    public function setUp(): void
    {
        \chdir(\dirname(__DIR__));
    }

    /**
     * Runs fixture tests.
     *
     * @param Fixture $fixture
     *
     * @dataProvider dataProvider
     */
    public function testFixture(Fixture $fixture): void
    {
        $this->assertTrue($fixture->isValid(), 'Fixture is invalid.');

        if ($fixture->isSkipped()) {
            $this->markTestSkipped();
        }

        $this->assertSame($fixture->getExpected(), $fixture->getParsed());
    }

    /**
     * Fixture provider.
     *
     * @return array[]
     */
    public function dataProvider(): array
    {
        $path = \dirname(__DIR__) . '/fixtures';

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

        $out = [];

        // phpcs:ignore
        /** @var SplFileInfo $file */
        foreach ($iterator as $file) {
            if (!$file->isFile() || !\in_array($file->getExtension(), ['yml', 'yaml'], true)) {
                continue;
            }

            $yaml = Yaml::parseFile($file->getPathname());

            foreach ($yaml as $name => $test) {
                $name = $file->getBasename() . ': ' . $name;

                $out[$name] = [
                    new Fixture(\is_array($test) ? $test : []),
                ];
            }
        }

        return $out;
    }
}
