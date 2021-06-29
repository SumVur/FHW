<?php


namespace app\test;


use app\test\person\person;

class test
{

    /**
     * @var person\person
     */
    private $person;
    private $person2;
    private person $person3;

    /**
     * test constructor.
     * @param person\infrastructure\personInfrastructure $person
     */
    public function __construct(
        \app\test\person\infrastructure\personInfrastructure $person,
        \app\test\person\person $person3
    )
    {
        $this->person = $person;
        $this->person->setName('1');
        $this->person3 = $person3;
        $this->person3->setName('3');
    }

    /**
     * @return string
     */
    public function Get()
    {

        return $this->person->getName().
            "--".
            $this->person3->getName();
    }
}