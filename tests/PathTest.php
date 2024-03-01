<?php declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;

class PathTest extends TestCase
{

    public function testJoinsPathFragments()
    {
        $path = \path('this', 'is', 'a', 'path');

        $this->assertEquals('this/is/a/path', $path);
    }
}
