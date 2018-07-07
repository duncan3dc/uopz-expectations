<?php

namespace duncan3dc\MockTests\CoreFunction;

use duncan3dc\Mock\CoreFunction;
use duncan3dc\Mock\Exceptions\ExpectationException;
use PHPUnit\Framework\TestCase;
use function abc;

class MatcherArgumentsTest extends TestCase
{

    public function tearDown()
    {
        CoreFunction::close();
    }


    public function testDefault()
    {
        CoreFunction::mock("abc")->with(\Mockery::any())->andReturn(777);
        CoreFunction::mock("abc")->with("specific")->andReturn(888);

        $this->assertSame(888, abc("specific"));
        $this->assertSame(777, abc("anything"));
    }


    public function testDefaultTooMany()
    {
        CoreFunction::mock("abc")->with(\Mockery::any())->andReturn(777);
        $this->assertSame(777, abc("seven"));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function abc(<Any>) should be called 1 times but called at least 2 times");
        abc("eight");
    }


    public function testDefaultNotEnough()
    {
        CoreFunction::mock("abc")->with(\Mockery::any())->andReturn(777);
        CoreFunction::mock("abc")->with("-8")->andReturn(888);
        $this->assertSame(888, abc("-8"));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function abc(<Any>) should be called 1 times but only called 0 times");
        CoreFunction::close();
    }


    public function testZeroOrMoreTimes()
    {
        CoreFunction::mock("abc")->zeroOrMoreTimes()->with(\Mockery::any())->andReturn(777);
        CoreFunction::mock("abc")->zeroOrMoreTimes()->with(null)->andReturn(888);
        $this->assertSame(888, abc(null));
        $this->assertSame(777, abc("giraffe"));
        $this->assertSame(888, abc(null));
        $this->assertSame(777, abc("ostrich"));
    }


    public function testOnce()
    {
        CoreFunction::mock("abc")->once()->with(88)->andReturn(888);
        CoreFunction::mock("abc")->once()->with(\Mockery::any())->andReturn(777);
        $this->assertSame(888, abc(88));
        $this->assertSame(777, abc(77));
    }


    public function testOnceTooMany()
    {
        CoreFunction::mock("abc")->once()->with(7)->andReturn(777);
        CoreFunction::mock("abc")->once()->with(\Mockery::any())->andReturn(888);
        $this->assertSame(888, abc(8));
        $this->assertSame(777, abc(7));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function abc(<Any>) should be called 1 times but called at least 2 times");
        abc(8);
    }


    public function testOnceNotEnough()
    {
        CoreFunction::mock("abc")->once()->with("sev", \Mockery::any())->andReturn(777);
        CoreFunction::mock("abc")->once()->with("eig")->andReturn(888);
        abc("eig");

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function abc('sev', <Any>) should be called 1 times but only called 0 times");
        CoreFunction::close();
    }


    public function testUnexpectedArguments()
    {
        CoreFunction::mock("abc")->with(\Mockery::any())->andReturn(777);
        CoreFunction::mock("abc")->with([8])->andReturn(888);
        $this->assertSame(888, abc([8]));
        $this->assertSame(777, abc([7]));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Unexpected argument list for abc(7, 8)");
        abc(7, 8);
    }
}
