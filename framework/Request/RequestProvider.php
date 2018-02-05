<?php

namespace GlueNamespace\Framework\Request;

use GlueNamespace\Framework\Foundation\Provider;

class RequestProvider extends Provider
{
    /**
     * The provider booting method to boot this provider
     *
     * @return void
     */
    public function booting()
    {
        $this->app->bindSingleton('request', function ($app) {
            return new Request($app, $_GET, $_POST, $_FILES);
        }, 'Request', 'GlueNamespace\Framework\Request\Request');
    }
}
