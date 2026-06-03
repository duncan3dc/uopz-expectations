<?php

namespace duncan3dc\MockTests\CoreFunction;

use duncan3dc\Mock\CoreFunction;
use duncan3dc\Mock\Exceptions\ExpectationException;
use PHPUnit\Framework\TestCase;

use function abc;

final class FallbackToDefaultTest extends TestCase
{
    public function tearDown(): void
    {
        CoreFunction::close();
    }


    public function testDefault(): void
    {
        CoreFunction::mock("abc")->once()->with(false)->andReturn(123)->fallbackToDefault();

        $this->assertSame(123, abc(false));
        $this->assertSame(true, abc(true));
    }
}
