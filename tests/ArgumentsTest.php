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
        $arguments = new Arguments(["1"]);
        $result = (string) $arguments;
        $this->assertSame("'1'", $result);
    }


    public function testStringEllipsis()
    {
        $arguments = new Arguments(["12345678901234567890"]);
        $result = (string) $arguments;
        $this->assertSame("'1234567890...'", $result);
    }


    public function testInt()
    {
        $arguments = new Arguments([77]);
        $result = (string) $arguments;
        $this->assertSame("77", $result);
    }


    public function testIntEllipsis()
    {
        $arguments = new Arguments([123456789]);
        $result = (string) $arguments;
        $this->assertSame("12345...", $result);
    }


    public function testFloat()
    {
        $arguments = new Arguments([3.14]);
        $result = (string) $arguments;
        $this->assertSame("3.14", $result);
    }


    public function testFloatEllipsis()
    {
        $arguments = new Arguments([123.45678]);
        $result = (string) $arguments;
        $this->assertSame("123.4...", $result);
    }


    public function testTrue()
    {
        $arguments = new Arguments([true]);
        $result = (string) $arguments;
        $this->assertSame("true", $result);
    }


    public function testFalse()
    {
        $arguments = new Arguments([false]);
        $result = (string) $arguments;
        $this->assertSame("false", $result);
    }


    public function testNull()
    {
        $arguments = new Arguments([null]);
        $result = (string) $arguments;
        $this->assertSame("null", $result);
    }


    public function testArray()
    {
        $arguments = new Arguments([[9]]);
        $result = (string) $arguments;
        $this->assertSame("array", $result);
    }


    public function testObject()
    {
        $arguments = new Arguments([new \DateTime]);
        $result = (string) $arguments;
        $this->assertSame("DateTime", $result);
    }


    public function testMultiple()
    {
        $arguments = new Arguments([7, "8", [], new \DateTime]);
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
