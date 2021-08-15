<?php

namespace duncan3dc\MockTests;

use duncan3dc\Mock\CoreFunction;
use duncan3dc\Mock\Exceptions\ExpectationException;
use Mockery;
use PHPUnit\Framework\TestCase;

class CoreFunctionTest extends TestCase
{


    /** @inheritDoc */
    public function tearDown(): void
    {
        CoreFunction::close();
    }


    public function testClose(): void
    {
        CoreFunction::mock("abc")->andReturn(123);
        $this->assertSame(123, abc("xyz"));

        CoreFunction::close();
        $this->assertSame("xyz", abc("xyz"));
    }


    public function testUnexpectedArgumentList(): void
    {
        CoreFunction::mock("abc")->with(777)->andReturn(77777);
        $this->assertSame(77777, abc(777));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Unexpected argument list for abc(88888)");
        abc(88888);
    }


    public function testReferences(): void
    {
        $lines = Mockery::on(function (&$lines) {
            $lines = ["line1", "line2"];
            return true;
        });

        $status = Mockery::on(function (&$status) {
            $status = 17;
            return true;
        });

        CoreFunction::mock("exec")->with("ls", $lines, $status)->andReturn(3);

        $lines = [];
        $status = 0;
        $result = exec("ls", $lines, $status);
        $this->assertSame(3, $result);

        $this->assertSame(["line1", "line2"], $lines);
        $this->assertSame(17, $status);
    }


    /**
     * Ensure we only call a closure once if it matches.
     */
    public function testClosureCallTimes(): void
    {
        $times = 0;

        $parameter = Mockery::on(function ($number) use (&$times) {
            ++$times;
            return true;
        });

        CoreFunction::mock("abc")->with($parameter)->andReturn(456);

        $result = abc(123);
        $this->assertSame(456, $result);
        $this->assertSame(1, $times);
    }
}
