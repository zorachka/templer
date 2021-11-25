<?php

declare(strict_types=1);

namespace Zorachka\Framework\Templer;

final class TemplerConfig
{
    private string $templatesDirectory;
    private string $cacheDirectory;
    private bool $debug;

    private function __construct(
        string $templatesDirectory,
        string $cacheDirectory,
        bool $debug,
    ) {
        $this->templatesDirectory = $templatesDirectory;
        $this->cacheDirectory = $cacheDirectory;
        $this->debug = $debug;
    }

    public static function withDefaults(
        string $templatesDirectory = '@templates',
        string $cacheDirectory = '@cache',
        bool $debug = false,
    ): self {
        return new self($templatesDirectory, $cacheDirectory, $debug);
    }

    /**
     * @return string
     */
    public function templatesDirectory(): string
    {
        return $this->templatesDirectory;
    }

    /**
     * @return string
     */
    public function cacheDirectory(): string
    {
        return $this->cacheDirectory;
    }

    /**
     * @return bool
     */
    public function debug(): bool
    {
        return $this->debug;
    }
}
