<?php

namespace duncan3dc\MockTests\CoreFunction;

use duncan3dc\Mock\CoreFunction;
use duncan3dc\Mock\Exceptions\ExpectationException;
use PHPUnit\Framework\TestCase;

use function abc;

class DifferentReturnValuesTest extends TestCase
{

    public function tearDown(): void
    {
        CoreFunction::close();
    }


    public function testDefault(): void
    {
        CoreFunction::mock("abc")->with("one")->andReturn(777);
        CoreFunction::mock("abc")->with("one")->andReturn(888);

        $this->assertSame(777, abc("one"));
        $this->assertSame(777, abc("one"));
    }


    public function testDefaultMany(): void
    {
        CoreFunction::mock("abc")->with("two")->andReturn(777);
        CoreFunction::mock("abc")->with("two")->andReturn(888);
        $this->assertSame(777, abc("two"));
        $this->assertSame(777, abc("two"));
        $this->assertSame(777, abc("two"));
    }


    public function testDefaultZero(): void
    {
        CoreFunction::mock("abc")->with("two")->andReturn(777);
        CoreFunction::mock("abc")->with("two")->andReturn(888);
        $this->assertSame(777, abc("two"));
        CoreFunction::close();
    }


    public function testZeroOrMoreTimes(): void
    {
        CoreFunction::mock("abc")->zeroOrMoreTimes()->with(false)->andReturn(777);
        CoreFunction::mock("abc")->zeroOrMoreTimes()->with(false)->andReturn(888);
        $this->assertSame(777, abc(false));
        $this->assertSame(777, abc(false));
        $this->assertSame(777, abc(false));
        $this->assertSame(777, abc(false));
    }


    public function testOnce(): void
    {
        CoreFunction::mock("abc")->once()->with(88)->andReturn(777);
        CoreFunction::mock("abc")->once()->with(88)->andReturn(888);
        $this->assertSame(777, abc(88));
        $this->assertSame(888, abc(88));
    }


    public function testOnceTooMany(): void
    {
        CoreFunction::mock("abc")->once()->with(false)->andReturn(777);
        CoreFunction::mock("abc")->once()->with(false)->andReturn(888);
        $this->assertSame(777, abc(false));
        $this->assertSame(888, abc(false));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function abc(false) should be called 1 times but called at least 2 times");
        abc(false);
    }


    public function testOnceNotEnough(): void
    {
        CoreFunction::mock("abc")->once()->with(0)->andReturn(777);
        CoreFunction::mock("abc")->once()->with(0)->andReturn(888);
        abc(0);

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function abc(0) should be called 1 times but only called 0 times");
        CoreFunction::close();
    }


    public function testTwice(): void
    {
        CoreFunction::mock("abc")->twice()->with([])->andReturn(777);
        CoreFunction::mock("abc")->twice()->with([])->andReturn(888);
        $this->assertSame(777, abc([]));
        $this->assertSame(777, abc([]));
        $this->assertSame(888, abc([]));
        $this->assertSame(888, abc([]));
    }


    public function testTwiceTooMany(): void
    {
        CoreFunction::mock("abc")->twice()->with(-1)->andReturn(777);
        CoreFunction::mock("abc")->twice()->with(-1)->andReturn(888);
        $this->assertSame(777, abc(-1));
        $this->assertSame(777, abc(-1));
        $this->assertSame(888, abc(-1));
        $this->assertSame(888, abc(-1));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function abc(-1) should be called 2 times but called at least 3 times");
        abc(-1);
    }


    public function testTwiceNotEnough(): void
    {
        CoreFunction::mock("abc")->twice()->with("")->andReturn(777);
        CoreFunction::mock("abc")->twice()->with("")->andReturn(888);
        $this->assertSame(777, abc(""));
        $this->assertSame(777, abc(""));
        $this->assertSame(888, abc(""));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function abc('') should be called 2 times but only called 1 times");
        CoreFunction::close();
    }


    public function testNever(): void
    {
        CoreFunction::mock("abc")->never()->with(null)->andReturn(777);
        CoreFunction::mock("abc")->never()->with(null)->andReturn(888);
        CoreFunction::close();
        $this->assertTrue(true);
    }


    public function testNeverTooMany(): void
    {
        CoreFunction::mock("abc")->never()->with(true)->andReturn(777);
        CoreFunction::mock("abc")->never()->with(true)->andReturn(888);

        $this->expectExceptionMessage("Function abc(true) should be called 0 times but called at least 1 times");
        abc(true);
    }
}
