<?php declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;

class PathTest extends TestCase
{
    public function testJoinsPathFragments()
    {
        $this->assertEquals('this/is/a/path', \path('this', 'is', 'a', 'path'));
        $this->assertEquals('/this/is/a/path', \path('/this', 'is', 'a', 'path'));
        $this->assertEquals('../is/a/path', \path('..', 'is', 'a', 'path'));
    }
}
