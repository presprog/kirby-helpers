<?php declare(strict_types=1);

namespace tests;

use Kirby\Cms\App;
use PHPUnit\Framework\TestCase;

class SvgTest extends TestCase
{
    protected ?App $app;

    protected function setUp(): void
    {
        $this->app = new App([
            'roots' => [
                'index' => '/dev/null',
            ],
        ]);

        $this->app->extend([
            'options' => [
                'tobimori.icon-field' => [
                    'folder' => function() {
                        return __DIR__ . '/files/icons';
                    }
                ],
            ],
        ]);
    }

    protected function tearDown(): void
    {
        App::destroy();
    }

    public function testInlinesSvgFromFile(): void
    {
        $path = __DIR__ . '/files/icons/bird-house.svg';
        $expected = \file_get_contents($path);

        $this->assertEquals($expected, inline_svg($path));
    }

    public function testInlinesIconFromSourceFolder(): void
    {
        $path = __DIR__ . '/files/icons';
        $icon = 'bird-house.svg';

        $expected = \file_get_contents($path . '/'. $icon);

        $this->assertEquals($expected, inline_icon($icon));
    }
}
