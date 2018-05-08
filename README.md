# uopz-expectations
Mock core functions and set up expectations similar to Mockery.

Full documentation is available at http://duncan3dc.github.io/uopz-expectations/  
PHPDoc API documentation is also available at [http://duncan3dc.github.io/uopz-expectations/api/](http://duncan3dc.github.io/uopz-expectations/api/namespaces/duncan3dc.Mock.html)  

[![Latest Version](https://poser.pugx.org/duncan3dc/uopz-expectations/version.svg)](https://packagist.org/packages/duncan3dc/uopz-expectations)
[![Build Status](https://travis-ci.org/duncan3dc/uopz-expectations.svg?branch=master)](https://travis-ci.org/duncan3dc/uopz-expectations)
[![Coverage Status](https://coveralls.io/repos/github/duncan3dc/uopz-expectations/badge.svg)](https://coveralls.io/github/duncan3dc/uopz-expectations)


## Introduction

The [uopz](https://secure.php.net/manual/en/intro.uopz.php) extension offers an easy to way mock core functions.  
The [Mockery](https://github.com/mockery/mockery) library offers a succinct API to declare expectation method calls.  
This library combines the two to offer core function mocking with a familiar API.  


## Installation

The recommended method of installing this library is via [Composer](//getcomposer.org/).

Run the following command from your project root:

```bash
$ composer require duncan3dc/uopz-expectations
```


## Getting Started

```php
use duncan3dc\Mock\CoreFunction;

CoreFunction::mock("time")->twice()->with()->andReturn(777);

time(); # 777

/**
 * At this point the expectations will be checked,
 * and an exception will be throw as `time()`
 * should have been called twice.
 */
CoreFunction::close();
```

_Read more at http://duncan3dc.github.io/uopz-expectations/_  


## Where to get help
Found a bug? Got a question? Just not sure how something works?  
Please [create an issue](//github.com/duncan3dc/uopz-expectations/issues) and I'll do my best to help out.  
Alternatively you can catch me on [Twitter](https://twitter.com/duncan3dc)
