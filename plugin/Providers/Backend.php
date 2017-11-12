<?php

namespace Glue\Plugin\Providers;

class Backend
{
	public function booting($plugin)
    {
    	$plugin->activating('Glue\Plugin\Modules\Activator@activate');
    	$plugin->deactivating('Glue\Plugin\Modules\Activator@deactivate');
    }

	public function booted($plugin)
    {
    	// ...
    }
}