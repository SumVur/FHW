<?php


namespace infrastructure\xml\Processors;


class virtualTypeProcessing
{
    /**
     * Nods
     */
    private const ARGUMENT_NODE = 'argument';
    /**
     * Attributes
     */
    private const ATTRIBUTE_ARGUMENT_PARAMETER_NAME = 'name';

    public function virtualTypeProcessing(\SimpleXMLElement $classElement): array
    {
        $name = (string)$classElement->attributes()[self::ATTRIBUTE_ARGUMENT_PARAMETER_NAME];
        if ($name) {
            foreach ($classElement->children() as $elements) {
                if ($elements->getName() == self::ARGUMENT_NODE) {
                    return [
                        "virtualType" => [$name => (string)$elements]
                    ];
                }
            }
        }
        return [];
    }

}