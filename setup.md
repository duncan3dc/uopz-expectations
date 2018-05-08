---
layout: default
title: Setup
permalink: /setup/
api: CoreFunction
---

All classes are in the `duncan3dc\Mock` namespace.  

The most important thing to remember is to call `close()` when finished.  

The easiest way to use this library is with [PHPUnit](https://phpunit.de/):

~~~php
use duncan3dc\Mock\CoreFunction;

class ExampleTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        CoreFunction::close();
    }


    public function testDefault()
    {
        CoreFunction::mock("time")->with("one")->andReturn(777);
        CoreFunction::mock("time")->with("two")->andReturn(888);

        $this->assertSame(888, time("two"));
        $this->assertSame(777, time("one"));
    }
}
~~~


