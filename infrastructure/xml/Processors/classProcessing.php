<?php


namespace infrastructure\xml\Processors;


class classProcessing
{
    /**
     * Nods
     */
    private const ARGUMENTS_NODE = 'Arguments';
    private const ARGUMENT_NODE = 'argument';
    private const PLUGIN_NODE = 'Plugin';
    /**
     * Attributes
     */
    private const ATTRIBUTE_ID_KEY = 'type';
    private const ATTRIBUTE_ARGUMENT_PARAMETER_NAME = 'name';
    private const PLUGIN_PARAMETER_NAME = 'name';
    private const PLUGIN_PARAMETER_CLASS = 'class';


    /**
     * @var array
     */
    private array $result = [];
    /**
     * @var null
     */
    private $identifier = null;


    /**
     * @param \SimpleXMLElement $classElement
     * @return array
     */
    public function classProcessing(\SimpleXMLElement $classElement): array
    {
        $this->identifier = (string)$classElement->attributes()[self::ATTRIBUTE_ID_KEY];
        if ($this->identifier) {
            foreach ($classElement->children() as $secondChild) {
                switch ($secondChild->getName()) {
                    case self::ARGUMENTS_NODE:
                    {
                        $this->argumentsProcessing($secondChild);
                        break;
                    }
                    case self::PLUGIN_NODE:
                    {
                        $this->pluginProcessing($secondChild);
                        break;
                    }
                }
            }
        }

        return $this->result;
    }

    public function pluginProcessing(\SimpleXMLElement $argumentsElement)
    {
        $name = (string)$argumentsElement->attributes()[self::PLUGIN_PARAMETER_NAME];
        $class = (string)$argumentsElement->attributes()[self::PLUGIN_PARAMETER_CLASS];
        if($name&&$class)
        {
            $this->result = array_merge_recursive(
                $this->result,
                ["class" =>
                    [
                        $this->identifier => [
                            self::PLUGIN_NODE => [
                                $name => $class
                            ]
                        ]
                    ]
                ]
            );
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
        $type = (string)$argumentElement->attributes()[self::ATTRIBUTE_ARGUMENT_PARAMETER_NAME];
        $class = (string)$argumentElement;
        if ($type && $class) {
            $this->result = array_merge_recursive(
                $this->result,
                ["class" =>
                    [
                        $this->identifier => [
                            self::ARGUMENTS_NODE => [
                                $type => $class
                            ]
                        ]
                    ]
                ]
            );
        }
    }


}