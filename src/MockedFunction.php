<?php

namespace duncan3dc\Mock;

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
     * Call this function and get its return value.
     *
     * @return mixed
     */
    public function call()
    {
        ++$this->called;

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
