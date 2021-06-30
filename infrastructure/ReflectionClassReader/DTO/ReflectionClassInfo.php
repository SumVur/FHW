<?php


namespace infrastructure\ReflectionClassReader\DTO;

class ReflectionClassInfo
{
    private string $className;

    private array $classMethods;

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @param string $className
     */
    public function setClassName(string $className): void
    {
        $this->className = $className;
    }

    /**
     * @return array
     */
    public function getClassMethods(): array
    {
        return $this->classMethods;
    }
    public function getClassConstructor(): ReflectionClassInfo
    {

    }

    /**
     * @param ReflectionMethodInfo $methodInfo
     */
    public function setClassMethod(ReflectionMethodInfo $methodInfo): void
    {
        $this->classMethods[]=$methodInfo;
    }
}