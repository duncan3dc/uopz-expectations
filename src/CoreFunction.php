<?php

namespace duncan3dc\Mock;

use function uopz_set_return;
use function uopz_unset_return;

final class CoreFunction
{
    /**
     * @var MockedFunction[] $mocks The registered mocks.
     */
    private static $mocks = [];


    /**
     * Set up a core function to be mocked.
     *
     * @param string $function The name of the function to be mocked
     *
     * @return MockedFunction
     */
    public static function mock(string $function): MockedFunction
    {
        $mock = new MockedFunction($function);

        self::$mocks[] = $mock;

        uopz_set_return($function, function (...$values) use ($function) {
            $arguments = new Arguments($values);
            return CoreFunction::call($function, $arguments);
        }, true);

        return $mock;
    }


    /**
     * Call the mocked version of a function.
     *
     * @param string $function The name of the function to be called
     * @param Arguments $arguments The arguments to be passed to the function
     *
     * @return mixed
     */
    public static function call(string $function, Arguments $arguments)
    {
        $mocks = self::$mocks;

        foreach ($mocks as $mock) {
            if ($mock->getFunctionName() === $function) {
                return $mock->call($arguments);
            }
        }
    }


    /**
     * Finish the mocking, check for any expectations, and restore any mocked functions.
     *
     * @return void
     */
    public static function close(): void
    {
        $mocks = self::$mocks;
        self::$mocks = [];

        foreach ($mocks as $mock) {
            uopz_unset_return($mock->getFunctionName());
        }

        foreach ($mocks as $mock) {
            $function = $mock->getFunctionName();
            $arguments = $mock->getArguments();
            $times = $mock->getExpectedCount();
            $called = $mock->getCalledCount();
            if ($times > $called) {
                throw new ExpectationException("Function {$function}({$arguments}) should be called {$times} times but only called {$called} times");
            }
        }
    }
}
