<?php

declare(strict_types=1);

namespace Zorachka\Framework\Templer;

use Zorachka\Framework\Container\ServiceProvider;

final class TemplerServiceProvider implements ServiceProvider
{
    /**
     * @inheritDoc
     */
    public static function getDefinitions(): array
    {
        return [
            TemplerConfig::class => static fn() => TemplerConfig::withDefaults(),
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getExtensions(): array
    {
        return [];
    }
}
