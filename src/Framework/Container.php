<?php

declare(strict_types=1);

namespace Framework;

use ReflectionClass;

class Container
{
    private array $definitions = [];
    private array $resolved = [];

    public function addDefinitions(array $newDefs): void
    {
        $this->definitions = [...$this->definitions, ...$newDefs];
    }

    /**
     * @throws \ReflectionException
     */
    public function resolve(string $className)
    {
        $reflectionClass = new ReflectionClass($className);

        // Check if the class can be instantiated
        if (!$reflectionClass->isInstantiable()) {
            throw new \RuntimeException("Class $className is not instantiable");
        }

        $constructor = $reflectionClass->getConstructor();

        // If the class has no constructor, return a new instance
        if (is_null($constructor)) {
            return new $className();
        }

        // Get the constructor parameters
        $params = $constructor->getParameters();

        // If there are no parameters, return a new instance
        if (empty($params)) {
            return new $className();
        }

        $dependencies = [];

        foreach ($params as $param) {
            $name = $param->getName();
            $type = $param->getType();

            if (!$type) {
                throw new \RuntimeException("Dependency Injection Exception: Parameter $name has no type hint");
            }

            if (!$type instanceof \ReflectionNamedType || $type->isBuiltin()) {
                throw new \RuntimeException("Dependency Injection Exception: Parameter $name is not a named type");
            }

            $dependencies[] = $this->get($type->getName());
        }
        return $reflectionClass->newInstanceArgs($dependencies);
    }

    public function get(string $className)
    {
        if (!array_key_exists($className, $this->definitions)) {
            throw new \RuntimeException("Dependency Injection Exception: Class $className not found in definitions");
        }

        if (array_key_exists($className, $this->resolved)) {
            return $this->resolved[$className];
        }

        $factory = $this->definitions[$className];
        $dependency = $factory($this);

        $this->resolved[$className] = $dependency;

        return $dependency;
    }


}