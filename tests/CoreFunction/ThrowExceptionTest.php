<?php

namespace duncan3dc\MockTests\CoreFunction;

use duncan3dc\Mock\CoreFunction;
use PHPUnit\Framework\TestCase;

use function abc;

class ThrowExceptionTest extends TestCase
{

    public function tearDown(): void
    {
        CoreFunction::close();
    }


    public function testAndThrow1(): void
    {
        CoreFunction::mock("abc")->andThrow(new \Exception("Stuff gone wrong"));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Stuff gone wrong");
        abc("one");
    }


    public function testAndThrow2(): void
    {
        CoreFunction::mock("abc")->with("two")->once()->andThrow(new \Exception("Stuff gone wrong"));
        CoreFunction::mock("abc")->with("one")->once()->andReturn("success");

        $this->assertSame("success", abc("one"));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Stuff gone wrong");
        abc("two");
    }


    public function testAndThrow3(): void
    {
        CoreFunction::mock("abc")->with("ok")->once()->andReturn("success");
        CoreFunction::mock("abc")->with("ok")->once()->andThrow(new \Exception("Stuff gone wrong"));

        $this->assertSame("success", abc("ok"));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Stuff gone wrong");
        abc("ok");
    }
}
