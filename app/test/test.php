<?php


namespace app\test;


class test
{

    /**
     * @var person\person
     */
    private $person;


    public function __construct(
        \app\test\person\person $person
    )
    {
        $this->person = $person;
        $this->person->setName('Alex');
    }

    public function Get()
    {
        return $this->person->getName();
    }
}