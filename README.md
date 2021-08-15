# uopz-expectations
Mock core functions and set up expectations similar to Mockery.

Full documentation is available at http://duncan3dc.github.io/uopz-expectations/  
PHPDoc API documentation is also available at [http://duncan3dc.github.io/uopz-expectations/api/](http://duncan3dc.github.io/uopz-expectations/api/namespaces/duncan3dc.Mock.html)  

[![release](https://poser.pugx.org/duncan3dc/uopz-expectations/version.svg)](https://packagist.org/packages/duncan3dc/uopz-expectations)
[![build](https://github.com/duncan3dc/uopz-expectations/workflows/.github/workflows/buildcheck.yml/badge.svg?branch=master)](https://github.com/duncan3dc/uopz-expectations/actions?query=branch%3Amaster+workflow%3A.github%2Fworkflows%2Fbuildcheck.yml)
[![coverage](https://codecov.io/gh/duncan3dc/uopz-expectations/graph/badge.svg)](https://codecov.io/gh/duncan3dc/uopz-expectations)


## Introduction

The [uopz](https://secure.php.net/manual/en/intro.uopz.php) extension offers an easy to way mock core functions.  
The [Mockery](https://github.com/mockery/mockery) library offers a succinct API to declare expectation method calls.  
This library combines the two to offer core function mocking with a familiar API.  


## Installation

The recommended method of installing this library is via [Composer](//getcomposer.org/).

Run the following command from your project root:

```bash
$ composer require --dev duncan3dc/uopz-expectations
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


## duncan3dc/uopz-expectations for enterprise

Available as part of the Tidelift Subscription

The maintainers of duncan3dc/uopz-expectations and thousands of other packages are working with Tidelift to deliver commercial support and maintenance for the open source dependencies you use to build your applications. Save time, reduce risk, and improve code health, while paying the maintainers of the exact dependencies you use. [Learn more.](https://tidelift.com/subscription/pkg/packagist-duncan3dc-uopz-expectations?utm_source=packagist-duncan3dc-uopz-expectations&utm_medium=referral&utm_campaign=readme)
