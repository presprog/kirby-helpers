<?php declare(strict_types=1);

namespace tests;

use Kirby\Cms\App;
use Kirby\Cms\Page;
use Kirby\Content\Field;
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
                    'folder' => function () {
                        return __DIR__ . '/files/icons';
                    },
                ],
            ],
        ]);
        App::$enableWhoops = false;
    }

    protected function tearDown(): void
    {
        App::destroy();
    }

    public function testInlinesSvgFromFile(): void
    {
        $path     = __DIR__ . '/files/icons/bird-house.svg';
        $expected = \file_get_contents($path);

        $this->assertEquals($expected, inline_svg($path));
    }

    public function testInlinesSvgWithClasses(): void
    {
        $expected = \file_get_contents(__DIR__ . '/files/icons/bird-house-class.svg');

        $this->assertEquals($expected, inline_svg(__DIR__ . '/files/icons/bird-house.svg', 'bird-house-icon'));
    }

    public function testInlinesIcon(): void
    {
        $path = __DIR__ . '/files/icons';
        $icon = 'bird-house.svg';

        $expected = \file_get_contents($path . '/' . $icon);

        $this->assertEquals($expected, inline_icon($icon));
    }

    public function testInlinesIconFromField(): void
    {
        $path = __DIR__ . '/files/icons';
        $icon = 'bird-house.svg';

        $page = new Page([
            'title' => 'Test',
            'slug' => 'test',
        ]);

        $field = new Field($page, 'icon', $icon);

        $expected = \file_get_contents($path . '/' . $icon);

        $this->assertEquals($expected, inline_icon($field));
    }

    public function testInlinesIconWithClass(): void
    {
        $expected = \file_get_contents(__DIR__ . '/files/icons/bird-house-class.svg');

        $this->assertEquals($expected, inline_icon('bird-house.svg', 'bird-house-icon'));
    }
}
