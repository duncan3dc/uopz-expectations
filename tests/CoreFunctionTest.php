<?php

namespace duncan3dc\MockTests;

use duncan3dc\Mock\CoreFunction;
use PHPUnit\Framework\TestCase;

class CoreFunctionTest extends TestCase
{

    public function testClose()
    {
        CoreFunction::mock("time")->andReturn(123);
        $this->assertSame(123, time());

        CoreFunction::close();
        $this->assertNotSame(123, time());
    }
}
