<?php

namespace duncan3dc\MockTests;

use duncan3dc\Mock\CoreFunction;
use duncan3dc\Mock\Exceptions\ExpectationException;
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


    public function testUnexpectedArgumentList()
    {
        CoreFunction::mock("time")->with(777)->andReturn(77777);
        $this->assertSame(77777, time(777));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Unexpected argument list for time(88888)");
        time(88888);
    }
}
