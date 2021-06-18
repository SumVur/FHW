<?php


namespace infrastructure\objectManager;


use app\test\test;
use http\Params;
use infrastructure\autoloader\autoloader;

class objectManager
{
    /**
     * @var autoloader
     */
    private static $autoloader;

    private static $initialized = false;

    private static function initialize()
    {
        if (self::$initialized)
            return;

        self::$autoloader = new autoloader();
        self::$autoloader->register();
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
        self::loadClass($className);
        $ReflectionClass = new \ReflectionClass($className);
        $constructor = $ReflectionClass->getConstructor();
        if ($constructor)
        {
            if ($constructor->getNumberOfParameters())
            {
                $parameters = $constructor->getParameters();

                $classParams = [];
                foreach ($parameters as $parameter) {
                    $classParams[] = self::create($parameter->getClass()->getName());
                }
                return new $className(...$classParams);
            }
        }
        return new $className();
    }

    private static function loadClass($className)
    {
        $classPath = self::prepareToLoad($className);
        self::$autoloader->addNamespace(str_ireplace(DIRECTORY_SEPARATOR, "\\", $classPath), $classPath);
    }

    /**
     * @param $className
     */
    private static function normalized(&$className)
    {
        $className = str_ireplace(DIRECTORY_SEPARATOR, "\\", $className);
    }

    /**
     * @param $className
     * @return string
     */
    private static function prepareToLoad($className)
    {
        $Path = explode(DIRECTORY_SEPARATOR, $className);
        if ($Path[0] == $className)
        {
            $Path = explode('\\', $className);
        }
        array_pop($Path);
        $Path = implode("/", $Path);
        return $Path;
    }
}