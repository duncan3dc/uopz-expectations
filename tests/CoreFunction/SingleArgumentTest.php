<?php

namespace duncan3dc\MockTests;

use duncan3dc\Mock\CoreFunction;
use duncan3dc\Mock\Exceptions\ExpectationException;
use PHPUnit\Framework\TestCase;
use function time;

class SingleArgumentTest extends TestCase
{

    public function tearDown()
    {
        CoreFunction::close();
    }


    public function testDefault()
    {
        CoreFunction::mock("time")->with("one")->andReturn(777);
        $this->assertSame(777, time("one"));
    }


    public function testDefaultTooMany()
    {
        CoreFunction::mock("time")->with("two")->andReturn(777);
        $this->assertSame(777, time("two"));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time('two') should be called 1 times but called at least 2 times");
        time("two");
    }


    public function testDefaultNotEnough()
    {
        CoreFunction::mock("time")->with("two")->andReturn(777);

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time('two') should be called 1 times but only called 0 times");
        CoreFunction::close();
    }


    public function testZero()
    {
        CoreFunction::mock("time")->zeroOrMoreTimes()->with(88)->andReturn(777);
        $this->assertTrue(true);
    }


    public function testZeroOrMore()
    {
        CoreFunction::mock("time")->zeroOrMoreTimes()->with(88)->andReturn(777);
        $this->assertSame(777, time(88));
    }


    public function testZeroOrMany()
    {
        CoreFunction::mock("time")->zeroOrMoreTimes()->with(false)->andReturn(777);
        $this->assertSame(777, time(false));
        $this->assertSame(777, time(false));
        $this->assertSame(777, time(false));
        $this->assertSame(777, time(false));
    }


    public function testOnce()
    {
        CoreFunction::mock("time")->once()->with(88)->andReturn(777);
        $this->assertSame(777, time(88));
    }


    public function testOnceTooMany()
    {
        CoreFunction::mock("time")->once()->with(false)->andReturn(777);
        $this->assertSame(777, time(false));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time(false) should be called 1 times but called at least 2 times");
        time(false);
    }


    public function testOnceNotEnough()
    {
        CoreFunction::mock("time")->once()->with(0)->andReturn(777);

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time(0) should be called 1 times but only called 0 times");
        CoreFunction::close();
    }


    public function testTwice()
    {
        CoreFunction::mock("time")->twice()->with([])->andReturn(777);
        $this->assertSame(777, time([]));
        $this->assertSame(777, time([]));
    }


    public function testTwiceTooMany()
    {
        CoreFunction::mock("time")->twice()->with(-1)->andReturn(777);
        $this->assertSame(777, time(-1));
        $this->assertSame(777, time(-1));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time(-1) should be called 2 times but called at least 3 times");
        time(-1);
    }


    public function testTwiceNotEnough()
    {
        CoreFunction::mock("time")->twice()->with("")->andReturn(777);
        $this->assertSame(777, time(""));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time('') should be called 2 times but only called 1 times");
        CoreFunction::close();
    }


    public function testNever()
    {
        CoreFunction::mock("time")->never()->with(null)->andReturn(777);
        CoreFunction::close();
        $this->assertTrue(true);
    }


    public function testNeverTooMany()
    {
        CoreFunction::mock("time")->never()->with(true)->andReturn(777);

        $this->expectExceptionMessage("Function time(true) should be called 0 times but called at least 1 times");
        time(true);
    }
}
