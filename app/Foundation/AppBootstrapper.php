<?php

namespace Glue\App\Foundation;

class AppBootstrapper
{
	public function booting($plugin)
    {
        $plugin->bind('app', $plugin, 'App');
    }

	public function booted($plugin)
    {
    	$plugin->booted(function($plugin) {
    		include $plugin->pluginPath('Routes/routes.php');
    	});
    }
}