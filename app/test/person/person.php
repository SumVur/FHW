<?php


namespace app\test\person;

/**
 * Class person
 * @package app\test\person
 */
class person implements infrastructure\personInfrastructure
{

    private $name;

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
    public function setName($name)
    {
        $this->name = $name;
    }
}