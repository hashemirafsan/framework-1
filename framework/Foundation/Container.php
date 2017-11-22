<?php

namespace GlueNamespace\Framework\Foundation;

use Closure;
use ArrayAccess;
use ReflectionClass;
use ReflectionParameter;
use GlueNamespace\Framework\Exception\UnResolveableEntityException;

class Container implements ArrayAccess
{   
    /**
     * $container The service container
     * @var array
     */
    protected static $container = array(
        'facades' => array(),
        'aliases' => array(),
        'bindings' => array(),
        'singletons' => array(),
        'resolved' => array(),
    );

    /**
     * Bind an instance into service container
     * @param  string $key identifier
     * @param  mixed $concrete
     * @param  string $facade [optional facade]
     * @param  string $alias [optional alias]
     * @return void
     */
    public function bind($key, $concrete, $facade = null, $alias = null)
    {
        static::$container['bindings'][$key] = $concrete;

        if ($facade) {
            $this->facade($key, $facade);
        }

        if ($alias) {
            $this->alias($key, $alias);
        }
    }

    /**
     * Bind a singleton instance into service container
     * @param  string $key identifier
     * @param  mixed $concrete
     * @param  string $facade [optional facade]
     * @param  string $alias [optional alias]
     * @return void
     */
    public function bindSingleton($key, $concrete, $facade = null, $alias = null)
    {
        static::$container['singletons'][$key] = $concrete;

        if ($facade) {
            $this->facade($key, $facade);
        }

        if ($alias) {
            $this->alias($key, $alias);
        }
    }

    /**
     * Bind a singleton instance into service container
     * @param  string $key identifier
     * @param  mixed $concrete
     * @param  string $facade [optional facade]
     * @param  string $alias [optional alias]
     * @return void
     */
    public function bindInstance($key, $concrete, $facade = null, $alias = null)
    {
        $this->bindSingleton($key, function() use ($concrete) {
            return $concrete;
        }, $facade, $alias);
    }

    /**
     * Register a facade for a registered instance
     * @param  string $key
     * @param  string $facade
     * @return string
     */
    public function facade($key, $facade)
    {
        static::$container['facades'][$facade] = $key;
    }

    /**
     * Register an alias for a registered instance
     * @param  string $key
     * @param  string $alias
     * @return string
     */
    public function alias($key, $aliases)
    {
        foreach ((array) $aliases as $alias) {
            static::$container['aliases'][$alias] = $key;
        }
    }

    /**
     * Resolve an instance from container
     * @param  string $key
     * @return mixed
     * @throws \NewPluginTest\Framework\Exception\UnResolveableEntityException
     */
    public function make($key = null, array $params = [])
    {
        if (!$key) {
            return AppFacade::getApplication();
        }

        $key = $this->getAlias($key);

        if (isset(static::$container['resolved'][$key])) {
            return static::$container['resolved'][$key];
        }

        if (isset(static::$container['singletons'][$key])) {
            return static::$container['resolved'][$key] = $this->resolve(
                static::$container['singletons'][$key]
            );
        }

        if (isset(static::$container['bindings'][$key])) {
            return $this->resolve(static::$container['bindings'][$key]);
        }

        if (class_exists($key)) {
            return $this->build($key);
        }

        $this->cantResolveComponent($key);
    }

    /**
     * Build a concrete class with all dependencies
     * @param string $key FQN class name
     * @return mixed resolved instance
     */
    public function build($key)
    {
        $reflector = new ReflectionClass($key);

        if (!$reflector->isInstantiable()) {
            return $this->cantResolveComponent($key);
        }

        if (!$constructor = $reflector->getConstructor()) {
            return new $key;
        }

        $dependencies = $this->resolveDependencies(
            $constructor->getParameters()
        );

        return $reflector->newInstanceArgs($dependencies);
    }

    /**
     * Resolve all dependencies of a single class
     * @param  array $dependencies Constructor Parameters
     * @return array An array of all the resolved dependencies of one class
     */
    protected function resolveDependencies(array $dependencies)
    {
        $results = [];
        foreach ($dependencies as $dependency) {
            $results[] = $this->resolveClass($dependency);
        }
        return $results;
    }

    /**
     * Resolves a single class instance
     * @param  ReflectionParameter $parameter
     * @return mixed
     * @throws Exception
     */
    protected function resolveClass(ReflectionParameter $parameter)
    {
        try {
            return $this->make($parameter->getClass()->name);
        }
        catch (\Exception $exception) {
            if ($parameter->isOptional()) {
                return $parameter->getDefaultValue();
            }
            throw $exception;
        }
    }

    /**
     * Get the alias for a key if available.
     * @param  string  $key
     * @return string
     */
    public function getAlias($key)
    {
        if (isset(static::$container['aliases'][$key])) {
            return static::$container['aliases'][$key];
        }

        return $key;
    }

    /**
     * Resolve an item from the container
     * @param  mixed $value
     * @return mixed
     */
    protected function resolve($value)
    {
        return $value instanceof Closure ? $value($this) : $value;
    }

    /**
     * Check if an item exists at a given offset
     * @param  string  $offset
     * @return bool
     */
    public function bound($offset)
    {
        return isset(static::$container['resolved'][$offset]) ||
        isset(static::$container['bindings'][$offset]) ||
        isset(static::$container['singletons'][$offset]);
    }

    /**
     * Check if an item exists at a given offset
     * @param  string  $offset
     * @return bool
     */
    public function has($offset)
    {
        return $this->bound($offset);
    }

    /**
     * Throws exception if $this->make() can't
     * resolve anything from the container.
     * @param  string $key
     * @throws use GlueNamespace\Framework\Exception\UnResolveableEntityException
     */
    protected function cantResolveComponent($key)
    {
    	throw new UnResolveableEntityException(
            'The service ['.$key.'] doesn\'t exist in the container.'
        );
    }

    /**
     * Check if an item exists at a given offset
     * @param  string  $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->bound($offset);
    }

    /**
     * Get the value from given offset
     * @param  string  $offset
     * @param  mixed   $value
     * @return void
     */
    public function offsetGet($offset)
    {
        return $this->make($offset);
    }

    /**
     * Set the value at a given offset
     * @param  string  $offset
     * @param  mixed   $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        static::$container['singletons'][$offset] = function() use ($value) {
            return $value;
        };
    }

    /**
     * Unset the value at a given offset
     * @param  string  $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset(
            static::$container['resolved'][$offset],
            static::$container['bindings'][$offset],
            static::$container['singletons'][$offset],
            static::$container['aliases'][$offset],
            static::$container['facades'][$offset]
        );
    }
}
