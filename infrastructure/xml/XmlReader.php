<?php


namespace infrastructure\xml;


class XmlReader
{
    /**
     * @return XmlConvertInterface
     */
    protected function getConverter(): XmlConvertInterface
    {
        return new DiXmlConverter();
    }

    /**
     * @param string $folder
     * @return array
     * @throws \Exception
     */
    public function read(string $folder): array
    {
        $converter = $this->getConverter();
        $result = [];
        $di = new \RecursiveDirectoryIterator($folder, \RecursiveDirectoryIterator::SKIP_DOTS);

        foreach (new \RecursiveIteratorIterator($di) as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) == "xml") {
                $xmlContent = file_get_contents($file);
                $result = array_replace_recursive(
                    $result,
                    $converter->convert(new \SimpleXMLElement($xmlContent))
                );
            }
        }
        return $result;
    }
}