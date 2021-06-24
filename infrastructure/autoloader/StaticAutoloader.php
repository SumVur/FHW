<?php


namespace infrastructure\autoloader;

require('./infrastructure/autoloader/autoloader.php');


class StaticAutoloader
{
    /**
     * @var autoloader
     */
    private static $autoloader;

    private static $initialized = false;

    public static function initialize()
    {
        if (self::$initialized)
            return;

        self::$autoloader = new autoloader();
        self::$autoloader->register();
        self::$autoloader->addNamespace('infrastructure','infrastructure');
        self::$autoloader->addNamespace('infrastructure\autoloader;','infrastructure/autoloader;');
        self::$autoloader->addNamespace('infrastructure\ReflectionClassReader;','infrastructure/ReflectionClassReader;');
        self::$initialized = true;
    }

    public static function addNamespace($className)
    {
        self::initialize();
        $classPath = self::prepareToLoad($className);
        self::$autoloader->addNamespace(str_ireplace(DIRECTORY_SEPARATOR, "\\", $classPath), $classPath);
    }

    private static function prepareToLoad($className): string
    {
        $Path = explode(DIRECTORY_SEPARATOR, $className);
        if ($Path[0] == $className) {
            $Path = explode('\\', $className);
        }
        array_pop($Path);
        $Path = implode("/", $Path);
        return $Path;
    }
}