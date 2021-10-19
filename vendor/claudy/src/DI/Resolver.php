<?php
/**
 * Fichier de résolution de l'injection de dépense
 */
namespace Ladis\DI;

use ReflectionParameter;
/**
 * @author Claude Fassinou <dev.claudy@gmail.com>
 * @license 
 * 
 * @copyright 2021 Ladiscode
 */
class Resolver
{
    /**
     * 
     *
     * @var BuilderReflector
     */
    private $reflector;

    /**
     * Résolution de l'injection de dépense
     *
     * @param string  $alias
     * @return object
     */
    public function resolve(string $alias, array $args =[])
    {
        //Si l'alias est un object on le renvoie aussitôt
        if (is_object($alias)) {
            return $alias;
        }
        //Si c'est une chaine de caractère (namespace)
        if (is_string($alias)) {
            $this->reflector = new BuilderReflector($alias);

            /**
             * Si le constructor est sans argument
             */
            if ($this->reflector->canBeInstantiable()) {
                if ($this->reflector->getConstructor() == null) {
                    return $this->reflector->getInstance();
                }
                /**
                 * WithContructor
                 */
                else {
                    return $this->withContructor($args);
                }
            }
        }
    }


    /**
     * Renvoie une instance de class avec contructeur
     *
     * @return object
     */
    private function withContructor(array $args =[])
    {

        /**
         * @var array
         */
        $parameters = $this->reflector->getConstructor()->getParameters();

        /**
         * Si le contructeur n'a aucun argument
         */
        if ($parameters == []) {
            return $this->reflector->getInstanceWithArgs(array());
        } else {

            $arguments = array();
            foreach ($parameters as  $parameter) {
                $parameter = $this->reflParam($parameter);
                if (!$parameter->hasType()) {
                    if ($parameter->isDefaultValueAvailable()) {
                        $pos = $parameter->getPosition();
                        $arguments[$pos] = $parameter->getDefaultValue();
                    }

                    if ($parameter->isDefaultValueConstant()) {
                        $pos = $parameter->getPosition();
                        $arguments[$pos] = $parameter->getDefaultValue();
                    }
                }
                /**
                 * Si l'argument a un type
                 */
                else{
                    $pos = $parameter->getPosition();
                   
                    $classType = $parameter->getType();

                    $class_name =$classType->getName();

                    $container = new Container;
                    $typeget= $container->get($class_name);
                    $arguments[$pos] = $typeget;
                    
                }
            }

            if ($args ==[]) {
                $fullArgs = $arguments;
            }else{
                $fullArgs = $args; 
            }
            return $this->reflector->getInstanceWithArgs($fullArgs);
        }

        //dd($this->reflector);
    }

    /**
     * Renvoie une instance de ReflectionParameter
     * @param ReflectionParameter $parameter
     * @return ReflectionParameter
     */
    private function reflParam(ReflectionParameter $parameter): ReflectionParameter
    {
        return $parameter;
    }
}
