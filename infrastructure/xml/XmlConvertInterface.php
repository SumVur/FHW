<?php


namespace infrastructure\xml;


interface XmlConvertInterface
{
    /**
     * @param \SimpleXMLElement $simpleXMLElement
     * @return array
     */
    public function convert(\SimpleXMLElement  $simpleXMLElement): array;
}