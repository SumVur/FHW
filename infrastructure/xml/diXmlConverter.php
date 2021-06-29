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
        $tmpParameters = [];
        foreach ($simpleXMLElement->children() as $firstChild) {
            switch ($firstChild->getName()) {
                case self::CLASS_NODE:
                {
                    $tmpParameters = array_merge_recursive(
                        $tmpParameters,
                        $this->classProcessing->classProcessing($firstChild)
                    );
                    break;
                }
                case self::VIRTUAL_TYPE_NODE:
                {
                    $tmpParameters = array_merge_recursive(
                        $tmpParameters,
                        $this->virtualTypeProcessing->virtualTypeProcessing($firstChild)
                    );
                    break;
                }
            }
        }
        $this->refactoringParameters($tmpParameters);
        return $this->result;
    }

    private function refactoringParameters($tmpParameters)
    {
        foreach ($tmpParameters[self::CLASS_NODE] as $classkey => $class) {
            foreach ($class as $keyParameters => $parameters) {

                if (array_key_exists($parameters, $tmpParameters[self::VIRTUAL_TYPE_NODE])) {
                    $classPath = $tmpParameters[self::VIRTUAL_TYPE_NODE][$parameters];
                    if ($classPath) {
                        $this->result = array_merge_recursive(
                            $this->result,
                            [
                                $classkey => [
                                    $keyParameters => $classPath
                                ]
                            ]
                        );
                    }
                } else {
                    $this->result = array_merge_recursive(
                        $this->result,
                        [
                            $classkey => [
                                $keyParameters => $parameters
                            ]
                        ]
                    );
                }
            }
        }
    }

}