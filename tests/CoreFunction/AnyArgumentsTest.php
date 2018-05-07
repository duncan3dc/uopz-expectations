<?php

namespace duncan3dc\MockTests\CoreFunction;

use duncan3dc\Mock\CoreFunction;
use duncan3dc\Mock\Exceptions\ExpectationException;
use PHPUnit\Framework\TestCase;
use function time;

class AnyArgumentsTest extends TestCase
{

    public function tearDown()
    {
        CoreFunction::close();
    }


    public function testDefault()
    {
        CoreFunction::mock("time")->andReturn(777);
        $this->assertSame(777, time());
    }


    public function testDefaultTooMany()
    {
        CoreFunction::mock("time")->andReturn(777);
        $this->assertSame(777, time());

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time() should be called 1 times but called at least 2 times");
        time();
    }


    public function testDefaultNotEnough()
    {
        CoreFunction::mock("time")->andReturn(777);

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time() should be called 1 times but only called 0 times");
        CoreFunction::close();
    }


    public function testZero()
    {
        CoreFunction::mock("time")->zeroOrMoreTimes()->andReturn(777);
        $this->assertTrue(true);
    }


    public function testZeroOrMore()
    {
        CoreFunction::mock("time")->zeroOrMoreTimes()->andReturn(777);
        $this->assertSame(777, time());
    }


    public function testZeroOrMany()
    {
        CoreFunction::mock("time")->zeroOrMoreTimes()->andReturn(777);
        $this->assertSame(777, time());
        $this->assertSame(777, time());
        $this->assertSame(777, time());
        $this->assertSame(777, time());
    }


    public function testOnce()
    {
        CoreFunction::mock("time")->once()->andReturn(777);
        $this->assertSame(777, time());
    }


    public function testOnceTooMany()
    {
        CoreFunction::mock("time")->once()->andReturn(777);
        $this->assertSame(777, time());

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time() should be called 1 times but called at least 2 times");
        time();
    }


    public function testOnceNotEnough()
    {
        CoreFunction::mock("time")->once()->andReturn(777);

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time() should be called 1 times but only called 0 times");
        CoreFunction::close();
    }


    public function testTwice()
    {
        CoreFunction::mock("time")->twice()->andReturn(777);
        $this->assertSame(777, time());
        $this->assertSame(777, time());
    }


    public function testTwiceTooMany()
    {
        CoreFunction::mock("time")->twice()->andReturn(777);
        $this->assertSame(777, time());
        $this->assertSame(777, time());

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time() should be called 2 times but called at least 3 times");
        time();
    }


    public function testTwiceNotEnough()
    {
        CoreFunction::mock("time")->twice()->andReturn(777);
        $this->assertSame(777, time());

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time() should be called 2 times but only called 1 times");
        CoreFunction::close();
    }


    public function testNever()
    {
        CoreFunction::mock("time")->never()->andReturn(777);
        CoreFunction::close();
        $this->assertTrue(true);
    }


    public function testNeverTooMany()
    {
        CoreFunction::mock("time")->never()->andReturn(777);

        $this->expectExceptionMessage("Function time() should be called 0 times but called at least 1 times");
        time();
    }
}
