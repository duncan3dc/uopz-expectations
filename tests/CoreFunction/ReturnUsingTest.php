<?php

namespace duncan3dc\MockTests\CoreFunction;

use duncan3dc\Mock\CoreFunction;
use PHPUnit\Framework\TestCase;

use function abc;
use function implode;

class ReturnUsingTest extends TestCase
{

    public function tearDown(): void
    {
        CoreFunction::close();
    }


    public function testAndReturn1(): void
    {
        CoreFunction::mock("abc")->andReturnUsing("strlen");

        $this->assertSame(3, abc("one"));
    }


    public function testAndReturn2(): void
    {
        CoreFunction::mock("abc")->with("using")->once()->andReturnUsing("strlen");
        CoreFunction::mock("abc")->with("one")->once()->andReturn("first");

        $this->assertSame("first", abc("one"));
        $this->assertSame(5, abc("using"));
    }


    public function testAndReturn3(): void
    {
        CoreFunction::mock("abc")->with("one", "two")->once()->andReturnUsing(function (...$args) {
            return implode("_", $args);
        });

        $this->assertSame("one_two", abc("one", "two"));
    }


    public function testAndReturn4(): void
    {
        CoreFunction::mock("time")->with()->once()->andReturnUsing(function () {
            return 1986;
        });

        $this->assertSame(1986, time());
    }
}
