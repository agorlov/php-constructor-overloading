<?php

namespace AG;

use Exception;
use ReflectionObject;
use ReflectionMethod;

/**
 * Constructor, wich applies to argument list
 *
 *
 * @author Alexandr Gorlov <a.gorlov@gmail.com>
 */
final class OverloadedConstructor
{
    private $obj;
    private $args;

    public function __construct($obj, $args)
    {
        $this->obj = $obj;
        $this->args = $args;
    }

    public function constructor(): string
    {
        foreach ($this->constructors() as $method) {

            if ($this->matchSignature($method)) {
                return $method->getName();
            }
        }

        if (count($this->constructors()) == 0) {
            throw new Exception("No constructors found. They must be private and constr... prefix!");
        }

        throw new Exception("No suitable constructor found");
    }


    private function matchSignature($method)
    {
        foreach ($method->getParameters() as $i => $param) {

            if (!isset($this->args[$i])) {
                return false;
            }

            if (gettype($this->args[$i]) == 'integer' && $param->getType() == 'int') {
                continue;
            }

            if (gettype($this->args[$i]) == 'double' && $param->getType() == 'float') {
                continue;
            }

            if (gettype($this->args[$i]) == 'string' && $param->getType() == 'string') {
                continue;
            }

            if (gettype($this->args[$i]) == 'array' && $param->getType() == 'array') {
                continue;
            }

            if (gettype($this->args[$i]) == 'boolean' && $param->getType() == 'boolean') {
                continue;
            }

            if (gettype($this->args[$i]) == 'boolean' && $param->getType() == 'bool') {
                continue;
            }



            if (gettype($this->args[$i]) == 'object' && $param->getType() == 'callable' && is_callable($this->args[$i])) {
                continue;
            }

            if (gettype($this->args[$i]) == 'object') {
                $type = (string)$param->getType();
                if ($this->args[$i] instanceof $type) {
                    continue;
                }
            }

            return false;
        }

        if (count($this->args) === count($method->getParameters())) {
            return true; // MATCH
        }
    }


    private function constructors(): array
    {
        return array_filter(
            (new ReflectionObject($this->obj))->getMethods(ReflectionMethod::IS_PRIVATE),
            function ($method) {
                return strpos($method->name, 'constr') !== false;
            }
        );

    }
}
                                                                                                   
