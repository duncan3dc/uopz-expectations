<?php

namespace duncan3dc\MockTests;

use duncan3dc\Mock\Arguments;
use PHPUnit\Framework\TestCase;

class ArgumentsTest extends TestCase
{

    public function tearDown(): void
    {
        uopz_unset_return("is_string");
    }


    public function testEmpty(): void
    {
        $arguments = new Arguments();
        $result = (string) $arguments;
        $this->assertSame("", $result);
    }


    public function testString(): void
    {
        $input = ["1"];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("'1'", $result);
    }


    public function testStringEllipsis(): void
    {
        $input = ["12345678901234567890"];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("'1234567890...'", $result);
    }


    public function testInt(): void
    {
        $input = [77];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("77", $result);
    }


    public function testIntEllipsis(): void
    {
        $input = [123456789];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("12345...", $result);
    }


    public function testFloat(): void
    {
        $input = [3.14];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("3.14", $result);
    }


    public function testFloatEllipsis(): void
    {
        $input = [123.45678];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("123.4...", $result);
    }


    public function testTrue(): void
    {
        $input = [true];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("true", $result);
    }


    public function testFalse(): void
    {
        $input = [false];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("false", $result);
    }


    public function testNull(): void
    {
        $input = [null];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("null", $result);
    }


    public function testArray(): void
    {
        $input = [[9]];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("array", $result);
    }


    public function testObject(): void
    {
        $input = [new \DateTime()];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("DateTime", $result);
    }


    public function testMultiple(): void
    {
        $input = [7, "8", [], new \DateTime()];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("7, '8', array, DateTime", $result);
    }


    public function testMatcher(): void
    {
        $input = [7, \Mockery::any(), 9];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("7, <Any>, 9", $result);
    }


    public function testUnknown(): void
    {
        uopz_set_return("is_string", false);

        $input = [1, "two", 3];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("1, UNKNOWN, 3", $result);
    }


    public function testCanAccept1(): void
    {
        $input = [1, "two", 3];
        $arguments = new Arguments($input);

        $result = $arguments->canAccept(new Arguments());
        $this->assertFalse($result);
    }
}
