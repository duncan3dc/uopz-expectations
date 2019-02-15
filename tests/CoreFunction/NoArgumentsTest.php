<?php

namespace duncan3dc\MockTests\CoreFunction;

use duncan3dc\Mock\CoreFunction;
use duncan3dc\Mock\Exceptions\ExpectationException;
use PHPUnit\Framework\TestCase;
use function time;

class NoArgumentsTest extends TestCase
{

    public function tearDown(): void
    {
        CoreFunction::close();
    }


    public function testDefault(): void
    {
        CoreFunction::mock("time")->with()->andReturn(777);
        $this->assertSame(777, time());
    }


    public function testDefaultMany(): void
    {
        CoreFunction::mock("time")->with()->andReturn(777);
        $this->assertSame(777, time());
        $this->assertSame(777, time());
        $this->assertSame(777, time());
    }


    public function testDefaultZero(): void
    {
        CoreFunction::mock("time")->with()->andReturn(777);
        CoreFunction::close();
        $this->assertTrue(true);
    }


    public function testZero(): void
    {
        CoreFunction::mock("time")->zeroOrMoreTimes()->with()->andReturn(777);
        $this->assertTrue(true);
    }


    public function testZeroOrMore(): void
    {
        CoreFunction::mock("time")->zeroOrMoreTimes()->with()->andReturn(777);
        $this->assertSame(777, time());
    }


    public function testZeroOrMany(): void
    {
        CoreFunction::mock("time")->zeroOrMoreTimes()->with()->andReturn(777);
        $this->assertSame(777, time());
        $this->assertSame(777, time());
        $this->assertSame(777, time());
        $this->assertSame(777, time());
    }


    public function testOnce(): void
    {
        CoreFunction::mock("time")->once()->with()->andReturn(777);
        $this->assertSame(777, time());
    }


    public function testOnceTooMany(): void
    {
        CoreFunction::mock("time")->once()->with()->andReturn(777);
        $this->assertSame(777, time());

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time() should be called 1 times but called at least 2 times");
        time();
    }


    public function testOnceNotEnough(): void
    {
        CoreFunction::mock("time")->once()->with()->andReturn(777);

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time() should be called 1 times but only called 0 times");
        CoreFunction::close();
    }


    public function testTwice(): void
    {
        CoreFunction::mock("time")->twice()->with()->andReturn(777);
        $this->assertSame(777, time());
        $this->assertSame(777, time());
    }


    public function testTwiceTooMany(): void
    {
        CoreFunction::mock("time")->twice()->with()->andReturn(777);
        $this->assertSame(777, time());
        $this->assertSame(777, time());

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time() should be called 2 times but called at least 3 times");
        time();
    }


    public function testTwiceNotEnough(): void
    {
        CoreFunction::mock("time")->twice()->with()->andReturn(777);
        $this->assertSame(777, time());

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time() should be called 2 times but only called 1 times");
        CoreFunction::close();
    }


    public function testNever(): void
    {
        CoreFunction::mock("time")->never()->with()->andReturn(777);
        CoreFunction::close();
        $this->assertTrue(true);
    }


    public function testNeverTooMany(): void
    {
        CoreFunction::mock("time")->never()->with()->andReturn(777);

        $this->expectExceptionMessage("Function time() should be called 0 times but called at least 1 times");
        time();
    }
}
