<?php

namespace duncan3dc\MockTests;

use duncan3dc\Mock\CoreFunction;
use duncan3dc\Mock\Exceptions\ExpectationException;
use PHPUnit\Framework\TestCase;

class CoreFunctionTest extends TestCase
{

    public function testClose()
    {
        CoreFunction::mock("abc")->andReturn(123);
        $this->assertSame(123, abc("xyz"));

        CoreFunction::close();
        $this->assertSame("xyz", abc("xyz"));
    }


    public function testUnexpectedArgumentList()
    {
        CoreFunction::mock("abc")->with(777)->andReturn(77777);
        $this->assertSame(77777, abc(777));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Unexpected argument list for abc(88888)");
        abc(88888);
    }
}
