<?php

namespace duncan3dc\Mock;

use duncan3dc\Mock\Exceptions\ExpectationException;
use Mockery\Matcher\MatcherAbstract;

final class MockedFunction
{
    /**
     * @var string $name The name of the function we are mocking.
     */
    private $name;

    /**
     * @var int $times How many times this function should be called.
     */
    private $times = 1;

    /**
     * @var Arguments $arguments The arguments this function is called with.
     */
    private $arguments;

    /**
     * @var mixed $return The return value of this function.
     */
    private $return;

    /**
     * @var int $called How many times this function has been called.
     */
    private $called = 0;


    /**
     * Create a new instance.
     *
     * @param string $name The name of the function we are mocking
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->arguments = new Arguments;
    }


    /**
     * Get the name of the function we are mocking.
     *
     * @return string
     */
    public function getFunctionName(): string
    {
        return $this->name;
    }


    /**
     * Get the expected arguments for this function.
     *
     * @return Arguments
     */
    public function getArguments(): Arguments
    {
        return $this->arguments;
    }


    /**
     * Set the number of times this function can be called.
     *
     * @param int $times The number of times to expect it
     *
     * @return $this
     */
    public function times(int $times): MockedFunction
    {
        $this->times = $times;
        return $this;
    }


    /**
     * Allow this function to be called unlimited times or never at all.
     *
     * @return $this
     */
    public function zeroOrMoreTimes(): MockedFunction
    {
        return $this->times(-1);
    }


    /**
     * Allow this function to be called exactly once.
     *
     * @return $this
     */
    public function once(): MockedFunction
    {
        return $this->times(1);
    }


    /**
     * Allow this function to be called exactly twice.
     *
     * @return $this
     */
    public function twice(): MockedFunction
    {
        return $this->times(2);
    }


    /**
     * Ensure this function is never called.
     *
     * @return $this
     */
    public function never(): MockedFunction
    {
        return $this->times(0);
    }


    /**
     * Set the arguments this function should be called with.
     *
     * @param mixed ...$values
     *
     * @return $this
     */
    public function with(...$values): MockedFunction
    {
        $this->arguments = new Arguments($values);
        return $this;
    }


    /**
     * Set the value this function should return.
     *
     * @param mixed $return The value that will be returned
     *
     * @return $this
     */
    public function andReturn($return): MockedFunction
    {
        $this->return = $return;
        return $this;
    }


    /**
     * Check if the specified arguments are identical to the arguments this function expects.
     *
     * @param Arguments $arguments The arguments to check
     *
     * @return bool
     */
    public function matchArguments(Arguments $arguments): bool
    {
        return $this->arguments->equal($arguments);
    }


    /**
     * Check if the specified arguments are acceptable for this function.
     *
     * @param Arguments $arguments The arguments to check
     *
     * @return bool
     */
    public function canAcceptArguments(Arguments $arguments): bool
    {
        return $this->arguments->canAccept($arguments);
    }


    /**
     * Check if this function has more expectations to accept.
     *
     * @return bool
     */
    public function canCall(): bool
    {
        if ($this->times === -1) {
            return true;
        }

        return ($this->called < $this->times);
    }


    /**
     * Call this function and get its return value.
     *
     * @return mixed
     */
    public function call(Arguments $values)
    {
        ++$this->called;
        if ($this->times > -1 && $this->called > $this->times) {
            throw new ExpectationException("Function {$this->name}({$this->arguments}) should be called {$this->times} times but called at least {$this->called} times");
        }

        $matchers = $this->arguments->getValues();

        if ($matchers === null) {
            return $this->return;
        }

        foreach ($matchers as $index => $matcher) {
            if ($matcher instanceof MatcherAbstract) {
                $value = $values->getValues()[$index];
                $matcher->match($value);
                $values->setValue($index, $value);
            }
        }

        return $this->return;
    }


    /**
     * Get the number of times this function is expected to be called.
     *
     * @return int
     */
    public function getExpectedCount(): int
    {
        return $this->times;
    }


    /**
     * Get the number of times this function has been called.
     *
     * @return int
     */
    public function getCalledCount(): int
    {
        return $this->called;
    }
}
