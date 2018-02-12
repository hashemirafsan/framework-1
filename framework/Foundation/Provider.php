<?php

namespace GlueNamespace\Framework\Foundation;

abstract class Provider
{
    /**
     * $app \Framework\Foundation\Application
     *
     * @var null
     */
    protected $app = null;

    /**
     * Build the instance
     *
     * @param \GlueNamespace\Framework\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Booted method for any provider
     */
    public function booted()
    {
        // ...
    }

    /**
     * Abstract booting method for provider
     */
    abstract public function booting();
}
