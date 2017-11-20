<?php

/**
 * This provider will be loaded always (admin/public)
 */

namespace GlueNamespace\App\Providers;

use GlueNamespace\Framework\Foundation\Provider;

class CommonProvider extends Provider
{
	/**
     * The provider booting method to boot this provider
     * @return void
     */
	public function booting()
    {
    	// ...
    }

    /**
     * The provider booted method to be called after booting
     * @return void
     */
	public function booted()
    {
        // ...
    }
}