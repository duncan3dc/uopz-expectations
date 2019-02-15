<?php

namespace duncan3dc\MockTests\CoreFunction;

use duncan3dc\Mock\CoreFunction;
use duncan3dc\Mock\Exceptions\ExpectationException;
use PHPUnit\Framework\TestCase;
use function abc;

class DifferentArgumentsTest extends TestCase
{

    public function tearDown(): void
    {
        CoreFunction::close();
    }


    public function testDefault(): void
    {
        CoreFunction::mock("abc")->with("one")->andReturn(777);
        CoreFunction::mock("abc")->with("two")->andReturn(888);

        $this->assertSame(888, abc("two"));
        $this->assertSame(777, abc("one"));
    }


    public function testDefaultMany(): void
    {
        CoreFunction::mock("abc")->with("seven")->andReturn(777);
        CoreFunction::mock("abc")->with("eight")->andReturn(888);

        $this->assertSame(888, abc("eight"));
        $this->assertSame(888, abc("eight"));
        $this->assertSame(777, abc("seven"));
        $this->assertSame(777, abc("seven"));
        $this->assertSame(888, abc("eight"));
        $this->assertSame(777, abc("seven"));
    }


    public function testDefaultZero(): void
    {
        CoreFunction::mock("abc")->with("-7")->andReturn(777);
        CoreFunction::mock("abc")->with("-8")->andReturn(888);
        CoreFunction::close();
        $this->assertTrue(true);
    }


    public function testZeroOrMoreTimes(): void
    {
        CoreFunction::mock("abc")->zeroOrMoreTimes()->with(false)->andReturn(777);
        CoreFunction::mock("abc")->zeroOrMoreTimes()->with(true)->andReturn(888);
        $this->assertSame(777, abc(false));
        $this->assertSame(888, abc(true));
        $this->assertSame(777, abc(false));
        $this->assertSame(888, abc(true));
    }


    public function testOnce(): void
    {
        CoreFunction::mock("abc")->once()->with(77)->andReturn(777);
        CoreFunction::mock("abc")->once()->with(88)->andReturn(888);
        $this->assertSame(888, abc(88));
        $this->assertSame(777, abc(77));
    }


    public function testOnceTooMany(): void
    {
        CoreFunction::mock("abc")->once()->with(7)->andReturn(777);
        CoreFunction::mock("abc")->once()->with(8)->andReturn(888);
        $this->assertSame(888, abc(8));
        $this->assertSame(777, abc(7));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function abc(8) should be called 1 times but called at least 2 times");
        abc(8);
    }


    public function testOnceNotEnough(): void
    {
        CoreFunction::mock("abc")->once()->with("sev")->andReturn(777);
        CoreFunction::mock("abc")->once()->with("eig")->andReturn(888);
        abc("eig");

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function abc('sev') should be called 1 times but only called 0 times");
        CoreFunction::close();
    }


    public function testTwice(): void
    {
        CoreFunction::mock("abc")->twice()->with([7])->andReturn(777);
        CoreFunction::mock("abc")->twice()->with([8])->andReturn(888);
        $this->assertSame(888, abc([8]));
        $this->assertSame(777, abc([7]));
        $this->assertSame(777, abc([7]));
        $this->assertSame(888, abc([8]));
    }


    public function testTwiceTooMany(): void
    {
        CoreFunction::mock("abc")->twice()->with(-7)->andReturn(777);
        CoreFunction::mock("abc")->twice()->with(-8)->andReturn(888);
        $this->assertSame(888, abc(-8));
        $this->assertSame(777, abc(-7));
        $this->assertSame(888, abc(-8));
        $this->assertSame(777, abc(-7));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function abc(-7) should be called 2 times but called at least 3 times");
        abc(-7);
    }


    public function testTwiceNotEnough(): void
    {
        CoreFunction::mock("abc")->twice()->with("70")->andReturn(777);
        CoreFunction::mock("abc")->twice()->with("80")->andReturn(888);
        $this->assertSame(888, abc("80"));
        $this->assertSame(777, abc("70"));
        $this->assertSame(888, abc("80"));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Function abc('70') should be called 2 times but only called 1 times");
        CoreFunction::close();
    }


    public function testNever(): void
    {
        CoreFunction::mock("abc")->never()->with("07")->andReturn(777);
        CoreFunction::mock("abc")->never()->with("08")->andReturn(777);
        CoreFunction::close();
        $this->assertTrue(true);
    }


    public function testNeverTooMany(): void
    {
        CoreFunction::mock("abc")->never()->with("07")->andReturn(777);
        CoreFunction::mock("abc")->never()->with("08")->andReturn(777);

        $this->expectExceptionMessage("Function abc('08') should be called 0 times but called at least 1 times");
        abc("08");
    }
}
