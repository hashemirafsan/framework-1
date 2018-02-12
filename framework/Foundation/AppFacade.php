<?php

namespace GlueNamespace\Framework\Foundation;

abstract class AppFacade
{
    /**
     * $instance Application
     *
     * @var \GlueNamespace\Framework\Foundation\Application
     */
    public static $instance = null;

    /**
     * Sets the app instance from Application
     *
     * @param \GlueNamespace\Framework\Foundation\Application $instance
     */
    public static function setApplication($instance)
    {
        static::$instance = $instance;
    }

    /**
     * Get the app instance stored earlier during the bootstrap
     *
     * @param \GlueNamespace\Framework\Foundation\Application $instance
     */
    public static function getApplication()
    {
        return static::$instance;
    }

    /**
     * Resolve the aliased class dynamically
     *
     * @param string $method
     * @param string $params
     *
     * @return mixed
     */
    public static function __callStatic($method, $params)
    {
        return call_user_func_array([
            static::$instance->make(static::$key),
            $method
        ], $params);
    }
}
