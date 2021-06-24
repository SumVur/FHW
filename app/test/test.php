<?php


namespace app\test;


class test
{

    /**
     * @var person\person
     */
    private $person;

    /**
     * test constructor.
     * @param person\infrastructure\personInfrastructure $person
     */
    public function __construct(
        \app\test\person\infrastructure\personInfrastructure $person
    )
    {
        $this->person = $person;
        $this->person->setName('Alex');
    }

    /**
     * @return string
     */
    public function Get()
    {
        return $this->person->getName();
    }
}