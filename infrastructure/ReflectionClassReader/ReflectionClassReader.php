<?php

namespace infrastructure\ReflectionClassReader;


use mysql_xdevapi\Exception;

class ReflectionClassReader
{


    /**
     * @var ReflectionClass
     */
    private $ReflectionClass;

    /**
     * ReflectionClassReader constructor.
     * @param string $className
     * @throws \ReflectionException
     */
    public function __construct(string $className)
    {
        $this->ReflectionClass = new \ReflectionClass($className);
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getClassConstructParameters(): array
    {
        $constructor = $this->ReflectionClass->getConstructor();
        if ($constructor) {
            $parameters = $constructor->getParameters();
            $classParams = [];
            foreach ($parameters as $parameter) {
                if (!$parameter->getType()->isBuiltin()) {
                    try {
                        $parameterClassName = $parameter->getClass()->getName();
                        $this->parameterReflection($classParams, $parameterClassName, $parameter->name);
                    } catch (Exception $e) {
                    }
                } else {

                }
            }
            return $classParams;
        }
        return [];
    }

    /**
     * @param $classParams
     * @param $parameterClassName
     * @param $parameterName
     * @throws \ReflectionException
     */
    private function parameterReflection(&$classParams, $parameterClassName, $parameterName)
    {
        $parameterClass = new ReflectionClassInfo();
        $parameterClass->setName($parameterName);
        $parameterClass->setPath($parameterClassName);
        $parameterReflection = new \ReflectionClass($parameterClassName);
        if ($parameterReflection->isInterface()) {
            $parameterClass->setType(ReflectionClassTypes::INTERFACE_TYPE);
        } else {
            $parameterClass->setType(ReflectionClassTypes::CLASS_TYPE);
        }

        $classParams[] = $parameterClass;
    }
}