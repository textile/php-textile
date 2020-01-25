<?php

declare(strict_types=1);

namespace Netcarver\Textile\Test\Helper;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Symfony\Component\Yaml\Yaml;

final class FixtureProvider
{
    /**
     * Fixture provider.
     *
     * @param string $domain
     *
     * @return array[]
     */
    public function getFixtures(?string $domain = null): array
    {
        $path =  \dirname(__DIR__) . '/fixtures';

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
                if (($test['domain'] ?? null) !== $domain) {
                    continue;
                }

                $name = $file->getBasename() . ': ' . $name;

                $out[$name] = [
                    new Fixture(\is_array($test) ? $test : []),
                ];
            }
        }

        return $out;
    }
}
