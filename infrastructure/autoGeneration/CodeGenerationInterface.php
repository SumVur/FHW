<?php


namespace infrastructure\autoGeneration;


interface CodeGenerationInterface
{
    public function generate(string $className);
}