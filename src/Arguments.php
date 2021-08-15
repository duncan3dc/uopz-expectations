<?php

namespace duncan3dc\Mock;

use Mockery\Matcher\MatcherAbstract;

use function array_key_exists;
use function count;
use function get_class;
use function is_array;
use function is_bool;
use function is_numeric;
use function is_object;
use function is_string;
use function strlen;
use function substr;

final class Arguments
{
    /**
     * @var array<int,mixed>|null $values The arguments this instance represents.
     */
    private $values;

    /** @var array<int,mixed> */
    private $matchedValues = [];


    /**
     * Create a new instance.
     *
     * @param array<int,mixed> $values The arguments this instance represents.
     */
    public function __construct(array &$values = null)
    {
        $this->values = $values;
    }


    /**
     * Get the values these arguments represent.
     *
     * @return array<int,mixed>|null
     */
    public function getValues(): ?array
    {
        return $this->values;
    }


    /**
     * Get the previously matched value of an argument.
     *
     * @return mixed
     */
    public function getMatchedValue(int $index)
    {
        if (!array_key_exists($index, $this->matchedValues)) {
            throw new \RuntimeException("This matcher value hasn't been stored");
        }

        return $this->matchedValues[$index];
    }


    /**
     * Update the value of one of the arguments.
     *
     * @param mixed $value
     *
     * @return void
     */
    public function setValue(int $index, $value): void
    {
        $this->values[$index] = $value;
    }


    /**
     * Check if the specified arguments are identical to the expected arguments.
     *
     * @param self $arguments The arguments to check
     *
     * @return bool
     */
    public function equal(self $arguments): bool
    {
        return $this->values === $arguments->getValues();
    }


    /**
     * Check if the specified arguments are acceptable as a match for the expected arguments.
     *
     * @param self $arguments The arguments to check
     *
     * @return bool
     */
    public function canAccept(self $arguments): bool
    {
        if ($this->values === null) {
            return true;
        }

        if ($this->equal($arguments)) {
            return true;
        }

        $values = $arguments->getValues();
        if ($values === null) {
            return false;
        }

        if (count($this->values) !== count($values)) {
            return false;
        }

        foreach ($values as $key => $actual) {
            $expected = $this->values[$key];

            if ($expected === $actual) {
                continue;
            }

            if ($expected instanceof MatcherAbstract) {
                if ($expected->match($actual)) {
                    $this->matchedValues[$key] = $actual;
                    continue;
                }
            }

            # If we couldn't find a match for this argument then give up
            return false;
        }

        return true;
    }


    /**
     * Create a user friendly version of the arguments.
     *
     * @return string
     */
    public function __toString(): string
    {
        if ($this->values === null) {
            return "";
        }

        $string = "";
        foreach ($this->values as $value) {
            if ($string !== "") {
                $string .= ", ";
            }

            if (is_string($value)) {
                if (strlen($value) > 13) {
                    $value = substr($value, 0, 10) . "...";
                }
                $string .= "'{$value}'";
                continue;
            }

            if (is_numeric($value)) {
                $value = (string) $value;
                if (strlen($value) > 8) {
                    $value = substr($value, 0, 5) . "...";
                }
                $string .= $value;
                continue;
            }

            if (is_bool($value)) {
                if ($value === true) {
                    $string .= "true";
                } else {
                    $string .= "false";
                }
                continue;
            }

            if ($value === null) {
                $string .= "null";
                continue;
            }

            if (is_array($value)) {
                $string .= "array";
                continue;
            }

            if ($value instanceof MatcherAbstract) {
                $string .= (string) $value;
                continue;
            }

            if (is_object($value)) {
                $string .= get_class($value);
                continue;
            }

            $string .= "UNKNOWN";
        }

        return $string;
    }
}
