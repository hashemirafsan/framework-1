<?php

namespace GlueNamespace\Framework\Foundation;

class AppProvider
{
    /**
     * The provider booting method to boot this provider
     * @param  GlueNamespace\Framework\Foundation\Application $app
     * @return void
     */
	public function booting(Application $app)
    {
        $app->bind('app', $app, 'App', Application::class);
    }

    /**
     * The provider booted method to be called after booting
     * @param  GlueNamespace\Framework\Foundation\Application $app
     * @return void
     */
	public function booted(Application $app)
    {
    	// ...
    }
}