<?php


namespace infrastructure\autoGeneration;


class PluginGenerator implements CodeGenerationInterface
{
    private const TEMPLATE_FOLDER = 'template';
    private const CLASS_TEMPLATE = 'pluginTemplate.txt';
    private const METHOD_TEMPLATE = 'pluginMethodTemplate.txt';


    private const NAMESPACE_KEY = 'namespace';
    private const INTERCEPTED_KEY = 'intercepted_class';
    private const METHODS_CONTENT_KEY = 'methods_content';



    private function readTemplate(string $templateName)
    {
        file_get_contents(__DIR__.self::TEMPLATE_FOLDER.$templateName);
    }
    public function generate(string $className)
    {
        $namespacesChunks = explode('\\',$className);
        $className =array_pop($namespacesChunks);
        $namespace = implode('\\',$namespacesChunks);


    }
    private function getArguments(\ReflectionMethod $reflectionMethod)
    {
        $arguments = [];


        foreach ($reflectionMethod->getParameters() as $parameter)
        {
            $arguments[] = (string)$parameter->getType().' $'.$parameter->getName();
        }
        return implode(', ',$arguments);
    }
}