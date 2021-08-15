<?php

namespace duncan3dc\Mock;

use ReflectionFunction;
use ReflectionParameter;

class ClosureGenerator
{
    /**
     * @var string
     */
    private $function;

    /**
     * @var array<mixed>|null
     */
    private $arguments;


    public function __construct(string $function)
    {
        $this->function = $function;
    }


    public function generate(): callable
    {
        $arguments = $this->getArguments();

        $code = "return function(";

        $parameters = "";
        $first = true;
        foreach ($arguments as $parameter) {
            if ($first) {
                $first = false;
            } else {
                $code .= ",";
                $parameters .=  ",";
            }

            if ($parameter->isPassedByReference()) {
                $code .= "&";
                $parameters .= "&";
            }
            $code .= "\$" . $parameter->getName();
            $parameters .= "\$" . $parameter->getName();

            if ($parameter->isOptional()) {
                $code .= "=null";
            }
        }

        $code .= ") {";
        $code .= "\$parameters = [{$parameters}];";

        # If the call included less parameters than the function defines, only include the number of parameters actually passed
        $code .= "\$parameters = array_slice(\$parameters, 0, func_num_args());";

        # If the call included more parameters than the function defines, ensure we pass along every parameter actually passed
        $code .= "\$parameters = array_merge(\$parameters, array_slice(func_get_args(), count(\$parameters), func_num_args() - count(\$parameters)));";

        $code .= "return " . CoreFunction::class . "::call('{$this->function}', new " . Arguments::class . "(\$parameters));";
        $code .= "};";

        return eval($code);
    }


    /**
     * @return ReflectionParameter[]
     */
    private function getArguments(): iterable
    {
        if ($this->arguments === null) {
            $reflection = new ReflectionFunction($this->function);
            $this->arguments = $reflection->getParameters();
        }

        return $this->arguments;
    }
}
