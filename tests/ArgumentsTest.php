<?php

namespace duncan3dc\MockTests;

use duncan3dc\Mock\Arguments;
use PHPUnit\Framework\TestCase;

class ArgumentsTest extends TestCase
{

    public function testEmpty()
    {
        $arguments = new Arguments;
        $result = (string) $arguments;
        $this->assertSame("", $result);
    }


    public function testString()
    {
        $input = ["1"];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("'1'", $result);
    }


    public function testStringEllipsis()
    {
        $input = ["12345678901234567890"];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("'1234567890...'", $result);
    }


    public function testInt()
    {
        $input = [77];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("77", $result);
    }


    public function testIntEllipsis()
    {
        $input = [123456789];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("12345...", $result);
    }


    public function testFloat()
    {
        $input = [3.14];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("3.14", $result);
    }


    public function testFloatEllipsis()
    {
        $input = [123.45678];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("123.4...", $result);
    }


    public function testTrue()
    {
        $input = [true];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("true", $result);
    }


    public function testFalse()
    {
        $input = [false];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("false", $result);
    }


    public function testNull()
    {
        $input = [null];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("null", $result);
    }


    public function testArray()
    {
        $input = [[9]];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("array", $result);
    }


    public function testObject()
    {
        $input = [new \DateTime];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("DateTime", $result);
    }


    public function testMultiple()
    {
        $input = [7, "8", [], new \DateTime];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("7, '8', array, DateTime", $result);
    }


    public function testMatcher()
    {
        $input = [7, \Mockery::any(), 9];
        $arguments = new Arguments($input);
        $result = (string) $arguments;
        $this->assertSame("7, <Any>, 9", $result);
    }
}
