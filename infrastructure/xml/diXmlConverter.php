<?php


namespace infrastructure\xml;


use infrastructure\xml\Processors\classProcessing;
use infrastructure\xml\Processors\virtualTypeProcessing;

class diXmlConverter implements XmlConvertInterface
{
    private const CLASS_NODE = 'class';
    private const  VIRTUAL_TYPE_NODE = 'virtualType';

    /**
     * @var classProcessing
     */
    private $classProcessing;
    private $virtualTypeProcessing;

    private array $result = [];

    public function __construct()
    {
        $this->classProcessing = new classProcessing();
        $this->virtualTypeProcessing = new virtualTypeProcessing();
    }

    /**
     * @param \SimpleXMLElement $simpleXMLElement
     * @return array
     */
    public function convert(\SimpleXMLElement $simpleXMLElement): array
    {
        foreach ($simpleXMLElement->children() as $firstChild) {
            switch ($firstChild->getName()) {
                case self::CLASS_NODE:
                {
                    $this->result = array_merge_recursive(
                        $this->result,
                        $this->classProcessing->classProcessing($firstChild)
                    );
                    break;
                }
                case self::VIRTUAL_TYPE_NODE:
                {
                    $this->result = array_merge_recursive(
                        $this->result,
                        $this->virtualTypeProcessing->virtualTypeProcessing($firstChild)
                    );
                    break;
                }
            }
        }
        return $this->result;
    }



}