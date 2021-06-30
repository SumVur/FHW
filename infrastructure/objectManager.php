<?php


namespace infrastructure;


use infrastructure\autoloader\StaticAutoloader;
use infrastructure\ReflectionClassReader\DTO\ReflectionClassInfo;
use infrastructure\ReflectionClassReader\DTO\ReflectionMethodTypes;
use infrastructure\ReflectionClassReader\ReflectionClassReader;
use infrastructure\xml\XmlReader;

class objectManager
{
    private static $DiParams = [];
    private static $initialized = false;

    private static function initialize()
    {
        if (self::$initialized)
            return;

        $xmlReader = new XmlReader();
        self::$DiParams = $xmlReader->read('./app');
        self::$initialized = true;
    }

    /**
     * @param $className
     * @return mixed
     * @throws \ReflectionException
     */
    public static function create($className)
    {
        self::initialize();

        self::normalized($className);

        StaticAutoloader::addNamespace($className);

        $classParams = [];

        self::fillClassParams($classParams, $className);

        return new $className(...$classParams);
    }


    /**
     * @param $className
     */
    private static function normalized(&$className)
    {
        $className = str_ireplace(DIRECTORY_SEPARATOR, "\\", $className);
    }


    private static function fillClassParams(&$classParams, $className)
    {
        $ReflectionClass = new ReflectionClassReader($className);

        foreach ($ReflectionClass->getConstructParameters() as $parameter) {
            /**
             * @var ReflectionClassInfo $parameter
             */

            switch ($parameter->getType()) {
                case ReflectionMethodTypes::CLASS_TYPE:
                {
                    $classParams[] = self::create($parameter->getPath());
                    break;
                }
                case ReflectionMethodTypes::INTERFACE_TYPE:
                {
                    $classParams[] = self::create(self::$DiParams[$className]['Arguments'][$parameter->getName()]);
                }
            }
        }
    }
}