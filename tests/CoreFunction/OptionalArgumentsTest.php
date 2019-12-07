<?php

namespace duncan3dc\MockTests\CoreFunction;

use duncan3dc\Mock\CoreFunction;
use duncan3dc\Mock\Exceptions\ExpectationException;
use Mockery;
use PHPUnit\Framework\TestCase;

use function abc;

class OptionalArgumentsTest extends TestCase
{

    public function tearDown(): void
    {
        CoreFunction::close();
    }


    public function testDefault(): void
    {
        CoreFunction::mock("exec")->with("ls")->andReturn(777);
        $this->assertSame(777, exec("ls"));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Unexpected argument list for exec('anything')");
        exec("anything");
    }


    public function testOneOptional(): void
    {
        CoreFunction::mock("exec")->with("ls", null)->andReturn(777);
        $this->assertSame(777, exec("ls", $extra));

        $this->expectException(ExpectationException::class);
        $this->expectExceptionMessage("Unexpected argument list for exec('anything', 'blergh')");
        $extra = "blergh";
        exec("anything", $extra);
    }
}
