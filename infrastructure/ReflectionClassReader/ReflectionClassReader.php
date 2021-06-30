<?php

namespace infrastructure\ReflectionClassReader;

use infrastructure\ReflectionClassReader\DTO\ReflectionClassInfo;
use infrastructure\ReflectionClassReader\DTO\ReflectionMethodInfo;
use infrastructure\ReflectionClassReader\DTO\ReflectionMethodParameterInfo;
use infrastructure\ReflectionClassReader\DTO\ReflectionMethodTypes;
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


    public function FullReflection(): ReflectionClassInfo
    {
        $reflectionClassInfo = new ReflectionClassInfo();
        $reflectionClassInfo->setClassName($this->ReflectionClass->name);
        foreach ($this->ReflectionClass->getMethods() as $method)
        {

            $reflectionClassInfo->setClassMethod($this->methodReflection($method));
        }
       return $reflectionClassInfo;
    }


    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getConstructParameters(): array
    {
        $constructor = $this->ReflectionClass->getConstructor();
        if ($constructor) {
                return $this->methodReflection($constructor)->getParameters();
        }
        return [];
    }

    public function methodReflection(\ReflectionMethod $method):ReflectionMethodInfo
    {
        $reflectionMethodInfo =new ReflectionMethodInfo();
        $reflectionMethodInfo->setMethodName($method->name);
        $parameters = $method->getParameters();
        foreach ($parameters as $parameter) {
            $reflectionMethodInfo->setParameters($this->reflectionMethodParameter($parameter));
        }
        return $reflectionMethodInfo;
    }

    public function reflectionMethodParameter(\ReflectionParameter $parameter):ReflectionMethodParameterInfo
    {
        $parameterInfo = new ReflectionMethodParameterInfo();
        $parameterInfo->setName($parameter->name);
        if (!$parameter->getType()->isBuiltin()) {
            try {
                $parameterInfo->setPath($parameter->getClass()->getName());
                $this->builtinParameterReflection($parameterInfo);
            } catch (Exception $e) {
            }
        } else {
            $parameterInfo->setType((string)$parameter->getType());
        }

        return $parameterInfo;
    }
    public function builtinParameterReflection(ReflectionMethodParameterInfo &$parameterInfo)
    {
        $parameterReflection = new \ReflectionClass($parameterInfo->getPath());
        if ($parameterReflection->isInterface()) {
            $parameterInfo->setType(ReflectionMethodTypes::INTERFACE_TYPE);
        } else {
            $parameterInfo->setType(ReflectionMethodTypes::CLASS_TYPE);
        }
    }

}