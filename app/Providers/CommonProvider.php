<?php

namespace GlueNamespace\App\Providers;

use GlueNamespace\Framework\Foundation\Provider;

/**
 * This provider will be loaded always (admin/public)
 */
class CommonProvider extends Provider
{
    /**
     * The provider booting method to boot this provider
     */
    public function booting()
    {
        // ...
    }

    /**
     * The provider booted method to be called after booting
     */
    public function booted()
    {
        // ...
    }
}
