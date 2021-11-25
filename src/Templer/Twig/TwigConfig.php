<?php

declare(strict_types=1);

namespace Zorachka\Framework\Templer\Twig;

final class TwigConfig
{
    private array $extensions;
    private string $frontendUrl;

    private function __construct(array $extensions, string $frontendUrl)
    {
        $this->extensions = $extensions;
        $this->frontendUrl = $frontendUrl;
    }

    public static function withDefaults(array $extensions = [], string $frontendUrl = ''): self
    {
        return new self($extensions, $frontendUrl);
    }

    public function withExtension(string $extensionClassName): self
    {
        $new = clone $this;
        $new->extensions[] = $extensionClassName;

        return $new;
    }

    /**
     * @return array
     */
    public function extensions(): array
    {
        return $this->extensions;
    }

    /**
     * @return string
     */
    public function frontendUrl(): string
    {
        return $this->frontendUrl;
    }
}
