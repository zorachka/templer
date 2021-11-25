<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Templer\Twig\Extensions\Frontend\Test;

use Zorachka\Framework\Templer\Twig\Extensions\Frontend\FrontendUrlGenerator;

test('FrontendUrlGenerator generate with empty URI', function () {
    $generator = new FrontendUrlGenerator('https://test');
    expect($generator->generate(''))->toBe('https://test');
});

test('FrontendUrlGenerator generate with not empty URI', function () {
    $generator = new FrontendUrlGenerator('https://test');
    expect($generator->generate('path'))->toBe('https://test/path');
});

test('FrontendUrlGenerator generate with params', function () {
    $generator = new FrontendUrlGenerator('https://test');
    expect($generator->generate('path', [
        'a' => 1,
        'b' => 2,
    ]))->toBe('https://test/path?a=1&b=2');
});
