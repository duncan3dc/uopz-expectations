<?php

namespace duncan3dc\MockTests\CoreFunction;

use duncan3dc\Mock\CoreFunction;
use duncan3dc\Mock\Exceptions\ExpectationException;
use PHPUnit\Framework\TestCase;
use function abc;

class SingleArgumentTest extends TestCase
{

    public function tearDown()
    {
        CoreFunction::close();
    }


    public function testDefault()
    {
        CoreFunction::mock("abc")->with("one")->andReturn(777);
        $this->assertSame(777, abc("one"));
    }


    public function testDefaultTooMany()
    {
        CoreFunction::mock("abc")->with("two")->andReturn(777);
        $this->assertSame(777, abc("two"));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function abc('two') should be called 1 times but called at least 2 times");
        abc("two");
    }


    public function testDefaultNotEnough()
    {
        CoreFunction::mock("abc")->with("two")->andReturn(777);

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function abc('two') should be called 1 times but only called 0 times");
        CoreFunction::close();
    }


    public function testZero()
    {
        CoreFunction::mock("abc")->zeroOrMoreTimes()->with(88)->andReturn(777);
        $this->assertTrue(true);
    }


    public function testZeroOrMore()
    {
        CoreFunction::mock("abc")->zeroOrMoreTimes()->with(88)->andReturn(777);
        $this->assertSame(777, abc(88));
    }


    public function testZeroOrMany()
    {
        CoreFunction::mock("abc")->zeroOrMoreTimes()->with(false)->andReturn(777);
        $this->assertSame(777, abc(false));
        $this->assertSame(777, abc(false));
        $this->assertSame(777, abc(false));
        $this->assertSame(777, abc(false));
    }


    public function testOnce()
    {
        CoreFunction::mock("abc")->once()->with(88)->andReturn(777);
        $this->assertSame(777, abc(88));
    }


    public function testOnceTooMany()
    {
        CoreFunction::mock("abc")->once()->with(false)->andReturn(777);
        $this->assertSame(777, abc(false));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function abc(false) should be called 1 times but called at least 2 times");
        abc(false);
    }


    public function testOnceNotEnough()
    {
        CoreFunction::mock("abc")->once()->with(0)->andReturn(777);

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function abc(0) should be called 1 times but only called 0 times");
        CoreFunction::close();
    }


    public function testTwice()
    {
        CoreFunction::mock("abc")->twice()->with([])->andReturn(777);
        $this->assertSame(777, abc([]));
        $this->assertSame(777, abc([]));
    }


    public function testTwiceTooMany()
    {
        CoreFunction::mock("abc")->twice()->with(-1)->andReturn(777);
        $this->assertSame(777, abc(-1));
        $this->assertSame(777, abc(-1));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function abc(-1) should be called 2 times but called at least 3 times");
        abc(-1);
    }


    public function testTwiceNotEnough()
    {
        CoreFunction::mock("abc")->twice()->with("")->andReturn(777);
        $this->assertSame(777, abc(""));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function abc('') should be called 2 times but only called 1 times");
        CoreFunction::close();
    }


    public function testNever()
    {
        CoreFunction::mock("abc")->never()->with(null)->andReturn(777);
        CoreFunction::close();
        $this->assertTrue(true);
    }


    public function testNeverTooMany()
    {
        CoreFunction::mock("abc")->never()->with(true)->andReturn(777);

        $this->expectExceptionMessage("Function abc(true) should be called 0 times but called at least 1 times");
        abc(true);
    }
}
