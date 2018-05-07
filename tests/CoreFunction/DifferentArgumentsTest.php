<?php

namespace duncan3dc\MockTests\CoreFunction;

use duncan3dc\Mock\CoreFunction;
use duncan3dc\Mock\Exceptions\ExpectationException;
use PHPUnit\Framework\TestCase;
use function time;

class DifferentArgumentsTest extends TestCase
{

    public function tearDown()
    {
        CoreFunction::close();
    }


    public function testDefault()
    {
        CoreFunction::mock("time")->with("one")->andReturn(777);
        CoreFunction::mock("time")->with("two")->andReturn(888);

        $this->assertSame(888, time("two"));
        $this->assertSame(777, time("one"));
    }


    public function testDefaultTooMany()
    {
        CoreFunction::mock("time")->with("seven")->andReturn(777);
        CoreFunction::mock("time")->with("eight")->andReturn(888);
        $this->assertSame(888, time("eight"));
        $this->assertSame(777, time("seven"));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time('eight') should be called 1 times but called at least 2 times");
        time("eight");
    }


    public function testDefaultNotEnough()
    {
        CoreFunction::mock("time")->with("-7")->andReturn(777);
        CoreFunction::mock("time")->with("-8")->andReturn(888);
        $this->assertSame(888, time("-8"));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time('-7') should be called 1 times but only called 0 times");
        CoreFunction::close();
    }


    public function testZeroOrMoreTimes()
    {
        CoreFunction::mock("time")->zeroOrMoreTimes()->with(false)->andReturn(777);
        CoreFunction::mock("time")->zeroOrMoreTimes()->with(true)->andReturn(888);
        $this->assertSame(777, time(false));
        $this->assertSame(888, time(true));
        $this->assertSame(777, time(false));
        $this->assertSame(888, time(true));
    }


    public function testOnce()
    {
        CoreFunction::mock("time")->once()->with(77)->andReturn(777);
        CoreFunction::mock("time")->once()->with(88)->andReturn(888);
        $this->assertSame(888, time(88));
        $this->assertSame(777, time(77));
    }


    public function testOnceTooMany()
    {
        CoreFunction::mock("time")->once()->with(7)->andReturn(777);
        CoreFunction::mock("time")->once()->with(8)->andReturn(888);
        $this->assertSame(888, time(8));
        $this->assertSame(777, time(7));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time(8) should be called 1 times but called at least 2 times");
        time(8);
    }


    public function testOnceNotEnough()
    {
        CoreFunction::mock("time")->once()->with("sev")->andReturn(777);
        CoreFunction::mock("time")->once()->with("eig")->andReturn(888);
        time("eig");

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time('sev') should be called 1 times but only called 0 times");
        CoreFunction::close();
    }


    public function testTwice()
    {
        CoreFunction::mock("time")->twice()->with([7])->andReturn(777);
        CoreFunction::mock("time")->twice()->with([8])->andReturn(888);
        $this->assertSame(888, time([8]));
        $this->assertSame(777, time([7]));
        $this->assertSame(777, time([7]));
        $this->assertSame(888, time([8]));
    }


    public function testTwiceTooMany()
    {
        CoreFunction::mock("time")->twice()->with(-7)->andReturn(777);
        CoreFunction::mock("time")->twice()->with(-8)->andReturn(888);
        $this->assertSame(888, time(-8));
        $this->assertSame(777, time(-7));
        $this->assertSame(888, time(-8));
        $this->assertSame(777, time(-7));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time(-7) should be called 2 times but called at least 3 times");
        time(-7);
    }


    public function testTwiceNotEnough()
    {
        CoreFunction::mock("time")->twice()->with("70")->andReturn(777);
        CoreFunction::mock("time")->twice()->with("80")->andReturn(888);
        $this->assertSame(888, time("80"));
        $this->assertSame(777, time("70"));
        $this->assertSame(888, time("80"));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function time('70') should be called 2 times but only called 1 times");
        CoreFunction::close();
    }


    public function testNever()
    {
        CoreFunction::mock("time")->never()->with("07")->andReturn(777);
        CoreFunction::mock("time")->never()->with("08")->andReturn(777);
        CoreFunction::close();
        $this->assertTrue(true);
    }


    public function testNeverTooMany()
    {
        CoreFunction::mock("time")->never()->with("07")->andReturn(777);
        CoreFunction::mock("time")->never()->with("08")->andReturn(777);

        $this->expectExceptionMessage("Function time('08') should be called 0 times but called at least 1 times");
        time("08");
    }
}
