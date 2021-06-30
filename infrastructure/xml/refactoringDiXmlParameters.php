<?php


namespace infrastructure\xml;


class refactoringDiXmlParameters
{
    private const CLASS_NODE = 'class';
    private const  VIRTUAL_TYPE_NODE = 'virtualType';

    public static  function refactoringParameters($parameters)
    {
        $newParameters = [];
        foreach ($parameters[self::CLASS_NODE] as $classKey => $class) {
            self::argumentsRefactoring($class['Arguments'],$parameters,$newParameters,$classKey);
        }
        return $newParameters;
    }
    private function pluginRefactoring(array $plugins,$classKey)
    {
        foreach ($plugins as $keyPlugin=>$plugin)
        {

        }
    }
    private function argumentsRefactoring(array $arguments, &$pastParameters,&$newParameters, $classKey)
    {
        foreach ($arguments as $index => $argument) {
            if (array_key_exists($argument, $pastParameters[self::VIRTUAL_TYPE_NODE])) {
                $classPath = $pastParameters[self::VIRTUAL_TYPE_NODE][$argument];
                if ($classPath) {
                    $newParameters = array_merge_recursive(
                        $newParameters,
                        [
                            $classKey => [
                                'Arguments' => [
                                    $index => $classPath
                                ]
                            ]
                        ]
                    );
                }
            } else {
                $newParameters = array_merge_recursive(
                    $newParameters,
                    [
                        $classKey => [
                            'Arguments' => [
                                $index => $argument
                            ]
                        ]
                    ]
                );
            }
        }
    }
}