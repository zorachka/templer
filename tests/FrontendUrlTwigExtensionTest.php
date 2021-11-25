<?php

declare(strict_types=1);

use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Zorachka\Framework\Templer\Twig\Extensions\Frontend\FrontendUrlGenerator;
use Zorachka\Framework\Templer\Twig\Extensions\Frontend\FrontendUrlTwigExtension;

test('FrontendUrlTwigExtension render url correctly', function () {
    $frontend = $this->createMock(FrontendUrlGenerator::class);
    $frontend->expects($this->once())->method('generate')->with(
        $this->equalTo('path'),
        $this->equalTo(['a' => '1', 'b' => 2]),
    )->willReturn($url = 'https://test/path?a=1&b=2');

    $twig = new Environment(new ArrayLoader([
        'page.html.twig' => '<p>{{ frontend_url(\'path\', {\'a\': 1, \'b\': 2}) }}</p>',
    ]));
    $twig->addExtension(new FrontendUrlTwigExtension($frontend));

    expect($twig->render('page.html.twig'))->toBe('<p>https://test/path?a=1&amp;b=2</p>');
});
