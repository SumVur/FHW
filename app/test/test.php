<?php


namespace app\test;


class test
{

    /**
     * @var person\person
     */
    private $person;
    private $person2;

    /**
     * test constructor.
     * @param person\infrastructure\personInfrastructure $person
     */
    public function __construct(
        \app\test\person\infrastructure\personInfrastructure $person,
        \app\test\person\infrastructure\personInfrastructure $person2
    )
    {
        $this->person = $person;
        $this->person->setName('1');
        $this->person2 = $person2;
        $this->person2->setName('2');
    }

    /**
     * @return string
     */
    public function Get()
    {
        return $this->person->getName()."--".$this->person2->getName();
    }
}