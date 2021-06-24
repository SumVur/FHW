<?php


namespace infrastructure\xml;


class DiXmlConverter implements XmlConvertInterface
{
    private const CLASS_NODE = 'class';
    private const ARGUMENTS_NODE = 'Arguments';
    private const ARGUMENT_NODE = 'argument';
    private const ATTRIBUTE_ID_KEY = 'type';
    private const ATTRIBUTE_ARGUMENT_TYPE = 'type';
    private const ATTRIBUTE_ARGUMENT_NAME = 'name';
    private array $result=[];
    private  $identifier=null;

    /**
     * @param \SimpleXMLElement $simpleXMLElement
     * @return array
     */
    public function convert(\SimpleXMLElement $simpleXMLElement): array
    {
        foreach ($simpleXMLElement->children() as $firstChild) {
            if ($firstChild->getName() == self::CLASS_NODE) {
                $this->classProcessing($firstChild);
            }
        }

        return $this->result;
    }

    /**
     * @param \SimpleXMLElement $classElement
     */
    private function classProcessing(\SimpleXMLElement $classElement)
    {
        $this->identifier = (string)$classElement->attributes()[self::ATTRIBUTE_ID_KEY];
        if($this->identifier) {
            foreach ($classElement->children() as $secondChild) {
                if ($secondChild->getName() == self::ARGUMENTS_NODE) {
                    $this->argumentsProcessing($secondChild);
                }
            }
        }
    }

    /**
     * @param \SimpleXMLElement $argumentsElement
     */
    private function argumentsProcessing(\SimpleXMLElement $argumentsElement)
    {
        foreach ($argumentsElement->children() as $thirdChild) {
            if ($thirdChild->getName() == self::ARGUMENT_NODE) {
                    $this->argumentProcessing($thirdChild);
            }
        }
    }

    /**
     * @param \SimpleXMLElement $argumentElement
     */
    private function argumentProcessing(\SimpleXMLElement $argumentElement)
    {
        if (!empty((array)$argumentElement->attributes()[self::ATTRIBUTE_ARGUMENT_NAME]) && !empty((array)$argumentElement->attributes()[self::ATTRIBUTE_ARGUMENT_TYPE])) {
            $this->result[$this->identifier] = [
                (string)$argumentElement->attributes()[self::ATTRIBUTE_ARGUMENT_NAME] => (string)$argumentElement->attributes()[self::ATTRIBUTE_ARGUMENT_TYPE]
            ];
        }
    }


}