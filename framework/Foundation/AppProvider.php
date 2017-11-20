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
        // Framework is booted and ready
    	$app->booted(function($app) {
            $app->load($app->appPath('Global/Common.php'));
            $app->bootstrapWith($app->getCommonProviders());
        });

        // Application is booted and ready
        $app->ready(function($app) {
            $app->load($app->appPath('Hooks/Common.php'));
            if ($app->isUserOnAdminArea()) {
                $app->load($app->appPath('Hooks/Backend.php'));
            } else {
                $app->load($app->appPath('Hooks/Frontend.php'));   
            }
        });
    }
}