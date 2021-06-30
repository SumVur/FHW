<?php


namespace infrastructure\ReflectionClassReader\DTO;


class ReflectionMethodInfo
{
    private string $methodName;

    private array $parameters;

    /**
     * @return string
     */
    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * @param string $methodName
     */
    public function setMethodName(string $methodName): void
    {
        $this->methodName = $methodName;
    }

    /**
     * @return mixed
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param mixed $parameters
     */
    public function setParameters(ReflectionMethodParameterInfo $parameter ): void
    {
        $this->parameters[] = $parameter;
    }
}