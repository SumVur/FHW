<?php


namespace app\test\person;

/**
 * Class person
 * @package app\test\person
 */
class person implements infrastructure\personInfrastructure
{

    private string $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
}