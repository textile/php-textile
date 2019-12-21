<?php

declare(strict_types=1);

namespace Netcarver\Textile\Test;

final class Info
{
    /**
     * Prints environment information.
     */
    public function print(): void
    {
        $this->line();
        $this->line('Extensions loaded:');
        $this->lines($this->getLoadedExtensions());
        $this->line();
    }

    /**
     * Prints a line.
     *
     * @param string $message The message to print
     */
    private function line(string $message = ''): void
    {
        echo $message . "\n";
    }

    /**
     * Prints an array of lines.
     *
     * @param string[] $messages The messages to print
     */
    private function lines(array $messages = []): void
    {
        $this->line('  ' . \implode("\n  ", $messages));
    }

    /**
     * Gets an array of loaded extensions.
     *
     * @return string[]
     */
    private function getLoadedExtensions(): array
    {
        $extensions = \get_loaded_extensions();

        \sort($extensions);

        return $extensions;
    }
}
