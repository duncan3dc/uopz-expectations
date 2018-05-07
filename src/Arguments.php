<?php

namespace duncan3dc\Mock;

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
     * @var array|null $values The arguments this instance represents.
     */
    private $values;


    /**
     * Create a new instance.
     *
     * @param array $values The arguments this instance represents.
     */
    public function __construct(array $values = null)
    {
        $this->values = $values;
    }


    /**
     * Get the values these arguments represent.
     *
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
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

            if (is_object($value)) {
                $string .= get_class($value);
                continue;
            }

            $string .= "UNKNOWN";
        }

        return $string;
    }
}
