<?php

namespace duncan3dc\Mock;

use duncan3dc\Mock\Exceptions\ExpectationException;
use function array_filter;
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

        $mocks = array_filter($mocks, function (MockedFunction $mock) use ($function) {
            return $mock->getFunctionName() === $function;
        });

        # First try functions that expect the exact arguments, and have expectations that haven't been called yet
        foreach ($mocks as $mock) {
            if ($mock->matchArguments($arguments)) {
                if ($mock->canCall()) {
                    return $mock->call();
                }
            }
        }

        # Then try functions that expect any arguments, and have expectations that haven't been called yet
        foreach ($mocks as $mock) {
            if ($mock->canAcceptArguments($arguments)) {
                if ($mock->canCall()) {
                    return $mock->call();
                }
            }
        }

        # Now try functions that expect the exact arguments (so we can give an accurate error message)
        foreach ($mocks as $mock) {
            if ($mock->matchArguments($arguments)) {
                return $mock->call();
            }
        }

        # Finally try functions that expect any arguments (just so we can throw an error as there are no expectations left)
        foreach ($mocks as $mock) {
            if ($mock->canAcceptArguments($arguments)) {
                return $mock->call();
            }
        }

        if (count($mocks) > 0) {
            throw new ExpectationException("Unexpected argument list for {$function}()");
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
