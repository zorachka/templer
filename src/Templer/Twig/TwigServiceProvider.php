<?php

declare(strict_types=1);

namespace Zorachka\Framework\Templer\Twig;

use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Extension\ExtensionInterface;
use Twig\Loader\FilesystemLoader;
use Zorachka\Framework\Container\ServiceProvider;
use Zorachka\Framework\Directories\Directories;
use Zorachka\Framework\Templer\Templer;
use Zorachka\Framework\Templer\TemplerConfig;
use Zorachka\Framework\Templer\Twig\Extensions\Frontend\FrontendUrlGenerator;

final class TwigServiceProvider implements ServiceProvider
{
    /**
     * @inheritDoc
     */
    public static function getDefinitions(): array
    {
        return [
            Environment::class => function (ContainerInterface $container): Environment {
                /** @var Directories $directories */
                $directories = $container->get(Directories::class);
                /** @var TemplerConfig $templer */
                $templer = $container->get(TemplerConfig::class);
                /** @var TwigConfig $twig */
                $twig = $container->get(TwigConfig::class);

                $loader = new FilesystemLoader();
                $templatesDirectory = $directories->get($templer->templatesDirectory());
                $templateDirectories = [
                    FilesystemLoader::MAIN_NAMESPACE => $templatesDirectory,
                ];

                foreach ($templateDirectories as $alias => $directory) {
                    $loader->addPath($directory, $alias);
                }

                $cacheDirectory = $directories->get($templer->cacheDirectory());
                $environment = new Environment($loader, [
                    'cache' => $templer->isDebugEnabled() ? false : $cacheDirectory,
                    'debug' => $templer->isDebugEnabled(),
                    'strict_variables' => $templer->isDebugEnabled(),
                    'auto_reload' => $templer->isDebugEnabled(),
                ]);

                if ($templer->isDebugEnabled()) {
                    $environment->addExtension(new DebugExtension());
                }

                foreach ($twig->extensions() as $extensionClassName) {
                    /** @var ExtensionInterface $extension */
                    $extension = $container->get($extensionClassName);
                    $environment->addExtension($extension);
                }

                return $environment;
            },
            FrontendUrlGenerator::class => function (ContainerInterface $container): FrontendUrlGenerator {
                /** @var TwigConfig $config */
                $config = $container->get(TwigConfig::class);

                return new FrontendUrlGenerator($config->frontendUrl());
            },
            Templer::class => static function (ContainerInterface $container) {
                $environment = $container->get(Environment::class);

                return new TwigTempler($environment);
            },
            TwigConfig::class => static fn() => TwigConfig::withDefaults(),
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
