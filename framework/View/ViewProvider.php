<?php

namespace GlueNamespace\Framework\View;

use GlueNamespace\Framework\Foundation\Provider;

class ViewProvider extends Provider
{
	/**
     * The provider booting method to boot this provider
     * @return void
     */
	public function booting()
	{
		$this->app->bind('view', function($app) {
			return new View($app);
		}, 'View', 'GlueNamespace\Framework\View\View');
	}
}
